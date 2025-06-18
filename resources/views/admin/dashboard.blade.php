@extends('layouts.appAdmin')

@section('content')
<div class="container fade-in">
    <!-- An unexamined life is not worth living. - Socrates -->
    <div class="text-center mb-4" style="font-style: italic; color: #666; font-size: 1.1rem;">
        "An unexamined life is not worth living." - Socrates
    </div>

    <h1 class="mb-4 section-title">Admin Dashboard</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background: linear-gradient(135deg, #8c0d4f, #700a3f);">
                <div class="card-body">
                    <h5 class="card-title">Manajemen Akun</h5>
                    <p class="card-text">Kelola akun penjahit dan pelanggan dengan mudah.</p>
                    <a href="{{ route('admin.users') }}" class="btn btn-light btn-sm">Lihat Akun</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-white mb-3" style="background: linear-gradient(135deg, #8c0d4f, #700a3f);">
                <div class="card-body">
                    <h5 class="card-title">Verifikasi Pembayaran</h5>
                    <p class="card-text">Lihat dan verifikasi pembayaran pelanggan.</p>
                    <a href="{{ route('admin.orders') }}" class="btn btn-light btn-sm">Verifikasi</a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
        color: #8c0d4f;
    }
    .section-title::after {
        content: '';
        width: 50px;
        height: 3px;
        background: #8c0d4f;
        position: absolute;
        bottom: -10px;
        left: 0;
    }
    .card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection