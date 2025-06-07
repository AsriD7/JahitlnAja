<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;



class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function produk()
    {
        $products = Product::with('user')->latest()->get();
        return view('pelanggan.produk.index', compact('products'));
    }

    public function show(Product $product)
    {
        return view('pelanggan.produk.show', compact('product'));
    }

    use AuthorizesRequests;
    public function index()
    {
        $products = Product::where('user_id', Auth::id())->get();
        return view('penjahit.produk.index', compact('products'));
    }

    public function create()
    {
        return view('penjahit.produk.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'type' => 'required|in:atasan,bawahan,terusan',
            'description' => 'required',
            'price' => 'required|numeric'
        ]);

        Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
        ]);

        return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        return view('penjahit.produk.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);

        $product->update($request->only(['name', 'type', 'description', 'price']));
        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Product $product)
    {
        $this->authorize('delete', $product);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
