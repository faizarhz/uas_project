<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AdminStockController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('admin.stock', compact('products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'stock' => 'required|integer|min:0'
        ]);

        $product = Product::findOrFail($id);

        $product->update([
            'stock' => $request->stock
        ]);

        return back()->with('success', 'Stok berhasil diperbarui.');
    }
}
