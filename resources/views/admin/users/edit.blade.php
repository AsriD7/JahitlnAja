@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Edit Akun</h3>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <input type="text" name="name" value="{{ $user->name }}" class="form-control mb-2">
        <input type="email" name="email" value="{{ $user->email }}" class="form-control mb-2">
        <select name="role" class="form-control mb-3">
            <option value="penjahit" {{ $user->role === 'penjahit' ? 'selected' : '' }}>Penjahit</option>
            <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Pelanggan</option>
        </select>
        <button type="submit" class="btn btn-primary">Perbarui</button>
    </form>
</div>
@endsection
