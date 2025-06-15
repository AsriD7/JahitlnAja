<!DOCTYPE html>
<html>
<head>
    <title>Tailor Dashboard</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <h1>Tailor Dashboard</h1>
    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if (session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <h2>Update Profile</h2>
    <form action="{{ route('tailor.profile') }}" method="POST">
        @csrf
        <input type="text" name="specialization" placeholder="Specialization">
        <input type="number" name="experience" placeholder="Years of Experience">
        <button type="submit">Update Profile</button>
    </form>

    <h2>Received Orders</h2>
    <table>
        <tr>
            <th>Customer</th>
            <th>Service</th>
            <th>Measurement</th>
            <th>Reference Image</th>
            <th>Total Price</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        @foreach ($orders as $order)
            <tr>
                <td>{{ $order->customer->name }}</td>
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
                    @if ($order->status != 'completed')
                        <form action="{{ route('tailor.updateStatus', $order) }}" method="POST">
                            @csrf
                            <select name="status">
                                <option value="accepted">Accept</option>
                                <option value="in_progress">In Progress</option>
                                <option value="completed">Complete</option>
                            </select>
                            <button type="submit">Update Status</button>
                        </form>
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>