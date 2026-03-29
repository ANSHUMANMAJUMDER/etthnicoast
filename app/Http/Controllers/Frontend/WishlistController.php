<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wishlist;
use App\Models\Product;

class WishlistController extends Controller
{
    // ── Toggle (add / remove) — called via fetch from product page ────────
    public function toggle(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $user = auth('frontend')->user();

        $existing = Wishlist::where('user_id', $user->id)
            ->where('product_id', $request->product_id)
            ->first();

        if ($existing) {
            $existing->delete();
            $wishlisted = false;
        } else {
            Wishlist::create([
                'user_id'    => $user->id,
                'product_id' => $request->product_id,
            ]);
            $wishlisted = true;
        }

        return response()->json([
            'success'    => true,
            'wishlisted' => $wishlisted,
            'count'      => Wishlist::where('user_id', $user->id)->count(),
        ]);
    }

    // ── Wishlist page ─────────────────────────────────────────────────────
    public function index()
    {
        $items = Wishlist::where('user_id', auth('frontend')->id())
            ->with(['product' => fn($q) => $q->with('images')])
            ->latest()
            ->get();

        return view('frontend.wishlist', compact('items'));
    }

    // ── Remove single item ────────────────────────────────────────────────
    public function remove(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        Wishlist::where('user_id', auth('frontend')->id())
            ->where('product_id', $request->product_id)
            ->delete();

        return response()->json([
            'success' => true,
            'count'   => Wishlist::where('user_id', auth('frontend')->id())->count(),
        ]);
    }

    // ── Move to cart ──────────────────────────────────────────────────────
    public function moveToCart(Request $request)
    {
        $request->validate(['product_id' => 'required|exists:products,id']);

        $userId    = auth('frontend')->id();
        $productId = $request->product_id;

        // Add to cart
        $cart = \App\Models\Cart::firstOrCreate(['user_id' => $userId]);

        $cartItem = \App\Models\CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->first();

        if (!$cartItem) {
            $product = \App\Models\Product::findOrFail($productId);
            \App\Models\CartItem::create([
                'cart_id'     => $cart->id,
                'product_id'  => $productId,
                'quantity'    => 1,
                'price'       => $product->base_price,
                'total_price' => $product->base_price,
            ]);
        }

        // Remove from wishlist
        Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->delete();

        $wishCount = Wishlist::where('user_id', $userId)->count();
        $cartCount = \App\Models\CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'success'    => true,
            'count'      => $wishCount,
            'cart_count' => $cartCount,
        ]);
    }
}