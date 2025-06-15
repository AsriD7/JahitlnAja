<div>
    <!-- An unexamined life is not worth living. - Socrates -->
</div>
@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1 class="mb-4">Admin Dashboard</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-white bg-primary mb-3">
                <div class="card-body">
                    <h5 class="card-title">Manajemen Akun</h5>
                    <p class="card-text">Kelola akun penjahit dan pelanggan.</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-light">Lihat Akun</a>
                </div>
            </div>
        </div>
        {{-- <div class="col-md-4">
            <div class="card text-white bg-success mb-3">
                <div class="card-body">
                    <h5 class="card-title">Verifikasi Pembayaran</h5>
                    <p class="card-text">Lihat dan verifikasi pembayaran pelanggan.</p>
                    <a href="{{ route('admin.payments') }}" class="btn btn-light">Verifikasi</a>
                </div>
            </div>
        </div> --}}
    </div>
</div>
@endsection