<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'BEVERLY – Karpet & Ambal')</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
<nav>
    <a href="{{ route('home') }}" class="logo">
        <svg width="38" height="38" viewBox="0 0 38 38"><rect x="5" y="5" width="28" height="28" transform="rotate(45 19 19)" fill="#b8935a"/><rect x="12" y="12" width="14" height="14" transform="rotate(45 19 19)" fill="#3b2a20"/></svg>
        <span><b>BEVERLY</b><small>KARPET &amp; AMBAL</small></span>
    </a>

    <div class="links">
        <a href="{{ route('home') }}" @class(['on' => request()->routeIs('home')])>Home</a>
        <a href="{{ route('products') }}" @class(['on' => request()->routeIs('products')])>Produk</a>
        <a href="{{ route('about') }}" @class(['on' => request()->routeIs('about')])>About Us</a>
        <a href="{{ route('contact') }}" @class(['on' => request()->routeIs('contact')])>Kontak</a>
    </div>

    <div class="act">
        <a class="ic" href="{{ route('products') }}" title="Cari">&#128269;</a>
        <a class="ic" href="{{ route('checkout') }}" title="Keranjang">&#128722;<i>{{ count(session('cart', [])) }}</i></a>
        @auth
            <span class="nav-user">{{ \Illuminate\Support\Str::words(auth()->user()->name, 1, '') }}</span>
            <form method="POST" action="{{ route('logout') }}">@csrf
                <button class="btn" style="padding:11px 18px;font-size:13px">Keluar</button>
            </form>
        @else
            <a class="btn" href="{{ route('login') }}" style="padding:11px 18px;font-size:13px">Login</a>
        @endauth
    </div>
</nav>

<main>@yield('content')</main>

@unless (View::hasSection('nofooter'))
    @include('partials.footer')
@endunless

<div id="toast"></div>
<script>window.__toast = @json(session('toast'));</script>
<script src="{{ asset('js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
