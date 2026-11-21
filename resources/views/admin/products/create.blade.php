@extends('admin.layout')

@section('title', 'Tambah Produk - Beverly')
@section('topbar', 'Tambah Produk')

@section('content')

<div class="page-title">
    <h1>Tambah Produk</h1>
    <p>Tambahkan produk karpet atau ambal baru ke Beverly.</p>
</div>

<div class="card" style="max-width:750px;">

    <form action="{{ route('admin.products.store') }}"
          method="POST"
          enctype="multipart/form-data">

        @csrf

        <label>Nama Produk</label>
        <input type="text" name="name"
               value="{{ old('name') }}"
               placeholder="Masukkan nama produk" required>

        <label>Deskripsi</label>
        <textarea name="description"
                  placeholder="Masukkan deskripsi produk">{{ old('description') }}</textarea>

        <label>Harga (Rp)</label>
        <input type="number" name="price"
               value="{{ old('price') }}"
               min="0" placeholder="Masukkan harga" required>

        <label>Stok</label>
        <input type="number" name="stock"
               value="{{ old('stock') }}"
               min="0" placeholder="Masukkan jumlah stok" required>

        <label>Gambar Produk</label>
        <input type="file" name="image" accept="image/*">

        @if($errors->any())
            <div class="alert" style="background:#fbeaea;color:#963c3c;">
                {{ $errors->first() }}
            </div>
        @endif

        <div style="display:flex; gap:10px; margin-top:10px;">
            <button type="submit" class="btn btn-gold">
                Simpan Produk
            </button>

            <a href="{{ route('admin.products.index') }}"
               class="btn btn-light">Kembali</a>
        </div>

    </form>

</div>

@endsection
