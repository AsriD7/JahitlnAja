<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())->get();
        return view('user.orders.index', compact('orders'));
    }

    public function create(Product $product)
    {
        return view('user.orders.create', compact('product'));
    }

    public function store(Request $request, Product $product)
    {
        Order::create([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dibuat');
    }

    public function show(Order $order)
    {
        return view('user.orders.show', compact('order'));
    }
}
