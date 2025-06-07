@extends('layouts.appAdmin')

@section('content')
<div class="container">
    <h1 class="mb-4">Manajemen Pengguna</h1>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Tambah Akun</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <h4>Penjahit</h4>
    <table class="table table-bordered">
        <thead><tr><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($penjahits as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <h4>Pelanggan</h4>
    <table class="table table-bordered">
        <thead><tr><th>Nama</th><th>Email</th><th>Aksi</th></tr></thead>
        <tbody>
        @foreach($pelanggans as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
@endsection