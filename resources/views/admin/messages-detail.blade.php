@extends('admin.layout')

@section('title', 'Detail Pesan - Beverly')
@section('topbar', 'Detail Pesan')

@section('content')

<div class="page-title">
    <h1>Detail Pesan</h1>
    <p>Informasi pesan dari pelanggan Beverly.</p>
</div>

<div class="card" style="max-width:800px;">

    <div style="margin-bottom:22px;">
        <label>Nama Pengirim</label>
        <p style="margin-top:8px;">{{ $message->name }}</p>
    </div>

    <div style="margin-bottom:22px;">
        <label>Email</label>
        <p style="margin-top:8px;">{{ $message->email }}</p>
    </div>

    <div style="margin-bottom:22px;">
        <label>Subjek</label>
        <p style="margin-top:8px;">{{ $message->subject }}</p>
    </div>

    <div style="margin-bottom:25px;">
        <label>Isi Pesan</label>
        <div style="background:#f8f5ef;padding:20px;border-radius:8px;margin-top:10px;line-height:1.8;font-size:13px;white-space:pre-wrap;">{{ $message->message }}</div>
    </div>

    <a href="{{ route('admin.messages') }}" class="btn btn-light">
        ← Kembali ke Pesan Masuk
    </a>

</div>

@endsection
