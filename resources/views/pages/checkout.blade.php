@extends('layouts.app')
@section('title', 'Checkout – BEVERLY')

@section('content')
@php
    $user = auth()->user();
    $opt = fn ($name, $val, $desc, $cur, $extra = '') => compact('name', 'val', 'desc', 'cur', 'extra');
@endphp
<div style="padding:24px max(16px,6vw)">
    <h1 style="font-size:40px;font-weight:600">Checkout</h1>
    <p style="margin-bottom:20px;color:var(--gold);font-weight:500">1 Data Diri &rsaquo; 2 Pengiriman &rsaquo; 3 Pembayaran</p>

    @if ($items->isEmpty())
        <div class="card" style="padding:32px;text-align:center">
            <p style="margin-bottom:16px">Keranjang Anda masih kosong.</p>
            <a class="btn" href="{{ route('products') }}">Lihat Produk</a>
        </div>
    @else
    @if ($errors->any())<div class="alert">Mohon lengkapi data pada formulir di bawah.</div>@endif

    <form method="POST" action="{{ route('checkout.place') }}" class="split" style="grid-template-columns:1.1fr 1fr;gap:32px;min-height:auto">
        @csrf
        <div class="card" style="padding:24px;align-self:start">
            <h3 style="margin-bottom:12px">Data Pelanggan dan Alamat</h3>

            <div class="row f">
                <div><label>Nama Depan</label><input name="first_name" value="{{ old('first_name', $user ? explode(' ', $user->name)[0] : '') }}">@error('first_name')<div class="err">{{ $message }}</div>@enderror</div>
                <div><label>Nama Belakang</label><input name="last_name" value="{{ old('last_name') }}"></div>
            </div>
            <div class="f"><label>Email (untuk bukti pembayaran)</label><input name="email" type="email" value="{{ old('email', $user->email ?? '') }}" placeholder="email@contoh.com">@error('email')<div class="err">{{ $message }}</div>@enderror</div>
            <div class="f"><label>Nomor WhatsApp</label><input name="phone" value="{{ old('phone', $user->phone ?? '') }}">@error('phone')<div class="err">{{ $message }}</div>@enderror</div>
            <div class="f"><label>Alamat Lengkap</label><input name="address" value="{{ old('address') }}">@error('address')<div class="err">{{ $message }}</div>@enderror</div>
            <div class="row f">
                <div><label>Kota</label><input name="city" value="{{ old('city') }}">@error('city')<div class="err">{{ $message }}</div>@enderror</div>
                <div><label>Provinsi</label><input name="province" value="{{ old('province') }}">@error('province')<div class="err">{{ $message }}</div>@enderror</div>
                <div><label>Kode Pos</label><input name="postal" value="{{ old('postal') }}">@error('postal')<div class="err">{{ $message }}</div>@enderror</div>
            </div>

            <hr style="border:0;border-top:1px solid var(--beige);margin:16px 0">
            <b>Metode Pengiriman</b>
            <div class="opts">
                @foreach (['Reguler' => '3–5 hari kerja', 'Ekspres' => '1–2 hari kerja'] as $v => $d)
                    <label class="opt"><input type="radio" name="ship" value="{{ $v }}" data-cost="{{ \App\Http\Controllers\CartController::SHIPPING[$v] }}" @checked($ship === $v)><div><b>{{ $v }}</b><small>{{ $d }}</small></div></label>
                @endforeach
            </div>
            <b>Metode Pembayaran</b>
            <div class="opts">
                @foreach (['Midtrans' => 'VA, QRIS, e-wallet, kartu', 'COD' => 'Bayar di tempat'] as $v => $d)
                    <label class="opt"><input type="radio" name="pay" value="{{ $v }}" @checked($pay === $v)><div><b>{{ $v }}</b><small>{{ $d }}</small></div></label>
                @endforeach
            </div>
        </div>

        <div class="card sum" style="padding:24px;align-self:start">
            <h3 style="margin-bottom:16px">Ringkasan Pesanan</h3>
            @foreach ($items as $i => $p)
                <div class="item">
                    <div style="width:67px;height:102px;flex:none"><x-rug :c="$p['c']" :image="$p['image']" style="height:100%" /></div>
                    <div style="flex:1"><b>{{ $p['name'] }}</b><br>Rp{{ number_format($p['price'], 0, ',', '.') }}</div>
                    <button type="submit" form="rm-{{ $i }}" class="linkbtn">Hapus</button>
                </div>
            @endforeach
            <hr style="border:0;border-top:1px solid var(--beige);margin:16px 0">
            <div class="li"><span>Subtotal</span><span data-sub="{{ $sub }}">Rp{{ number_format($sub, 0, ',', '.') }}</span></div>
            <div class="li"><span>Ongkos kirim</span><span id="ong">Rp{{ number_format($ong, 0, ',', '.') }}</span></div>
            <div class="li tot"><span>Total</span><span id="total">Rp{{ number_format($total, 0, ',', '.') }}</span></div>
            <div class="bank">&#127974; Pembayaran online diproses aman oleh Midtrans. Setelah menekan "Buat Pesanan", Anda akan diarahkan untuk memilih metode bayar.</div>
            <button class="btn w">Buat Pesanan</button>
            <p style="font-size:12px;text-align:center;margin-top:10px;color:#6b5848">Dengan memesan, Anda menyetujui syarat dan ketentuan kami.</p>
        </div>
    </form>

    @foreach ($items as $i => $p)
        <form id="rm-{{ $i }}" method="POST" action="{{ route('cart.remove', $i) }}">@csrf @method('DELETE')</form>
    @endforeach
    @endif
</div>
@endsection
