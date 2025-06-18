@extends('layouts.appAdmin')
@section('title', 'Verifikasi Pesanan')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    .order-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .order-image {
        max-width: 100px;
        border-radius: 8px;
    }
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
    .btn-custom {
        background-color: #8c0d4f;
        border-color: #8c0d4f;
        transition: all 0.3s ease;
    }
    .btn-custom:hover {
        background-color: #700a3f;
        border-color: #700a3f;
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
</style>

<div class="container my-5 fade-in">
    <h1 class="mb-4 section-title text-center">Verifikasi Pesanan</h1>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($orders as $order)
            <div class="col-12">
                <div class="order-card p-3">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <strong>Pelanggan:</strong><br>{{ $order->customer->name }}
                        </div>
                        <div class="col-md-2">
                            <strong>Penjahit:</strong><br>{{ $order->tailor->user->name }}
                        </div>
                        <div class="col-md-2">
                            <strong>Layanan:</strong><br>{{ $order->service->name }}
                        </div>
                        <div class="col-md-2">
                            <strong>Gambar Referensi:</strong><br>
                            @if ($order->reference_image)
                                <img src="{{ asset('storage/' . $order->reference_image) }}" alt="Referensi" class="order-image">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <strong>Bukti Pembayaran:</strong><br>
                            @if ($order->payment_proof)
                                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank" class="text-decoration-none text-primary">Lihat Bukti</a>
                            @else
                                <span class="text-muted">Belum diunggah</span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <strong>Aksi:</strong><br>
                            <form action="{{ route('admin.verifyPayment', $order) }}" method="POST" class="mt-2">
                                @csrf
                                <select name="status" class="form-select form-select-sm mb-2" required>
                                    <option value="">Pilih Aksi</option>
                                    <option value="paid">Verifikasi Pembayaran</option>
                                    <option value="rejected">Tolak Pembayaran</option>
                                </select>
                                <button type="submit" class="btn btn-custom btn-sm w-100">Proses</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center" role="alert">
                    Tidak ada pesanan yang menunggu verifikasi.
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection