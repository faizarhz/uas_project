@extends('admin.layout')

@section('title', 'Manajemen Produk - Beverly')
@section('topbar', 'Manajemen Produk')

@section('content')

<div class="page-title">
    <h1>Manajemen Produk</h1>
    <p>Kelola seluruh produk karpet dan ambal Beverly.</p>
</div>

<div class="card">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:22px; gap:12px; flex-wrap:wrap;">
        <h3>Daftar Produk</h3>

        <a href="{{ route('admin.products.create') }}" class="btn btn-gold">
            + Tambah Produk
        </a>
    </div>

    @if(session('success'))
        <div class="alert">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert" style="background:#fbeaea;color:#963c3c;">
            {{ $errors->first() }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Gambar</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>

        <tbody>
            @forelse($products as $product)
                <tr>
                    <td>{{ $loop->iteration }}</td>

                    <td>
                        @if($product->image)
                            <img src="{{ asset('storage/'.$product->image) }}"
                                 class="product-image" alt="Produk">
                        @else
                            <span>Tidak ada gambar</span>
                        @endif
                    </td>

                    <td>{{ $product->name }}</td>

                    <td>
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </td>

                    <td>{{ $product->stock }}</td>

                    <td>
                        <div class="actions">
                            <a href="{{ route('admin.products.edit', $product->id) }}"
                               class="btn btn-gold">Edit</a>

                            <form action="{{ route('admin.products.destroy', $product->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn btn-danger">
                                    Hapus
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:30px;">
                        Belum ada produk.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</div>

@endsection
