<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Admin Beverly')</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f8f5ef;
            color: #3b281f;
            min-height: 100vh;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            background: #3b281f;
            padding: 30px 20px;
            color: #fff;
        }

        .brand {
            padding: 5px 12px 30px;
            border-bottom: 1px solid rgba(255,255,255,.15);
            margin-bottom: 30px;
        }

        .brand h2 {
            font-size: 25px;
            letter-spacing: 4px;
        }

        .brand p {
            font-size: 9px;
            letter-spacing: 3px;
            color: #d5b477;
        }

        .menu-label {
            color: #b9a99d;
            font-size: 10px;
            letter-spacing: 2px;
            margin: 25px 12px 12px;
        }

        .sidebar a {
            display: block;
            color: #eee5d9;
            text-decoration: none;
            padding: 13px 15px;
            border-radius: 8px;
            margin-bottom: 7px;
            font-size: 13px;
            transition: .2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #b88b4a;
            color: white;
        }

        .main {
            margin-left: 250px;
            padding: 30px 40px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: white;
            padding: 18px 25px;
            border-radius: 12px;
            margin-bottom: 30px;
            box-shadow: 0 3px 15px rgba(59,40,31,.05);
        }

        .topbar h2 {
            font-size: 17px;
            font-weight: 600;
        }

        .admin-label {
            color: #9a7540;
            font-size: 12px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h1 {
            font-size: 26px;
            color: #3b281f;
            margin-bottom: 5px;
        }

        .page-title p {
            font-size: 13px;
            color: #8a8179;
        }

        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 3px 15px rgba(59,40,31,.05);
            margin-bottom: 22px;
        }

        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            border-left: 4px solid #b88b4a;
            box-shadow: 0 3px 15px rgba(59,40,31,.05);
        }

        .stat-card h3 {
            font-size: 13px;
            color: #8a8179;
            font-weight: 500;
        }

        .stat-card .number {
            font-size: 30px;
            font-weight: 700;
            color: #3b281f;
            margin-top: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th {
            background: #f4eee4;
            color: #5b4030;
            font-size: 12px;
            text-align: left;
            padding: 15px;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid #eee9e1;
            font-size: 12px;
            color: #51463e;
        }

        tr:hover td {
            background: #fdfbf8;
        }

        input, textarea, select {
            width: 100%;
            padding: 12px 14px;
            border: 1px solid #ded6ca;
            border-radius: 7px;
            outline: none;
            font-size: 13px;
            margin-top: 7px;
            margin-bottom: 17px;
            background: white;
        }

        input:focus, textarea:focus {
            border-color: #b88b4a;
        }

        label {
            font-size: 13px;
            font-weight: 500;
        }

        textarea {
            min-height: 110px;
            resize: vertical;
        }

        .btn {
            display: inline-block;
            padding: 10px 17px;
            border: none;
            border-radius: 7px;
            background: #3b281f;
            color: white;
            text-decoration: none;
            font-size: 12px;
            cursor: pointer;
        }

        .btn:hover {
            background: #5b4030;
        }

        .btn-gold {
            background: #b88b4a;
        }

        .btn-gold:hover {
            background: #9a7038;
        }

        .btn-danger {
            background: #a94442;
        }

        .btn-light {
            background: #eee7dc;
            color: #3b281f;
        }

        .alert {
            background: #edf5e9;
            color: #42633b;
            padding: 13px 16px;
            border-radius: 7px;
            margin-bottom: 20px;
            font-size: 13px;
        }

        .status {
            display: inline-block;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 10px;
        }

        .status-read {
            background: #e7f2e5;
            color: #47723d;
        }

        .status-unread {
            background: #fff1d9;
            color: #a16d20;
        }

        .product-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 7px;
        }

        .actions {
            display: flex;
            gap: 7px;
            align-items: center;
        }

        @media(max-width: 800px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }

            .main {
                margin-left: 0;
                padding: 20px;
            }

            body {
                display: block;
            }

            .stats {
                grid-template-columns: 1fr;
            }

            .topbar {
                padding: 15px;
            }

            .card {
                overflow-x: auto;
            }
        }
    </style>
</head>

<body>

    <aside class="sidebar">
        <div class="brand">
            <h2>BEVERLY</h2>
            <p>KARPET & AMBAL</p>
        </div>

        <div class="menu-label">MENU UTAMA</div>

        <a href="{{ route('admin.dashboard') }}"
           class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            ◈ Dashboard
        </a>

        <a href="{{ route('admin.products.index') }}"
           class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            ◈ Manajemen Produk
        </a>

        <a href="{{ route('admin.stock') }}"
           class="{{ request()->routeIs('admin.stock') ? 'active' : '' }}">
            ◈ Kelola Stok
        </a>

        <a href="{{ route('admin.messages') }}"
           class="{{ request()->routeIs('admin.messages*') ? 'active' : '' }}">
            ◈ Pesan Masuk
        </a>

        <div class="menu-label">INFORMASI</div>
        <a href="{{ url('/') }}" target="_blank">
            ◈ Lihat Website
        </a>
    </aside>

    <main class="main">

        <div class="topbar">
            <h2>@yield('topbar', 'Admin Panel')</h2>
            <span class="admin-label">BEVERLY ADMIN</span>
        </div>

        @yield('content')

    </main>

</body>
</html>
