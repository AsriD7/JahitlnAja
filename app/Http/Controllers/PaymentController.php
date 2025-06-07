<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use App\Models\Order;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function create(Order $order)
    {
        return view('user.payments.create', compact('order'));
    }

    public function store(Request $request, Order $order)
    {
        $request->validate([
            'amount' => 'required|numeric',
        ]);

        Payment::create([
            'order_id' => $order->id,
            'amount' => $request->amount,
            'status' => 'pending',
        ]);

        return redirect()->route('orders.index')->with('success', 'Pembayaran berhasil dikirim');
    }
}
