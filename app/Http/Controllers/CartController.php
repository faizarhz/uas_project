<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use App\Support\Catalog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public const SHIPPING = ['Reguler' => 25000, 'Ekspres' => 60000];
    public const PAYMENTS = ['Midtrans', 'COD'];

    public function add(int $id)
    {
        abort_unless(Catalog::find($id), 404);

        $cart = session('cart', []);
        $cart[] = $id;
        session(['cart' => $cart]);

        return back()->with('toast', 'Ditambahkan ke keranjang');
    }

    public function remove(int $index)
    {
        $cart = session('cart', []);
        unset($cart[$index]);
        session(['cart' => array_values($cart)]);

        return back();
    }

    public function checkout(Request $request)
    {
        $items = $this->items();
        $ship  = $request->query('ship', old('ship', 'Reguler'));
        $pay   = $request->query('pay', old('pay', 'Midtrans'));

        return view('pages.checkout', $this->totals($items, $ship) + compact('items', 'ship', 'pay'));
    }

    public function place(Request $request, MidtransService $midtrans)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:60',
            'last_name'  => 'nullable|string|max:60',
            'email'      => 'nullable|email|max:120',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string|max:255',
            'city'       => 'required|string|max:80',
            'province'   => 'required|string|max:80',
            'postal'     => 'required|string|max:10',
            'ship'       => 'required|in:' . implode(',', array_keys(self::SHIPPING)),
            'pay'        => 'required|in:' . implode(',', self::PAYMENTS),
        ]);

        $items = $this->items();
        if ($items->isEmpty()) {
            return redirect()->route('products')->with('toast', 'Keranjang masih kosong');
        }

        $t = $this->totals($items, $data['ship']);

        $order = Order::create([
            'number'        => 'BVL-' . now()->format('ymd') . '-' . strtoupper(Str::random(5)),
            'user_id'       => auth()->id(),
            'customer_name' => trim($data['first_name'] . ' ' . ($data['last_name'] ?? '')),
            'email'         => $data['email'] ?? auth()->user()?->email,
            'phone'         => $data['phone'],
            'address'       => $data['address'],
            'city'          => $data['city'],
            'province'      => $data['province'],
            'postal'        => $data['postal'],
            'ship'          => $data['ship'],
            'pay'           => $data['pay'],
            'subtotal'      => $t['sub'],
            'shipping_cost' => $t['ong'],
            'total'         => $t['total'],
            'status'        => $data['pay'] === 'COD' ? 'cod' : 'pending',
            'items'         => $items->groupBy('id')->map(function ($g) {
                $p = $g->first();
                return ['id' => $p['id'], 'name' => $p['name'], 'price' => $p['price'], 'qty' => $g->count()];
            })->values()->all(),
        ]);

        if ($data['pay'] === 'Midtrans') {
            try {
                $order->update(['snap_token' => $midtrans->createSnapToken($order)]);
            } catch (\Throwable $e) {
                report($e);
                $order->delete();

                return back()->withInput()->with('toast', 'Gagal terhubung ke Midtrans. Periksa kunci API di file .env.');
            }
        }

        session()->forget('cart');
        session()->push('my_orders', $order->number);

        return $data['pay'] === 'Midtrans'
            ? redirect()->route('checkout.pay', $order->number)
            : redirect()->route('checkout.success', $order->number);
    }

    /** Halaman yang membuka popup pembayaran Midtrans Snap. */
    public function pay(string $number, MidtransService $midtrans)
    {
        $order = $this->ownedOrder($number);

        if ($order->pay !== 'Midtrans' || $order->status !== 'pending' || ! $order->snap_token) {
            return redirect()->route('checkout.success', $number);
        }

        return view('pages.bayar', [
            'order'     => $order,
            'snapJs'    => $midtrans->snapJsUrl(),
            'clientKey' => config('midtrans.client_key'),
        ]);
    }

    public function success(string $number, MidtransService $midtrans)
    {
        $order = $this->ownedOrder($number);
        $midtrans->syncStatus($order);

        return view('pages.sukses', ['order' => $order->fresh()]);
    }

    private function ownedOrder(string $number): Order
    {
        $order = Order::where('number', $number)->firstOrFail();

        abort_unless(
            in_array($number, session('my_orders', []), true)
                || (auth()->check() && $order->user_id === auth()->id()),
            404
        );

        return $order;
    }

    private function items()
    {
        return collect(session('cart', []))->map(fn ($id) => Catalog::find($id))->filter()->values();
    }

    private function totals($items, string $ship): array
    {
        $sub = $items->sum('price');
        $ong = $items->isEmpty() ? 0 : (self::SHIPPING[$ship] ?? 25000);

        return ['sub' => $sub, 'ong' => $ong, 'total' => $sub + $ong];
    }
}
