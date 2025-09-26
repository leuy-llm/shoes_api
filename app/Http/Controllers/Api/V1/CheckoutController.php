<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;

class CheckoutController extends Controller
{
   
    /** Process checkout */
    public function checkout(Request $request)
    {
        // Validate request
        try {
            $request->validate([
                'name'         => 'required|string|max:255',
                'email'        => 'required|email',
                'phone'        => 'required|string|max:20',
                'address'      => 'required|string|max:255',
                'city'         => 'required|string|max:100',
                'zip_code'     => 'required|string|max:20',
                'card'         => 'nullable|string|max:20',
                'expiry'       => 'nullable|string|max:10',
                'cvv'          => 'nullable|string|max:5',
                'name_on_card' => 'nullable|string|max:255',
            ]);

            $userId = 2;

            //Get cart items
            $cartItems = Cart::with('product')->where('user_id', $userId)->get();

            if($cartItems->isEmpty()) {
                return response()->json([
                    'error' => 'No items in cart',
                    'message' => 'Cart is empty'
                ],400);
            }

            //Calculate total
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
            $tax = round($total * 0.1, 2);
            $shipping = 5.00;
            $finalTotal = $total + $tax + $shipping;

            //Create order
            $order = Order::create([
                'user_id' => $userId,
                'total' => $total,
                'tax' => $tax,
                'shipping' => $shipping,
                'final_total' => $finalTotal,
                'status' => 'pending',
            ]);

            //Create order items
            foreach ($cartItems as $cartItem) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $cartItem->product_id,
                    'quantity' => $cartItem->quantity,
                    'price' => $cartItem->product->price,
                ]);
            }

            //Create order address
            OrderAddress::create([
                'order_id' => $order->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'city' => $request->city,
                'zip_code' => $request->zip_code,
                'card' => $request->card,
                'expiry' => $request->expiry,
                'cvv' => $request->cvv,
                'name_on_card' => $request->name_on_card,
            ]);

            //Clear cart
            Cart::where('user_id', $userId)->delete();

            return response()->json([
                'message' => 'Order created successfully',
                'order_id' => $order->id,
            ],201);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],500);
        }
    }
}
