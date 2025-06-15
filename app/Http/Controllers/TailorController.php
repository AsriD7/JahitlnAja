<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Tailor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;
class TailorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:penjahit']);
    }

    public function index()
    {
        $user = auth()->user();
        $tailor = $user->tailor;

        if (!$tailor) {
            return redirect()->route('tailor.showProfile')->with('error', 'Please update your profile to continue.');
        }

        $orders = Order::where('tailor_id', $tailor->id)->with(['customer', 'service'])->get();
        return view('penjahit.dashboard', compact('orders'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:accepted,in_progress,completed',
        ]);

        $tailor = auth()->user()->tailor;
        if (!$tailor || $order->tailor_id !== $tailor->id) {
            return redirect()->route('tailor.index')->with('error', 'Unauthorized action.');
        }

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'status' => $request->status,
            ]);
        });

        return redirect()->route('tailor.index')->with('success', 'Order status updated successfully.');
    }

    public function profile(Request $request)
    {
        $request->validate([
            'specialization' => 'required|string',
            'experience' => 'required|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            Tailor::updateOrCreate(
                ['user_id' => auth()->user()->id],
                [
                    'specialization' => $request->specialization,
                    'experience' => $request->experience,
                ]
            );
        });

        return redirect()->route('tailor.showProfile')->with('success', 'Profile updated successfully.');
    }

    public function showProfile()
    {
        $tailor = Tailor::where('user_id', auth()->user()->id)->first();
        return view('penjahit.profile', compact('tailor'));
    }
}
