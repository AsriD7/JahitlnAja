<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>
    <link href="{{ asset('assets/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <h1>Customer Dashboard</h1>
    <h2>Available Services</h2>
    @foreach ($categories as $category)
        <h3>{{ $category->name }}</h3>
        <ul>
            @foreach ($category->services as $service)
                <li>{{ $service->name }} - Rp {{ number_format($service->price, 2) }}</li>
            @endforeach
        </ul>
    @endforeach

    <h2>Available Tailors</h2>
    <ul>
        @foreach ($tailors as $tailor)
            <li>{{ $tailor->user->name }} - {{ $tailor->specialization }} ({{ $tailor->experience }} years)</li>
        @endforeach
    </ul>

    <h2>Create Order</h2>
    <form action="{{ route('customer.createOrder') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <select name="tailor_id">
            <option value="">Select Tailor</option>
            @foreach ($tailors as $tailor)
                <option value="{{ $tailor->id }}">{{ $tailor->user->name }}</option>
            @endforeach
        </select>
        <select name="service_id">
            <option value="">Select Service</option>
            @foreach ($categories as $category)
                <optgroup label="{{ $category->name }}">
                    @foreach ($category->services as $service)
                        <option value="{{ $service->id }}">{{ $service->name }}</option>
                    @endforeach
                </optgroup>
            @endforeach
        </select>
        <textarea name="measurement" placeholder="Enter measurements"></textarea>
        <input type="file" name="reference_image" accept="image/jpeg,image/png,image/jpg">
        <button type="submit">Create Order</button>
    </form>
</body>
</html>