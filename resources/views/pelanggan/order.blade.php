@extends('layouts.appPelanggan')
@section('title', 'Buat Pesanan')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Customer Dashboard</h1>

    <div class="mb-5">
        <h2>Available Services</h2>
        @foreach ($categories as $category)
            <div class="mb-3">
                <h4 class="text-primary">{{ $category->name }}</h4>
                <ul class="list-group">
                    @foreach ($category->services as $service)
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            {{ $service->name }}
                            <span class="badge bg-success">Rp {{ number_format($service->price, 2) }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endforeach
    </div>

    <div class="mb-5">
        <h2>Available Tailors</h2>
        <ul class="list-group">
            @foreach ($tailors as $tailor)
                <li class="list-group-item">
                    <strong>{{ $tailor->user->name }}</strong> - {{ $tailor->specialization }} ({{ $tailor->experience }} tahun)
                </li>
            @endforeach
        </ul>
    </div>

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0">Form Pemesanan</h4>
        </div>
        <div class="card-body">
            <form action="{{ route('customer.createOrder') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label for="tailor_id" class="form-label">Pilih Penjahit</label>
                    <select name="tailor_id" id="tailor_id" class="form-select" required>
                        <option value="">-- Pilih Penjahit --</option>
                        @foreach ($tailors as $tailor)
                            <option value="{{ $tailor->id }}">{{ $tailor->user->name }}</option>
                        @endforeach
                    </select>
                    @error('tailor_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="service_id" class="form-label">Pilih Layanan</label>
                    <select name="service_id" id="service_id" class="form-select" required>
                        <option value="">-- Pilih Layanan --</option>
                        @foreach ($categories as $category)
                            <optgroup label="{{ $category->name }}">
                                @foreach ($category->services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                    @error('service_id')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="measurement" class="form-label">Detail Ukuran</label>
                    <textarea name="measurement" id="measurement" class="form-control" rows="4" placeholder="Contoh: Lingkar dada, panjang lengan..." required></textarea>
                    @error('measurement')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="reference_image" class="form-label">Upload Gambar Referensi</label>
                    <input type="file" name="reference_image" id="reference_image" class="form-control" accept="image/jpeg,image/png,image/jpg">
                    @error('reference_image')
                        <div class="text-danger small">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-success w-100">Buat Pesanan</button>
            </form>
        </div>
    </div>
</div>
@endsection
