@extends('layouts.app')

@section('content')
<h1>{{ $product->name }}</h1>
<p>Tipe: {{ $product->type }}</p>
<p>Deskripsi: {{ $product->description }}</p>
<p>Harga: Rp{{ number_format($product->price, 0, ',', '.') }}</p>
<p>Penjahit: {{ $product->user->name }}</p>
@endsection
