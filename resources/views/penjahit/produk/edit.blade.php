@extends('layouts.appPenjahit')

@section('content')
<div class="container">
    <h1>Edit Produk Jahitan</h1>
    <form action="{{ route('products.update', $product->id) }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama Produk</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>
        <div class="mb-3">
            <label>Jenis Produk</label>
            <select name="type" class="form-control" required>
                <option value="atasan" {{ $product->type == 'atasan' ? 'selected' : '' }}>Atasan</option>
                <option value="bawahan" {{ $product->type == 'bawahan' ? 'selected' : '' }}>Bawahan</option>
                <option value="terusan" {{ $product->type == 'terusan' ? 'selected' : '' }}>Terusan</option>
            </select>
        </div>
        <div class="mb-3">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control" required>{{ $product->description }}</textarea>
        </div>
        <div class="mb-3">
            <label>Harga</label>
            <input type="number" name="price" class="form-control" value="{{ $product->price }}" required>
        </div>
        <button class="btn btn-success">Update</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection
