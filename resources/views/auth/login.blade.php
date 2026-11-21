@extends('layouts.app')
@section('title', 'Masuk – BEVERLY')
@section('nofooter', true)

@section('content')
<div class="split">
    <x-rug :c="\App\Support\Catalog::CATEGORIES[0]['c']" :image="\App\Support\Catalog::image('', 'login')" style="border-radius:0;min-height:300px" />
    <div class="pad" style="display:flex;justify-content:center;align-items:center">
        <form class="formw" method="POST" action="{{ route('login') }}">
            @csrf
            <span class="lbl">AKUN</span>
            <h1>Masuk ke BEVERLY</h1>
            <p style="color:#6b5848;margin:8px 0 28px">Masuk untuk melanjutkan belanja dan melihat pesanan Anda.</p>

            <div class="f">
                <label>Email</label>
                <input name="email" type="email" value="{{ old('email') }}" placeholder="email@contoh.com">
                @error('email')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div class="f">
                <label>Kata Sandi</label>
                <input id="pw" name="password" type="password" placeholder="Masukkan kata sandi">
                @error('password')<div class="err">{{ $message }}</div>@enderror
            </div>
            <div style="display:flex;justify-content:space-between;margin-bottom:24px;font-size:14px">
                <label class="chk"><input type="checkbox" onchange="pw.type=this.checked?'text':'password'">Tampilkan kata sandi</label>
                <a style="color:var(--gold)">Lupa kata sandi?</a>
            </div>
            <button class="btn w">Masuk</button>
            <hr style="border:0;border-top:1px solid var(--bd);margin:28px 0 16px">
            <p style="font-size:14px">Belum punya akun? <a href="{{ route('register') }}" style="color:var(--gold);font-weight:600">Daftar sekarang</a></p>
        </form>
    </div>
</div>
@endsection
