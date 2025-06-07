@extends('layouts.appPenjahit')

@section('content')
<div class="container">
    <h1>Tambah Produk Jahitan</h1>
    <form action="{{ route('products.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Jenis Produk</label>
            <select name="type" class="form-control" required>
                <option value="">-- Pilih Jenis --</option>
                <option value="atasan">Atasan</option>
                <option value="bawahan">Bawahan</option>
                <option value="terusan">Terusan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" required>
        </div>
        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
