<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;

class CartController extends Controller
{
    /**
     * Get all cart items for user_id = 2
     */
    public function index()
    {
        $userId = 2; // fixed user
        $cartItems = Cart::with('product')
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'status' => 200,
            'message' => 'Cart items retrieved successfully',
            'rows' => $cartItems
        ]);
    }

    /**
     * Add a product to the cart.
     */
    public function add(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'required|integer|min:1',
        ]);

        $userId = 2; // fixed user

        $cartItem = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity', $request->quantity);
        } else {
            $cartItem = Cart::create([
                'user_id'    => $userId,
                'product_id' => $request->product_id,
                'quantity'   => $request->quantity,
            ]);
        }

        return response()->json([
            'status'  => 201,
            'message' => 'Product added to cart successfully',
            'rows'    => $cartItem->load('product')
        ], 201);
    }

    /**
     * Increment item quantity.
     */
    public function increment($id)
    {
        $userId = 2;
        $cartItem = Cart::where('user_id', $userId)->findOrFail($id);
        $cartItem->increment('quantity');

        return response()->json([
            'status'  => 200,
            'message' => 'Product quantity incremented successfully',
            'rows'    => $cartItem->load('product')
        ]);
    }

    /**
     * Decrement item quantity (delete if quantity reaches 0)
     */
    public function decrement($id)
    {
        $userId = 2;
        $cartItem = Cart::where('user_id', $userId)->findOrFail($id);

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
        } else {
            $cartItem->delete();
            return response()->json([
                'status'  => 200,
                'message' => 'Item removed from cart'
            ]);
        }

        return response()->json([
            'status'  => 200,
            'message' => 'Product quantity decremented successfully',
            'rows'    => $cartItem->load('product')
        ]);
    }

    /**
     * Remove one item from the cart
     */
    public function remove($id)
    {
        $userId = 2;
        $cartItem = Cart::where('user_id', $userId)->findOrFail($id);
        $cartItem->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Item removed from cart'
        ]);
    }

    /**
     * Clear all items in the cart
     */
    public function clear()
    {
        $userId = 2;
        Cart::where('user_id', $userId)->delete();

        return response()->json([
            'status'  => 200,
            'message' => 'Cart cleared successfully'
        ]);
    }
}
