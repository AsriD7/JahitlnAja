@extends('layouts.appPelanggan')
@section('title', 'Pesanan Saya')

@section('content')
<div class="container my-5">
    <h1 class="mb-4 text-center">Pesanan Saya</h1>

    {{-- Notifikasi --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Tabel Pesanan --}}
    <div class="table-responsive">
        <table class="table table-bordered table-striped align-middle text-center">
            <thead class="table-primary">
                <tr>
                    <th>Penjahit</th>
                    <th>Layanan</th>
                    <th>Ukuran</th>
                    <th>Gambar Referensi</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->tailor->user->name }}</td>
                        <td>{{ $order->service->name }}</td>
                        <td>{{ $order->measurement }}</td>
                        <td>
                            @if ($order->reference_image)
                                <img src="{{ asset('storage/' . $order->reference_image) }}" alt="Referensi" class="img-thumbnail" style="max-width: 100px;">
                            @else
                                <span class="text-muted">Tidak ada gambar</span>
                            @endif
                        </td>
                        <td>Rp {{ number_format($order->total_price, 2) }}</td>
                        <td>
                            @if ($order->status == 'pending')
                                <span class="badge bg-warning text-dark">Pending</span>
                            @elseif ($order->status == 'paid')
                                <span class="badge bg-success">Lunas</span>
                            @elseif ($order->status == 'processing')
                                <span class="badge bg-info text-dark">Diproses</span>
                            @elseif ($order->status == 'done')
                                <span class="badge bg-primary">Selesai</span>
                            @else
                                <span class="badge bg-secondary">{{ $order->status }}</span>
                            @endif
                        </td>
                        <td>
                            @if ($order->status == 'pending')
                                <form action="{{ route('customer.uploadPayment', $order) }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="mb-2">
                                        <input type="file" name="payment_proof" class="form-control form-control-sm" required>
                                    </div>
                                    <button type="submit" class="btn btn-sm btn-success">Upload Bukti</button>
                                </form>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center text-muted">Belum ada pesanan</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
