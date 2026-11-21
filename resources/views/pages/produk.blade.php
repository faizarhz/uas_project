@extends('layouts.app')
@section('title', 'Produk – BEVERLY')

@section('content')
@php
    $qs = fn (array $over = []) => route('products', array_filter(
        array_merge(['cat' => $cat, 'q' => $q, 'max' => $max, 'sort' => $sort], $over),
        fn ($v) => $v !== '' && $v !== null
    ));
@endphp
<div style="padding:24px max(16px,4vw)">
    <div class="chips">
        <b style="margin-right:8px;font-size:14px">Kategori</b>
        @foreach (['Semua Produk', ...$categories->pluck('name')->all()] as $name)
            <a class="chip {{ $cat === $name ? 'on' : '' }}" href="{{ $qs(['cat' => $name, 'page' => 1]) }}">{{ $name }}</a>
        @endforeach
    </div>

    <form id="filter" method="GET" action="{{ route('products') }}" class="card tool">
        <input type="hidden" name="cat" value="{{ $cat }}">
        <div class="s">
            <input type="text" id="q" name="q" placeholder="Cari karpet, ambal, atau motif…" value="{{ $q }}">
        </div>
        <div style="flex:0 1 300px;width:300px">
            <label><span>Filter Harga</span><span>Rp0 – Rp{{ number_format($max, 0, ',', '.') }}</span></label>
            <input type="range" name="max" min="100000" max="1500000" step="50000" value="{{ $max }}">
        </div>
        <div style="flex:0 1 260px">
            <label>Urutkan</label>
            <select name="sort">
                @foreach (['Terbaru', 'Harga Terendah', 'Harga Tertinggi'] as $o)
                    <option @selected($sort === $o)>{{ $o }}</option>
                @endforeach
            </select>
        </div>
    </form>

    <div class="grid">
        @forelse ($products as $p)
            <div class="card pc">
                <span class="badge">{{ $p['badge'] }}</span>
                <form method="POST" action="{{ route('fav', $p['id']) }}" style="display:contents">@csrf
                    <button class="heart {{ in_array($p['id'], $favs) ? 'on' : '' }}" style="border:0">
                        {!! in_array($p['id'], $favs) ? '&#9829;' : '&#9825;' !!}
                    </button>
                </form>
                <x-rug :c="$p['c']" :image="$p['image']" />
                <h4>{{ $p['name'] }}</h4>
                <div class="pr">Rp{{ number_format($p['price'], 0, ',', '.') }}</div>
                <form method="POST" action="{{ route('cart.add', $p['id']) }}">@csrf
                    <button class="btn w">+ Keranjang</button>
                </form>
            </div>
        @empty
            <p>Produk tidak ditemukan.</p>
        @endforelse
    </div>

    <div class="pg">
        <a href="{{ $qs(['page' => max(1, $page - 1)]) }}">&lsaquo;</a>
        @for ($i = 1; $i <= $pages; $i++)
            <a class="{{ $i === $page ? 'on' : '' }}" href="{{ $qs(['page' => $i]) }}">{{ $i }}</a>
        @endfor
        <a href="{{ $qs(['page' => min($pages, $page + 1)]) }}">&rsaquo;</a>
    </div>
</div>
@endsection
