<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;
use App\Models\Category;
use App\Models\Tailor;
use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as Controller;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }
    
    public function orders()
    {
        $orders = Order::with(['customer', 'tailor.user', 'service'])
                       ->where('status', 'payment_uploaded')
                       ->get();
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Verify payment and update order status.
     */
    public function verifyPayment(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:paid,rejected',
        ]);

        if ($order->status !== 'payment_uploaded') {
            return redirect()->route('admin.orders')->with('error', 'Pesanan ini tidak dapat diverifikasi.');
        }

        DB::transaction(function () use ($request, $order) {
            $order->update([
                'status' => $request->status,
            ]);

            if ($request->status === 'paid') {
                // Opsional: Kirim notifikasi ke penjahit (bisa ditambahkan logika email atau notifikasi)
            }
        });

        $message = $request->status === 'paid' ? 'Pembayaran berhasil diverifikasi.' : 'Pembayaran ditolak.';
        return redirect()->route('admin.orders')->with('success', $message);
    }

    /**
     * Display a listing of the users.
     */
    public function users()
    {
        $penjahits = User::where('role', 'penjahit')->get();
        $pelanggans = User::where('role', 'user')->get();
        return view('admin.users.index', compact('penjahits', 'pelanggans'));
    }

    public function createUser()
    {
        return view('admin.users.create');
    }

    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:penjahit,user'
        ]);

        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => $request->role,
            ]);

            if ($request->role === 'penjahit') {
                Tailor::create([
                    'user_id' => $user->id,
                    'specialization' => '',
                    'experience' => 0,
                ]);
            }
        });

        return redirect()->route('admin.users')->with('success', 'Akun berhasil ditambahkan');
    }

    public function editUser(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:penjahit,user'
        ]);

        DB::transaction(function () use ($request, $user) {
            if ($user->role !== $request->role) {
                if ($request->role === 'penjahit') {
                    Tailor::create([
                        'user_id' => $user->id,
                        'specialization' => '',
                        'experience' => 0,
                    ]);
                } elseif ($user->role === 'penjahit') {
                    $tailor = Tailor::where('user_id', $user->id)->first();
                    if ($tailor) {
                        $tailor->services()->detach();
                        $tailor->delete();
                    }
                }
            }

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'role' => $request->role,
            ]);
        });

        return redirect()->route('admin.users')->with('success', 'Akun berhasil diperbarui');
    }

    public function destroyUser(User $user)
    {
        DB::transaction(function () use ($user) {
            if ($user->role === 'penjahit') {
                $tailor = Tailor::where('user_id', $user->id)->first();
                if ($tailor) {
                    $tailor->services()->detach();
                    $tailor->delete();
                }
            }
            $user->delete();
        });

        return redirect()->route('admin.users')->with('success', 'Akun berhasil dihapus');
    }

    /**
     * Display a listing of the services.
     */
    public function services()
    {
        $services = Service::with('category')->get();
        return view('admin.services.index', compact('services'));
    }

    /**
     * Show the form for creating a new service.
     */
    public function createService()
    {
        $categories = Category::all();
        return view('admin.services.create', compact('categories'));
    }

    /**
     * Store a newly created service in storage.
     */
    public function storeService(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        Service::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.services')->with('success', 'Layanan berhasil ditambahkan');
    }

    /**
     * Show the form for editing the specified service.
     */
    public function editService(Service $service)
    {
        $categories = Category::all();
        return view('admin.services.edit', compact('service', 'categories'));
    }

    /**
     * Update the specified service in storage.
     */
    public function updateService(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
        ]);

        $service->update([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('admin.services')->with('success', 'Layanan berhasil diperbarui');
    }

    /**
     * Remove the specified service from storage.
     */
    public function destroyService(Service $service)
    {
        DB::transaction(function () use ($service) {
            $service->tailors()->detach(); // Hapus hubungan di tabel pivot
            $service->delete();
        });

        return redirect()->route('admin.services')->with('success', 'Layanan berhasil dihapus');
    }
}