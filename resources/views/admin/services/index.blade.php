@extends('layouts.appAdmin')

@section('title', 'Kelola Layanan')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Kelola Layanan</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="mb-3">
        <a href="{{ route('admin.createService') }}" class="btn btn-primary">Tambah Layanan</a>
    </div>

    <div class="card">
        <div class="card-header">Daftar Layanan</div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Layanan</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($services as $service)
                        <tr>
                            <td>{{ $service->name }}</td>
                            <td>{{ $service->category->name }}</td>
                            <td>{{ $service->description ?? '-' }}</td>
                            <td>Rp {{ number_format($service->price, 2) }}</td>
                            <td>
                                <a href="{{ route('admin.editService', $service) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('admin.destroyService', $service) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus layanan ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada layanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection