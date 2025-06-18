@extends('layouts.appPelanggan')
@section('title', 'Pesanan Saya')

@section('content')
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
        max-width: 120px;
        border-radius: 8px;
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
    .empty-state {
        text-align: center;
        padding: 50px;
        background: #f9f9f9;
        border-radius: 10px;
        color: #666;
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
    {{-- <h1 class="mb-4 section-title text-center">Pesanan Saya</h1> --}}

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
    @if ($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row g-4">
        @forelse ($orders as $order)
            <div class="col-12">
                <div class="order-card p-3">
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <strong>Penjahit:</strong><br>{{ $order->tailor->user->name }}
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
                                <img src="{{ asset('storage/' . $order->reference_image) }}" alt="Referensi" class="order-image">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <strong>Total Harga:</strong><br>Rp {{ number_format($order->total_price, 2) }}
                        </div>
                        <div class="col-md-2">
                            <strong>Status:</strong><br>
                            @if ($order->status == 'pending')
                                <span class="badge status-badge bg-warning text-dark">Pending</span>
                            @elseif ($order->status == 'payment_uploaded')
                                <span class="badge status-badge bg-info text-dark">Menunggu Verifikasi</span>
                            @elseif ($order->status == 'paid')
                                <span class="badge status-badge bg-success">Lunas</span>
                            @elseif ($order->status == 'processing')
                                <span class="badge status-badge bg-info text-dark">Diproses</span>
                            @elseif ($order->status == 'done')
                                <span class="badge status-badge bg-primary">Selesai</span>
                            @else
                                <span class="badge status-badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </div>
                        <div class="col-md-2">
                            <strong>Aksi:</strong><br>
                            @if ($order->status == 'pending')
                                <form action="{{ route('customer.uploadPayment', $order) }}" method="POST" enctype="multipart/form-data" class="mt-2">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" name="payment_proof" class="form-control form-control-sm" required>
                                    </div>
                                    <button type="submit" class="btn btn-custom btn-sm w-100 text-white">Upload Bukti</button>
                                </form>
                                <p class="text-muted small mt-2">Silakan unggah bukti pembayaran. Informasi pembayaran dapat dilihat di <a href="/payment-info" class="text-decoration-none">halaman info</a>.</p>
                                <form action="{{ route('customer.cancelOrder', $order) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm w-100" onclick="return confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')">Batalkan</button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="empty-state">
                    <h4>Belum ada pesanan</h4>
                    <p class="text-muted">Silakan buat pesanan baru di halaman utama.</p>
                    <a href="{{ route('customer.index') }}" class="btn btn-custom mt-3">Buat Pesanan</a>
                </div>
            </div>
        @endforelse
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        if ($('#service_id').length) {
            $('#service_id').select2({
                theme: 'bootstrap-5',
                placeholder: 'Pilih layanan yang diinginkan',
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>
@endpush
@endsection
