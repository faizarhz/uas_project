@extends('layouts.app')
@section('title', 'Kontak – BEVERLY')

@section('content')
<div class="pad">
    <h1 style="font-size:44px;font-weight:600">Hubungi Kami</h1>
    <p style="color:#6b5848;margin-bottom:40px">Ada pertanyaan seputar produk atau pesanan? Tim kami siap membantu Anda.</p>

    <div class="split" style="gap:56px;min-height:auto">
        <div>
            <div class="bank"><b>Catatan:</b><br>Data kontak pada halaman ini adalah contoh dan dapat diganti sesuai kebutuhan toko.</div>
            @foreach ([['&#9906;', 'Alamat', 'Jl. Karpet Indah No. 18, Jakarta'], ['&#128172;', 'WhatsApp', '+62 812-3456-7890'], ['&#9993;', 'Email', 'halo@beverly-karpet.id'], ['&#128339;', 'Jam Operasional', 'Senin – Sabtu, 09.00 – 18.00']] as [$ic, $t, $v])
                <div class="ct">
                    <div class="ci">{!! $ic !!}</div>
                    <div><b>{{ $t }}</b><br><span style="color:#6b5848">{{ $v }}</span></div>
                </div>
            @endforeach
        </div>

        <form class="card" style="padding:28px" method="POST" action="{{ route('contact.send') }}">
            @csrf
            <h3 style="margin-bottom:16px">Kirim Pesan</h3>
            <div class="f"><label>Nama</label><input name="name" value="{{ old('name') }}" placeholder="Nama lengkap">@error('name')<div class="err">{{ $message }}</div>@enderror</div>
            <div class="f"><label>Email</label><input name="email" type="email" value="{{ old('email') }}" placeholder="email@contoh.com">@error('email')<div class="err">{{ $message }}</div>@enderror</div>
            <div class="f"><label>Pesan</label><textarea name="message" rows="5" placeholder="Tulis pesan Anda">{{ old('message') }}</textarea>@error('message')<div class="err">{{ $message }}</div>@enderror</div>
            <button class="btn w">Kirim Pesan</button>
        </form>
    </div>
</div>
@endsection
