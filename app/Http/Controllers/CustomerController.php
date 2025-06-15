<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Service;
use App\Models\Tailor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:user']);
    }

    public function index()
    {
        $categories = Category::with('services')->get();
        $tailors = Tailor::with('user')->get();
        return view('pelanggan.order', compact('categories', 'tailors'));
    }

    public function createOrder(Request $request)
    {
        $request->validate([
            'tailor_id' => 'required|exists:tailors,id',
            'service_id' => 'required|exists:services,id',
            'measurement' => 'required|string',
            'reference_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        DB::transaction(function () use ($request) {
            $service = Service::find($request->service_id);
            $data = [
                'customer_id' => auth()->user()->id,
                'tailor_id' => $request->tailor_id,
                'service_id' => $request->service_id,
                'measurement' => $request->measurement,
                'total_price' => $service->price,
                'status' => 'pending',
            ];

            if ($request->hasFile('reference_image')) {
                $data['reference_image'] = $request->file('reference_image')->store('references', 'public');
            }

            Order::create($data);
        });

        return redirect()->route('customer.orders')->with('success', 'Order created successfully.');
    }

    public function orders()
    {
        $orders = Order::where('customer_id', auth()->user()->id)->with(['tailor.user', 'service'])->get();
        return view('pelanggan.myorder', compact('orders'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($order->customer_id !== auth()->user()->id) {
            return redirect()->route('pelanggan.myorder')->with('error', 'Unauthorized action.');
        }

        DB::transaction(function () use ($request, $order) {
            if ($request->hasFile('payment_proof')) {
                $path = $request->file('payment_proof')->store('payments', 'public');
                $order->update([
                    'payment_proof' => $path,
                    'status' => 'payment_uploaded',
                ]);
            }
        });

        return redirect()->route('customer.orders')->with('success', 'Payment proof uploaded successfully.');
    }
}
