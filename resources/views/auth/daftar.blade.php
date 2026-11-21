@extends('layouts.app')
@section('title', 'Daftar – BEVERLY')
@section('nofooter', true)

@section('content')
<div class="split">
    <x-rug :c="\App\Support\Catalog::CATEGORIES[1]['c']" :image="\App\Support\Catalog::image('', 'daftar')" style="border-radius:0;min-height:300px" />
    <div class="pad" style="display:flex;justify-content:center">
        <form class="formw" method="POST" action="{{ route('register') }}">
            @csrf
            <span class="lbl">AKUN BARU</span>
            <h1>Buat Akun</h1>
            <p style="color:#6b5848;margin:6px 0 20px">Daftar untuk mulai berbelanja karpet pilihan.</p>

            @foreach ([['name', 'Nama Lengkap', 'text'], ['email', 'Email', 'email'], ['phone', 'Nomor WhatsApp', 'tel'], ['password', 'Kata Sandi', 'password'], ['password_confirmation', 'Konfirmasi Kata Sandi', 'password']] as [$n, $l, $t])
                <div class="f">
                    <label>{{ $l }}</label>
                    <input type="{{ $t }}" name="{{ $n }}" value="{{ $t === 'password' ? '' : old($n) }}">
                    @error($n)<div class="err">{{ $message }}</div>@enderror
                </div>
            @endforeach

            <label class="chk" style="margin-bottom:6px"><input type="checkbox" name="terms" value="1" @checked(old('terms'))>Saya menyetujui syarat dan ketentuan BEVERLY</label>
            @error('terms')<div class="err" style="margin-bottom:14px">Anda harus menyetujui syarat dan ketentuan.</div>@enderror
            <div style="height:14px"></div>
            <button class="btn w">Daftar</button>
            <p style="font-size:14px;margin-top:16px;text-align:center">Sudah punya akun? <a href="{{ route('login') }}" style="color:var(--gold);font-weight:600">Masuk</a></p>
        </form>
    </div>
</div>
@endsection
