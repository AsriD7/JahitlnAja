@extends('layouts.appPelanggan')
@section('title', 'Informasi Pembayaran')

@section('content')
<style>
    .payment-card {
        background: linear-gradient(135deg, #ffffff, #f8f9fa);
        border: 1px solid #e0e0e0;
        border-radius: 15px;
        padding: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .payment-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
    }
    .bank-icon {
        font-size: 3rem;
        color: #8c0d4f;
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
    .text-highlight {
        color: #8c0d4f;
        font-weight: 600;
    }
    .fade-in {
        animation: fadeIn 0.5s ease-in;
    }
    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .alert-custom {
        background-color: #fff3f3;
        border-left: 4px solid #dc3545;
    }
    .btn-custom {
        background-color: #8c0d4f;
        border-color: #8c0d4f;
        color: #fff;
        transition: all 0.3s ease;
    }
</style>

<div class="container my-5 fade-in">
    {{-- <h1 class="mb-4 section-title text-center">Informasi Pembayaran</h1> --}}

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

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="payment-card text-center">
                <div class="mb-4">
                    <i class="bi bi-bank bank-icon"></i> <!-- Ikon bank dari Bootstrap Icons -->
                </div>
                <h3 class="mb-3">Detail Pembayaran</h3>
                <p class="text-muted mb-4">Silakan lakukan transfer sesuai total harga pesanan Anda. Setelah transfer, unggah bukti pembayaran di halaman <a href="{{ route('customer.orders') }}" class="text-decoration-none text-highlight">Pesanan Saya</a>.</p>

                <div class="row mb-3">
                    <div class="col-6">
                        <p class="mb-1"><strong>Nama Bank:</strong></p>
                        <p class="text-highlight">{{ $paymentDetails['bank_name'] }}</p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1"><strong>Nama Akun:</strong></p>
                        <p class="text-highlight">{{ $paymentDetails['account_name'] }}</p>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <p class="mb-1"><strong>Nomor Rekening:</strong></p>
                        <p class="text-highlight fw-bold">{{ $paymentDetails['account_number'] }}</p>
                    </div>
                </div>

                <div class="alert alert-custom p-3" role="alert">
                    <p class="mb-0"><strong>Peringatan:</strong> Jangan bagikan informasi pembayaran ini kepada pihak lain. Hubungi admin jika ada masalah.</p>
                </div>

                <a href="{{ route('customer.orders') }}" class="btn btn-custom mt-4">Kembali ke Pesanan Saya</a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"></script>
@endpush
@endsection