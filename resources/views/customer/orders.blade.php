<!DOCTYPE html>
<html>
<head>
    <title>My Orders</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <h1>My Orders</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif
    <table>
        <tr>
            <th>Tailor</th>
            <th>Service</th>
            <th>Measurement</th>
            <th>Reference Image</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->tailor->user->name }}</td>
                <td>{{ $order->service->name }}</td>
                <td>{{ $order->measurement }}</td>
                <td>
                    @if ($order->reference_image)
                        <img src="{{ Storage::url($order->reference_image) }}" alt="Reference" style="max-width: 100px;">
                    @else
                        No Image
                    @endif
                </td>
                <td>Rp {{ number_format($order->total_price, 2) }}</td>
                <td>{{ $order->status }}</td>
                <td>
                    @if ($order->status == 'pending')
                        <form action="{{ route('customer.uploadPayment', $order) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="file" name="payment_proof">
                            <button type="submit">Upload Payment</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>