@extends('admin.layout')

@section('title', 'Edit Produk - Beverly')
@section('topbar', 'Edit Produk')

@section('content')

<div class="page-title">
    <h1>Edit Produk</h1>
    <p>Perbarui informasi produk Beverly.</p>
</div>

<div class="card" style="max-width:750px;">

    <form action="{{ route('admin.products.update', $product->id) }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <label>Nama Produk</label>
        <input type="text" name="name"
               value="{{ old('name', $product->name) }}" required>

        <label>Deskripsi</label>
        <textarea name="description">{{ old('description', $product->description) }}</textarea>

        <label>Harga (Rp)</label>
        <input type="number" name="price"
               value="{{ old('price', $product->price) }}"
               min="0" required>

        <label>Stok</label>
        <input type="number" name="stock"
               value="{{ old('stock', $product->stock) }}"
               min="0" required>

        <label>Gambar Produk Saat Ini</label>

        <div style="margin:12px 0 20px;">
            @if($product->image)
                <img src="{{ asset('storage/'.$product->image) }}"
                     alt="Gambar produk"
                     style="width:150px;height:150px;object-fit:cover;border-radius:10px;">
            @else
                <p>Belum ada gambar.</p>
            @endif
        </div>

        <label>Ganti Gambar (Opsional)</label>
        <input type="file" name="image" accept="image/*">

        @if($errors->any())
            <div class="alert" style="background:#fbeaea;color:#963c3c;">
                {{ $errors->first() }}
            </div>
        @endif

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-gold">
                Simpan Perubahan
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="btn btn-light">Kembali</a>
        </div>

    </form>

</div>

@endsection
