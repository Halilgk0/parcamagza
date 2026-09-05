<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of all orders
     */
    public function index()
    {
        $orders = Order::with(['user', 'items.part', 'address'])
            ->latest()
            ->paginate(10);
            
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the specified order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'items.part', 'address']);
        
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update order status
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled,awaiting_payment',
            'payment_status' => 'required|in:pending,completed,failed,refunded'
        ]);

        $order->update($validated);

        return back()->with('success', 'Sipariş durumu başarıyla güncellendi.');
    }
} 