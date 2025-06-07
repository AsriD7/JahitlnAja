@extends('layouts.app')

@section('content')
<h1>Daftar Produk Jahitan</h1>
<div class="grid grid-cols-3 gap-4">
@foreach ($products as $product)
    <div class="border p-4 rounded shadow">
        <h3>{{ $product->name }}</h3>
        <p>{{ $product->type }}</p>
        <p>Rp{{ number_format($product->price, 0, ',', '.') }}</p>
        <a href="{{ route('customer.products.show', $product) }}">Lihat Detail</a>
    </div>
@endforeach
</div>
@endsection
