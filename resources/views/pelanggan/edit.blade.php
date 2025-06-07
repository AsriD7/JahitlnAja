@extends('layouts.appPelanggan')
@section('content')
<style>
        .btn-primary {
            background-color: #8c0d4f !important;
            border-color: #8c0d4f !important;
        }
        .text-custom {
        color: #8c0d4f !important;
    }
    </style>
<section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="personal-info-form" data-aos="fade-up" data-aos-delay="100">
            <div class="tab-header">
    <form action="{{ route('profile.update') }}" method="POST">
        @csrf @method('PUT')
        <div class="mb-3">
            <label>Nama</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-3">
            <label>No HP</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $profile->phone ?? '') }}">
        </div>
        <div class="mb-3">
            <label>Alamat</label>
            <textarea name="address" class="form-control">{{ old('address', $profile->address ?? '') }}</textarea>
        </div>
        <button class="btn btn-primary">Simpan</button>
        <a href="{{ route('profile.password') }}" class="btn btn-warning">Ganti Password</a>
    </form>
</div>
</div>
            </div>
    </section>
@endsection