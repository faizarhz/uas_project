@extends('admin.layout')

@section('title', 'Kelola Stok - Beverly')
@section('topbar', 'Kelola Stok Produk')

@section('content')

<div class="page-title">
    <h1>Kelola Stok</h1>
    <p>Pantau dan perbarui ketersediaan stok produk Beverly.</p>
</div>

<div class="card">

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    <h3 style="margin-bottom:20px;">Daftar Stok Produk</h3>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Produk</th>
                <th>Stok Saat Ini</th>
                <th>Ubah Stok</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $product->name }}</td>
                    <td>
                        <strong>{{ $product->stock }}</strong>
                    </td>
                    <td>
                        <form action="{{ route('admin.stock.update', $product->id) }}"
                              method="POST"
                              style="display:flex;gap:8px;align-items:center;">
                            @csrf
                            @method('PUT')

                            <input type="number"
                                   name="stock"
                                   value="{{ $product->stock }}"
                                   min="0"
                                   required
                                   style="width:110px;margin:0;">

                            <button type="submit" class="btn btn-gold">
                                Simpan
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" style="text-align:center;padding:30px;">
                        Belum ada produk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
