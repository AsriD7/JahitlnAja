@extends('layouts.appPenjahit')
@section('title', 'Profil Penjahit')

@section('content')
<div class="container py-5 fade-in">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="mb-4 ">Profil Penjahit: {{ auth()->user()->name }}</h2>
                <a href="{{ route('tailor.index') }}" class="btn btn-outline-secondary">Kembali ke Dashboard</a>
            </div>

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

            <div class="card shadow-sm">
                <div class="card-header" style="background: linear-gradient(135deg, #8c0d4f, #700a3f); color: #fff;">
                    <h5 class="mb-0 text-white">Perbarui Profil</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('tailor.profile') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="specialization" class="form-label fw-bold text-dark">Spesialisasi</label>
                            <input type="text" class="form-control @error('specialization') is-invalid @enderror" 
                                   id="specialization" name="specialization" 
                                   value="{{ old('specialization', $tailor->specialization ?? '') }}" 
                                   placeholder="Contoh: Atasan, Bawahan" required>
                            @error('specialization')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label fw-bold text-dark">Tahun Pengalaman</label>
                            <input type="number" class="form-control @error('experience') is-invalid @enderror" 
                                   id="experience" name="experience" 
                                   value="{{ old('experience', $tailor->experience ?? 0) }}" 
                                   placeholder="Contoh: 5" min="0" required>
                            @error('experience')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="services" class="form-label fw-bold text-dark">Layanan yang Dikuasai</label>
                            <select name="services[]" id="services" class="form-select @error('services') is-invalid @enderror" 
                                    multiple required aria-label="Pilih layanan yang dikuasai">
                                @foreach ($services->groupBy('category.name') as $categoryName => $categoryServices)
                                    <optgroup label="{{ $categoryName }}">
                                        @foreach ($categoryServices as $service)
                                            <option value="{{ $service->id }}" 
                                                    {{ old('services', $tailor && $tailor->services->contains($service->id) ? 'selected' : '') }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </optgroup>
                                @endforeach
                            </select>
                            @error('services')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('tailor.index') }}" class="btn btn-outline-secondary">Batal</a>
                            <button type="submit" class="btn btn-primary ">Perbarui Profil</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .btn-primary {
            background-color: #8c0d4f !important;
            border-color: #8c0d4f !important;
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
    .card {
        transition: all 0.3s ease;
        border: none;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(255, 0, 0, 0.1);
    }
    .btn-custom {
        background-color: #8c0d4f;
        border-color: #8c0d4f;
        color: #fff;
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
    .form-select {
        height: auto !important;
    }
</style>



<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('#services').select2({
            theme: 'bootstrap-5',
            placeholder: 'Pilih layanan yang dikuasai',
            allowClear: true,
            width: '100%',
            dropdownParent: $('#services').parent()
        });
    });
</script>

@endsection
