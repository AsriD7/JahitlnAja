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
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('profile.password.update') }}" method="POST">
        @csrf @method('PUT')
            <div class="mb-3">
            <label>Password Lama</label>
            <input type="password" name="old_password" class="form-control" required>
             </div>
            <div class="mb-3">
            <label>Password Baru</label>
            <input type="password" name="new_password" class="form-control" required>
            </div>
            <div class="mb-3">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="new_password_confirmation" class="form-control" required>
             </div>
            <button class="btn btn-primary">Update Password</button>
            </form>
            </div>
        </div>
    </div>
</section>
@endsection
