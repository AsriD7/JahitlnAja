@extends('layouts.appPelanggan')
@section('content')
{{-- <div class="container">
    <h1>Profil Saya</h1>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <ul class="list-group">
        <li class="list-group-item"><strong>Nama:</strong> {{ $user->name }}</li>
        <li class="list-group-item"><strong>Email:</strong> {{ $user->email }}</li>
        <li class="list-group-item"><strong>No HP:</strong> {{ $user->profile->phone ?? '-' }}</li>
        <li class="list-group-item"><strong>Alamat:</strong> {{ $user->profile->address ?? '-' }}</li>
    </ul>
    <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
    <a href="{{ route('profile.password') }}" class="btn btn-warning mt-3">Ganti Password</a>
</div>
<div class="tab-pane fade" id="personal" role="tabpanel" aria-labelledby="personal-tab">
    <h2>Personal Information</h2>
</div> --}}
<section id="account" class="account section">
      <div class="container" data-aos="fade-up" data-aos-delay="100">
          <div class="personal-info-form" data-aos="fade-up" data-aos-delay="100">
            <div class="tab-header">
                <form class="php-email-form" action="{{ route('profile.update') }}" method="POST">
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
                    {{-- <div class="error-message"></div>
                    <div class="sent-message">Your information has been updated. Thank you!</div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-save">Save Changes</button>
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary mt-3">Edit Profil</a>
                        <a href="{{ route('profile.password') }}" class="btn btn-warning mt-3">Ganti Password</a>
                    </div> --}}
                    
                </form>

            </div>
            </div>
    </section>
@endsection