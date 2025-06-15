@extends('layouts.appPenjahit')

@section('content')
<div class="container py-5">
    <h2 class="mb-4">Selamat datang, {{ auth()->user()->name }}</h2>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card mb-4">
        <div class="card-header">Update Profile</div>
        <div class="card-body">
            <form action="{{ route('tailor.profile') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="specialization" class="form-label">Specialization</label>
                    <input type="text" class="form-control" name="specialization" placeholder="e.g. Atasan, Bawahan" required>
                </div>
                <div class="mb-3">
                    <label for="experience" class="form-label">Years of Experience</label>
                    <input type="number" class="form-control" name="experience" placeholder="e.g. 5" min="0" required>
                </div>
                <button type="submit" class="btn btn-primary">Update Profile</button>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Received Orders</div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center">
                    <thead class="table-light">
                        <tr>
                            <th>Customer</th>
                            <th>Service</th>
                            <th>Measurement</th>
                            <th>Reference Image</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                            <tr>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ $order->service->name }}</td>
                                <td>{{ $order->measurement }}</td>
                                <td>
                                    @if ($order->reference_image)
                                        <img src="{{ asset('storage/' . $order->reference_image) }}"alt="Reference"class="img-thumbnail zoomable-img"style="max-width: 100px; cursor: zoom-in;">

                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($order->total_price, 2) }}</td>
                                <td>
                                    <span class="badge bg-secondary text-uppercase">{{ $order->status }}</span>
                                </td>
                                <td>
                                    @if ($order->status != 'completed')
                                        <form action="{{ route('tailor.updateStatus', $order) }}" method="POST">
                                            @csrf
                                            <div class="input-group">
                                                <select name="status" class="form-select">
                                                    <option value="accepted">Accept</option>
                                                    <option value="in_progress">In Progress</option>
                                                    <option value="completed">Complete</option>
                                                </select>
                                                <button type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </form>
                                    @else
                                        <span class="text-muted">Done</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-muted">No orders received yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<!-- Modal Gambar -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-transparent border-0">
      <div class="modal-body p-0 text-center">
        <img id="modalImage" src="" class="img-fluid rounded" style="max-height: 90vh;">
      </div>
    </div>
  </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = new bootstrap.Modal(document.getElementById('imageModal'));
        const modalImage = document.getElementById('modalImage');

        document.querySelectorAll('.zoomable-img').forEach(img => {
            img.addEventListener('click', () => {
                modalImage.src = img.src;
                modal.show();
            });
        });
    });
</script>

@endsection
