@extends('layouts.app')
@section('title', 'Tentang Kami – BEVERLY')

@section('content')
<div class="split" style="min-height:auto">
    <div class="pad" style="display:flex;flex-direction:column;justify-content:center;gap:20px">
        <span class="lbl">TENTANG KAMI</span>
        <h1 style="font-size:44px;line-height:1.3;font-weight:600">Cerita di Balik BEVERLY</h1>
        <p>BEVERLY adalah toko karpet dan ambal premium yang berawal dari kecintaan pada keindahan tekstil dan kehangatan rumah.</p>
        <p style="color:#6b5848">Kami memilih setiap koleksi dengan cermat — dari motif Persia klasik, desain modern minimalis, hingga karpet bulu yang lembut — agar setiap ruang terasa nyaman dan berkelas. Kualitas bahan, ketahanan, dan kenyamanan selalu menjadi prioritas kami.</p>
        <div><a class="btn" href="{{ route('products') }}">Lihat Koleksi</a></div>
    </div>
    <div class="pad">
        <x-rug :c="\App\Support\Catalog::CATEGORIES[2]['c']" :image="\App\Support\Catalog::image('', 'about')" style="height:100%;min-height:360px" />
    </div>
</div>
@endsection
