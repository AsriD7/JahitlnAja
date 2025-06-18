@extends('layouts.appPenjahit')

@section('content')
<style>
    .profile-card, .order-card {
        transition: all 0.3s ease;
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        overflow: hidden;
        background: #fff;
    }
    .profile-card:hover, .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }
    .order-image {
        max-width: 120px;
        border-radius: 8px;
        cursor: pointer;
    }
    .status-badge {
        font-size: 0.9rem;
        padding: 5px 10px;
        border-radius: 12px;
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
    .empty-state {
        text-align: center;
        padding: 30px;
        background: #f9f9f9;
        border-radius: 10px;
        color: #666;
    }
</style>

<div class="container py-5 fade-in">
    <h2 class="mb-4 text-center">Selamat datang, {{ auth()->user()->name }}</h2>

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

    <div class="row mb-4">
        <div class="col-12">
            <div class="profile-card p-4">
                <h4 class="mb-4">Informasi Penjahit</h4>
                @if ($tailor)
                    <p><strong>Spesialisasi:</strong> {{ $tailor->specialization }}</p>
                    <p><strong>Pengalaman:</strong> {{ $tailor->experience }} tahun</p>
                    <p><strong>Layanan yang Dikuasai:</strong> {{ $tailor->services->pluck('name')->join(', ') }}</p>
                    <a href="{{ route('tailor.showProfile') }}" class="btn btn-custom text-white">Edit Profil</a>
                @else
                    <p class="text-muted">Silakan lengkapi profil Anda untuk memulai.</p>
                    <a href="{{ route('tailor.showProfile') }}" class="btn btn-custom">Lengkapi Profil</a>
                @endif
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h4 class="mb-4">Pesanan yang Diterima</h4>
            <div class="row g-4">
                @forelse ($orders as $order)
                    <div class="col-12">
                        <div class="order-card p-3">
                            <div class="row align-items-center">
                                <div class="col-md-2">
                                    <strong>Pelanggan:</strong><br>{{ $order->customer->name }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Layanan:</strong><br>{{ $order->service->name }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Ukuran:</strong><br>{{ $order->measurement }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Gambar Referensi:</strong><br>
                                    @if ($order->reference_image)
                                        <a href="{{ asset('storage/' . $order->reference_image) }}" target="_blank" class="d-block">
                                            <img src="{{ asset('storage/' . $order->reference_image) }}" alt="Referensi" class="order-image">
                                        </a>
                                    @else
                                        <span class="text-muted">Tidak ada gambar</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <strong>Total Harga:</strong><br>Rp {{ number_format($order->total_price, 2) }}
                                </div>
                                <div class="col-md-2">
                                    <strong>Status:</strong><br>
                                    @if ($order->status == 'paid')
                                        <span class="badge status-badge bg-success">Lunas</span>
                                    @elseif ($order->status == 'accepted')
                                        <span class="badge status-badge bg-info text-dark">Diterima</span>
                                    @elseif ($order->status == 'in_progress')
                                        <span class="badge status-badge bg-warning text-dark">Dalam Proses</span>
                                    @elseif ($order->status == 'completed')
                                        <span class="badge status-badge bg-primary">Selesai</span>
                                    @else
                                        <span class="badge status-badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </div>
                                <div class="col-md-2">
                                    <strong>Aksi:</strong><br>
                                    @if ($order->status != 'completed')
                                        <form action="{{ route('tailor.updateStatus', $order) }}" method="POST" class="mt-2">
                                            @csrf
                                            <div class="input-group">
                                                <select name="status" class="form-select form-select-sm">
                                                    @if ($order->status == 'paid')
                                                        <option value="accepted">Terima</option>
                                                    @elseif ($order->status == 'accepted')
                                                        <option value="in_progress">Dalam Proses</option>
                                                    @elseif ($order->status == 'in_progress')
                                                        <option value="completed">Selesai</option>
                                                    @endif
                                                </select>
                                                <button type="submit" class="btn btn-custom btn-sm text-white">Update</button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="text-muted">Selesai</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="empty-state">
                            <h5>Tidak ada pesanan yang diterima.</h5>
                            <p class="text-muted">Pesanan akan muncul di sini setelah pembayaran diverifikasi oleh admin.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endpush
@endsection
