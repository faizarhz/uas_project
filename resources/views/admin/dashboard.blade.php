@extends('admin.layout')

@section('title', 'Dashboard - Beverly')
@section('topbar', 'Dashboard Admin')

@section('content')

<div class="page-title">
    <h1>Dashboard</h1>
    <p>Selamat datang di halaman administrasi Beverly.</p>
</div>

<div class="stats">

    <div class="stat-card">
        <h3>Total Produk</h3>
        <div class="number">{{ $totalProducts }}</div>
    </div>

    <div class="stat-card">
        <h3>Total Stok</h3>
        <div class="number">{{ $totalStock }}</div>
    </div>

    <div class="stat-card">
        <h3>Total Pesan</h3>
        <div class="number">{{ $totalMessages }}</div>
    </div>

</div>

<div class="card">
    <h3 style="margin-bottom:10px;">Selamat Datang, Admin!</h3>
    <p style="font-size:13px; color:#8a8179;">
        Kelola produk karpet dan ambal Beverly melalui halaman administrasi ini.
    </p>
</div>

@endsection
