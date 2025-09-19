<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function checkout()
    {
        return view('checkout');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'notes' => 'nullable|string',
            'payment_method' => 'required|in:cod,bank_transfer'
        ]);

        try {
            DB::beginTransaction();

            // Create order
            $order = Order::create([
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'customer_phone' => $request->customer_phone,
                'shipping_address' => $request->shipping_address,
                'subtotal' => 0, // Will be calculated
                'shipping_fee' => 30000,
                'total' => 0, // Will be calculated
                'status' => 'pending',
                'notes' => $request->notes
            ]);

            // Get cart items from session or request
            $cartItems = $request->cart_items ?? [];
            $subtotal = 0;

            foreach ($cartItems as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $item['quantity'],
                        'price' => $product->current_price
                    ]);

                    $subtotal += $product->current_price * $item['quantity'];
                }
            }

            // Update order totals
            $order->update([
                'subtotal' => $subtotal,
                'total' => $subtotal + $order->shipping_fee
            ]);

            DB::commit();

            return response()->json([
                'success' => true,
                'order_id' => $order->id,
                'message' => 'Đơn hàng đã được tạo thành công!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra khi tạo đơn hàng!'
            ], 500);
        }
    }

    public function show(Order $order)
    {
        $order->load('orderItems.product');
        return view('orders.show', compact('order'));
    }
}
