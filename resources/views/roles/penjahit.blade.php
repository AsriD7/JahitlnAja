@extends('layouts.appPenjahit')

@section('title', 'Dashboard Penjahit')

@section('content')
    <h1>Selamat datang, {{ auth()->user()->name }}!</h1>
    <p>Ini adalah dashboard penjahit.</p>
@endsection
