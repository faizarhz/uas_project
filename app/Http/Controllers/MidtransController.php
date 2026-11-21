<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class MidtransController extends Controller
{
    /** Endpoint "Payment Notification URL" yang dipanggil Midtrans. */
    public function notification(Request $request, MidtransService $midtrans)
    {
        $p = $request->json()->all() ?: $request->all();

        // Verifikasi: SHA512(order_id + status_code + gross_amount + ServerKey)
        $expected = hash('sha512',
            ($p['order_id'] ?? '') . ($p['status_code'] ?? '') . ($p['gross_amount'] ?? '') . config('midtrans.server_key')
        );

        if (! hash_equals($expected, (string) ($p['signature_key'] ?? ''))) {
            abort(403, 'Signature tidak valid');
        }

        $order = Order::where('number', $p['order_id'])->first();
        if (! $order) {
            return response()->json(['message' => 'order tidak ditemukan']);
        }

        // Pastikan nominal sama dengan pesanan kita.
        if ((int) round((float) $p['gross_amount']) !== (int) $order->total) {
            abort(400, 'Nominal tidak cocok');
        }

        $midtrans->applyStatus(
            $order,
            (string) ($p['transaction_status'] ?? ''),
            $p['fraud_status'] ?? null,
            $p['payment_type'] ?? null,
        );

        return response()->json(['ok' => true]);
    }
}
