@extends('layouts.appPelanggan')
@section('title', 'Buat Pesanan')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
    .card-hover:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .btn-primary {
        background-color: #8c0d4f !important;
        border-color: #8c0d4f !important;
    }
    .text-custom {
        color: #8c0d4f !important;
    }
    .btn-gradient {
        background: linear-gradient(90deg, #28a745, #20c997);
        border: none;
        transition: all 0.3s ease;
    }
    .btn-gradient:hover {
        background: linear-gradient(90deg, #20c997, #28a745);
    }
    .service-card {
        border-left: 0;
        border-right: 0;
        margin-bottom: 10px;
    }
    .preview-image {
        max-width: 150px;
        border-radius: 8px;
        margin-top: 10px;
    }
    .section-title {
        position: relative;
        display: inline-block;
        margin-bottom: 20px;
    }
    .section-title::after {
        content: '';
        width: 50px;
        height: 3px;
        background: #28a745;
        position: absolute;
        bottom: -10px;
        left: 0;
    }
    .tailor-option {
        margin-bottom: 10px;
    }
    .tailor-option input[type="radio"] {
        margin-right: 10px;
    }
    .tailor-option label {
        display: inline-block;
        padding: 5px 10px;
        border: 1px solid #ddd;
        border-radius: 5px;
        cursor: pointer;
    }
    .tailor-option input[type="radio"]:checked + label {
        background-color: #28a745;
        color: white;
    }
    
</style>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="text-center mb-5 ">Buat Pesanan Baru</h1>

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Available Services -->
            <div class="mb-5">
                {{-- <h3 class="section-title">Layanan Tersedia</h3> --}}
                <div class="accordion" id="servicesAccordion">
                    @foreach ($categories as $category)
                        <div class="accordion-item card-hover">
                            <h2 class="accordion-header" id="heading{{ $category->id }}">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                        data-bs-target="#collapse{{ $category->id }}" aria-expanded="false" 
                                        aria-controls="collapse{{ $category->id }}">
                                    <strong>{{ $category->name }}</strong>
                                </button>
                            </h2>
                            <div id="collapse{{ $category->id }}" class="accordion-collapse collapse" 
                                 aria-labelledby="heading{{ $category->id }}" data-bs-parent="#servicesAccordion">
                                <div class="accordion-body">
                                    <div class="row">
                                        @foreach ($category->services as $service)
                                            <div class="col-md-6 mb-3">
                                                <div class="card service-card">
                                                    <div class="card-body d-flex justify-content-between align-items-center">
                                                        <span>{{ $service->name }}</span>
                                                        <span class="badge bg-success">Rp {{ number_format($service->price, 2) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Available Tailors -->
            <div class="mb-5">
                {{-- <h3 class="section-title">Penjahit Tersedia</h3> --}}
                <div class="row">
                    @foreach ($tailors as $tailor)
                        <div class="col-md-6 mb-4">
                            <div class="card card-hover">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $tailor->user->name }}</h5>
                                    <p class="card-text">
                                        <strong>Spesialisasi:</strong> {{ $tailor->specialization }}<br>
                                        <strong>Pengalaman:</strong> {{ $tailor->experience }} tahun<br>
                                        <strong>Layanan:</strong> {{ $tailor->services->pluck('name')->join(', ') ?: 'Belum ada layanan' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Order Form -->
            <div class="card shadow-lg">
                {{-- <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Form Pemesanan</h4>
                </div> --}}
                <div class="card-body">
                    <form action="{{ route('customer.createOrder') }}" method="POST" enctype="multipart/form-data" id="orderForm">
                        @csrf

                        <div class="mb-4">
                            <label for="service_id" class="form-label fw-bold">Pilih Layanan</label>
                            <select name="service_id" id="service_id" class="form-select @error('service_id') is-invalid @enderror" 
                                    required data-bs-toggle="tooltip" title="Pilih layanan yang diinginkan">
                                <option value="">-- Pilih Layanan --</option>
                                @foreach ($categories as $category)
                                    <optgroup label="{{ $category->name }}">
                                        @foreach ($category->services as $service)
                                            <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }} (Rp {{ number_format($service->price, 2) }})
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Pilih Penjahit</label>
                            <div class="tailor-options">
                                @foreach ($tailors as $tailor)
                                    <div class="tailor-option">
                                        <input type="radio" name="tailor_id" id="tailor_{{ $tailor->id }}" value="{{ $tailor->id }}" 
                                               required {{ old('tailor_id') == $tailor->id ? 'checked' : '' }}>
                                        <label for="tailor_{{ $tailor->id }}" class="ms-2">
                                            {{ $tailor->user->name }} (Spesialisasi: {{ $tailor->specialization }}, Pengalaman: {{ $tailor->experience }} tahun)
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @error('tailor_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="measurement" class="form-label fw-bold">Detail Ukuran</label>
                            <textarea name="measurement" id="measurement" class="form-control @error('measurement') is-invalid @enderror" 
                                      rows="5" placeholder="Contoh: Lingkar dada: 90 cm, Panjang lengan: 60 cm..." 
                                      required>{{ old('measurement') }}</textarea>
                            @error('measurement')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="reference_image" class="form-label fw-bold">Upload Gambar Referensi (Opsional)</label>
                            <input type="file" name="reference_image" id="reference_image" 
                                   class="form-control @error('reference_image') is-invalid @enderror" 
                                   accept="image/jpeg,image/png,image/jpg">
                            <div id="image-preview" class="mt-2"></div>
                            @error('reference_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Buat Pesanan Sekarang</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize Select2
        $('#service_id').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih layanan yang diinginkan',
            allowClear: true,
            width: '100%'
        });

        // Initialize Tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Image Preview
        $('#reference_image').on('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#image-preview').html('<img src="' + e.target.result + '" class="preview-image" alt="Preview">');
                };
                reader.readAsDataURL(file);
            } else {
                $('#image-preview').empty();
            }
        });

        // Form Submission Confirmation
        $('#orderForm').on('submit', function(e) {
            if (!confirm('Apakah Anda yakin ingin membuat pesanan ini?')) {
                e.preventDefault();
            }
        });
    });
</script>
@endpush
@endsection
