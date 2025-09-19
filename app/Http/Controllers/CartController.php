<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        return view('cart.index');
    }

    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // This would typically handle server-side cart management
        // For now, we'll use client-side cart with localStorage
        
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được thêm vào giỏ hàng'
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        // This would typically handle server-side cart management
        
        return response()->json([
            'success' => true,
            'message' => 'Giỏ hàng đã được cập nhật'
        ]);
    }

    public function remove(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id'
        ]);

        // This would typically handle server-side cart management
        
        return response()->json([
            'success' => true,
            'message' => 'Sản phẩm đã được xóa khỏi giỏ hàng'
        ]);
    }

    public function clear()
    {
        // This would typically handle server-side cart management
        
        return response()->json([
            'success' => true,
            'message' => 'Giỏ hàng đã được xóa'
        ]);
    }
}
