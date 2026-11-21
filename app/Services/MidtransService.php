<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = (string) config('midtrans.server_key');
        Config::$isProduction = (bool) config('midtrans.is_production');
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function snapJsUrl(): string
    {
        return config('midtrans.is_production')
            ? 'https://app.midtrans.com/snap/snap.js'
            : 'https://app.sandbox.midtrans.com/snap/snap.js';
    }

    /** Minta Snap token ke Midtrans untuk sebuah pesanan. */
    public function createSnapToken(Order $order): string
    {
        if (! config('midtrans.server_key') || ! config('midtrans.client_key')) {
            throw new \RuntimeException('MIDTRANS_SERVER_KEY / MIDTRANS_CLIENT_KEY belum diisi di .env');
        }

        // Jumlah semua item_details harus sama dengan gross_amount.
        $items = collect($order->items)->map(fn ($i) => [
            'id'       => 'P' . $i['id'],
            'price'    => (int) $i['price'],
            'quantity' => (int) $i['qty'],
            'name'     => Str::limit($i['name'], 50, ''),
        ])->all();

        $items[] = [
            'id'       => 'SHIP',
            'price'    => (int) $order->shipping_cost,
            'quantity' => 1,
            'name'     => 'Ongkos kirim ' . $order->ship,
        ];

        $params = [
            'transaction_details' => [
                'order_id'     => $order->number,
                'gross_amount' => (int) $order->total,
            ],
            'item_details'     => $items,
            'customer_details' => array_filter([
                'first_name' => $order->customer_name,
                'email'      => $order->email,
                'phone'      => $order->phone,
            ]),
        ];

        return Snap::getSnapToken($params);
    }

    /** Terapkan status dari Midtrans (webhook atau pengecekan manual) ke pesanan. */
    public function applyStatus(Order $order, string $status, ?string $fraud = null, ?string $paymentType = null): void
    {
        $new = match (true) {
            $status === 'settlement'                                  => 'paid',
            $status === 'capture' && ($fraud === null || $fraud === 'accept') => 'paid',
            $status === 'capture'                                     => 'pending', // fraud challenge
            $status === 'pending'                                     => 'pending',
            in_array($status, ['deny', 'failure'], true)              => 'failed',
            $status === 'cancel'                                      => 'cancelled',
            $status === 'expire'                                      => 'expired',
            in_array($status, ['refund', 'partial_refund'], true)     => 'refunded',
            default                                                   => $order->status,
        };

        // Jangan turunkan pesanan yang sudah lunas ke "pending" karena notifikasi terlambat.
        if ($order->status === 'paid' && $new === 'pending') {
            return;
        }

        $order->status       = $new;
        $order->payment_type = $paymentType ?: $order->payment_type;
        if ($new === 'paid' && ! $order->paid_at) {
            $order->paid_at = now();
        }
        $order->save();
    }

    /** Tanya status terbaru ke Midtrans (berguna saat webhook belum bisa masuk, mis. di localhost). */
    public function syncStatus(Order $order): void
    {
        if ($order->pay !== 'Midtrans' || $order->status !== 'pending') {
            return;
        }

        try {
            $s = (array) Transaction::status($order->number);
            if (! empty($s['transaction_status'])) {
                $this->applyStatus($order, $s['transaction_status'], $s['fraud_status'] ?? null, $s['payment_type'] ?? null);
            }
        } catch (\Throwable $e) {
            // Transaksi belum dibuat di Midtrans (pelanggan belum memilih metode bayar) -> abaikan.
            report($e);
        }
    }
}
