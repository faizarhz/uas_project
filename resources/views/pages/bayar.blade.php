@extends('layouts.app')
@section('title', 'Pembayaran – BEVERLY')

@section('content')
<div class="pad" style="text-align:center">
    <span class="lbl">PEMBAYARAN</span>
    <h1 style="font-size:40px;font-weight:600;margin:6px 0">Selesaikan Pembayaran</h1>
    <p style="color:#6b5848">Nomor pesanan <b>{{ $order->number }}</b></p>

    <div class="card" style="max-width:480px;margin:28px auto;padding:28px">
        <div class="li tot" style="display:flex;justify-content:space-between;margin-bottom:20px">
            <span>Total</span><span>Rp{{ number_format($order->total, 0, ',', '.') }}</span>
        </div>
        <button id="pay-button" class="btn w">Bayar Sekarang</button>
        <p style="font-size:12px;color:#6b5848;margin-top:12px">
            Pilih Virtual Account, QRIS, e-wallet, atau kartu. Pembayaran diproses aman oleh Midtrans.
        </p>
    </div>

    <a href="{{ route('checkout.success', $order->number) }}" style="color:var(--gold);font-weight:600;font-size:14px">
        Lihat status pesanan
    </a>
</div>
@endsection

@push('scripts')
<script src="{{ $snapJs }}" data-client-key="{{ $clientKey }}"></script>
<script>
    const done = () => location.href = @json(route('checkout.success', $order->number));
    function bayar() {
        window.snap.pay(@json($order->snap_token), {
            onSuccess: done,
            onPending: done,
            onError: () => toast('Pembayaran gagal, silakan coba lagi.'),
            onClose: () => {}
        });
    }
    document.getElementById('pay-button').addEventListener('click', bayar);
    window.addEventListener('load', bayar);
</script>
@endpush
