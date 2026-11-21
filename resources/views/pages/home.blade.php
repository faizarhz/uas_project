@extends('layouts.app')

@section('content')
<div class="split">
    <div class="hero">
        <div class="eye">KOLEKSI TERBARU 2026</div>
        <h1>Hadirkan Kenyamanan dan Kemewahan di Setiap Sudut Rumah.</h1>
        <p>BEVERLY menghadirkan koleksi karpet dan ambal pilihan — dari motif Persia klasik hingga desain modern minimalis — dibuat dari bahan berkualitas agar rumah Anda terasa hangat, nyaman, dan berkelas.</p>
        <div style="display:flex;gap:16px;flex-wrap:wrap">
            <a class="btn light" href="{{ route('products') }}">Belanja Sekarang</a>
            <a class="btn out" href="{{ route('products') }}">Lihat Koleksi</a>
        </div>
    </div>
    <x-rug :c="$categories[0]['c']" :image="\App\Support\Catalog::image('', 'hero')" style="border-radius:0;min-height:420px" />
</div>

<section class="sec" style="background:var(--cream)">
    <small>KATEGORI</small>
    <h2>Jelajahi Kategori Pilihan</h2>
    <p class="d">Temukan karpet dan ambal yang sesuai dengan gaya dan kebutuhan ruangan Anda.</p>
    <div class="cats">
        @foreach ($categories as $c)
            <a class="cat" href="{{ route('products', ['cat' => $c['name']]) }}">
                <x-rug :c="$c['c']" :image="$c['image']" />
                <h4>{{ $c['name'] }}</h4>
                <span>{{ $c['count'] }} produk</span>
            </a>
        @endforeach
    </div>
</section>
@endsection
