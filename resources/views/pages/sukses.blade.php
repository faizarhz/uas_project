@extends('layouts.app')
@section('title', 'Pesanan – BEVERLY')

@php
    $badge = match ($order->status) {
        'paid', 'cod' => 'background:#e3f3e6;color:#2f6b3d',
        'failed', 'expired', 'cancelled', 'refunded' => 'background:#fdecea;color:#b3402a',
        default => 'background:#fbf1dc;color:#9a7a3e',
    };
@endphp

@section('content')
<div class="pad" style="text-align:center">
    <div class="ok">&#10003;</div>
    <span class="lbl">PESANAN DIBUAT</span>
    <h1 style="font-size:44px;font-weight:600;margin:6px 0">Terima Kasih atas Pesanan Anda!</h1>
    <p style="color:#6b5848">
        @if ($order->status === 'paid')
            Pembayaran Anda sudah kami terima. Pesanan akan segera diproses.
        @elseif ($order->status === 'cod')
            Pesanan Anda telah kami terima. Pembayaran dilakukan saat barang tiba.
        @elseif ($order->status === 'pending')
            Pesanan Anda telah kami terima dan sedang menunggu pembayaran.
        @else
            Status pesanan: {{ $order->status_label }}.
        @endif
    </p>

    <div class="card" style="max-width:960px;margin:32px auto;padding:24px;text-align:left">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap">
            <div><span class="lbl" style="font-size:12px">NOMOR PESANAN</span><br><b>{{ $order->number }}</b></div>
            <span style="{{ $badge }};padding:8px 16px;border-radius:10px;font-weight:500">{{ $order->status_label }}</span>
        </div>
        <hr style="border:0;border-top:1px solid var(--beige);margin:16px 0">

        @foreach ($order->items as $i)
            @php $p = \App\Support\Catalog::find($i['id']); @endphp
            <div class="item" style="align-items:center">
                <div style="width:50px;height:76px;flex:none"><x-rug :c="$p['c'] ?? ['#ccc','#aaa','#eee']" :image="$p['image'] ?? null" style="height:100%" /></div>
                <div style="flex:1"><b>{{ $i['name'] }}</b><br><span style="color:#6b5848">{{ $i['qty'] }} × Rp{{ number_format($i['price'], 0, ',', '.') }}</span></div>
            </div>
        @endforeach

        <div class="li" style="display:flex;justify-content:space-between;margin-top:8px"><span>Subtotal</span><span>Rp{{ number_format($order->subtotal, 0, ',', '.') }}</span></div>
        <div class="li" style="display:flex;justify-content:space-between"><span>Ongkos kirim ({{ $order->ship }})</span><span>Rp{{ number_format($order->shipping_cost, 0, ',', '.') }}</span></div>
        <div class="tot" style="display:flex;justify-content:space-between;margin-top:8px"><span>Total</span><span>Rp{{ number_format($order->total, 0, ',', '.') }}</span></div>

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:20px">
            <div><span class="lbl" style="font-size:12px">PEMBAYARAN</span><p>{{ $order->pay }}{{ $order->payment_type ? ' · ' . str_replace('_', ' ', $order->payment_type) : '' }}</p></div>
            <div><span class="lbl" style="font-size:12px">ALAMAT PENGIRIMAN</span><p>{{ $order->address }}, {{ $order->city }}, {{ $order->province }} {{ $order->postal }}</p></div>
        </div>
    </div>

    <div style="display:flex;gap:16px;justify-content:center;flex-wrap:wrap">
        @if ($order->status === 'pending' && $order->pay === 'Midtrans' && $order->snap_token)
            <a class="btn" href="{{ route('checkout.pay', $order->number) }}">Bayar Sekarang</a>
        @endif
        <a class="btn {{ $order->status === 'pending' ? 'out2' : '' }}" href="{{ route('products') }}">Lanjut Belanja</a>
        <a class="btn out2" href="{{ route('home') }}">Kembali ke Home</a>
    </div>
</div>
@endsection
