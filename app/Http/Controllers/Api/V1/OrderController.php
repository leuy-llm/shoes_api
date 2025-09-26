<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use App\Models\Cart;

class OrderController extends Controller
{
    //
    public function store(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'items' => 'required|array',
        'items.*.product_id' => 'required|exists:products,id',
        'items.*.quantity' => 'required|integer|min:1',
        'items.*.price' => 'required|numeric',
        'address.name' => 'required|string|max:255',
        'address.email' => 'required|email',
        'address.phone' => 'required|string|max:20',
        'address.address' => 'required|string|max:255',
        'address.city' => 'required|string|max:255',
        'address.zip_code' => 'required|string|max:20',
        'address.card' => 'required|string|max:20',
        'address.expiry' => 'required|string|max:10',
        'address.cvv' => 'required|string|max:5',
        'address.name_on_card' => 'required|string|max:255',
    ]);

    DB::beginTransaction();

    try {
        $total = collect($request->items)->sum(fn($item) => $item['price'] * $item['quantity']);
        $tax = $total * 0.08;
        $shipping = $total > 100 ? 0 : 9.99;
        $finalTotal = $total + $tax + $shipping;

        $order = Order::create([
            'user_id' => $request->user_id,
            'total' => $total,
            'tax' => $tax,
            'shipping' => $shipping,
            'final_total' => $finalTotal,
            'status' => 'pending',
        ]);

        foreach ($request->items as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
            ]);
        }

        OrderAddress::create([
            'order_id' => $order->id,
            'name' => $request->address['name'],
            'email' => $request->address['email'],
            'phone' => $request->address['phone'],
            'address' => $request->address['address'],
            'city' => $request->address['city'],
            'zip_code' => $request->address['zip_code'],
            'card' => $request->address['card'],
            'expiry' => $request->address['expiry'],
            'cvv' => $request->address['cvv'],
            'name_on_card' => $request->address['name_on_card'],
        ]);

        Cart::where('user_id', $request->user_id)->delete();

        DB::commit();

        return response()->json([
            'success' => true,
            'order_id' => $order->id,
            'order' => $order->load('items', 'address')
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
    }
}
}
