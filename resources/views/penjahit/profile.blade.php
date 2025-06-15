@extends('layouts.appPenjahit')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">

            <div class="card shadow rounded-4">
                <div class="card-body">
                    <h3 class="card-title text-center mb-4">Update Profil Penjahit</h3>

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

                    <form action="{{ route('tailor.profile') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="specialization" class="form-label">Spesialisasi</label>
                            <input type="text" class="form-control" id="specialization" name="specialization"
                                value="{{ old('specialization', $tailor->specialization ?? '') }}" placeholder="Contoh: Atasan wanita, kebaya">
                        </div>

                        <div class="mb-3">
                            <label for="experience" class="form-label">Pengalaman (Tahun)</label>
                            <input type="number" class="form-control" id="experience" name="experience"
                                value="{{ old('experience', $tailor->experience ?? 0) }}" min="0">
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Simpan Perubahan</button>
                    </form>

                    <div class="text-center mt-3">
                        <a href="{{ route('tailor.index') }}" class="btn btn-link">← Kembali ke Dashboard</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
