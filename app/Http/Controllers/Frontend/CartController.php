<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;

class CartController extends Controller
{
    // ── Cart page ─────────────────────────────────────────────────────────
    public function index()
    {
        if (!auth('frontend')->check()) {
            return redirect()->route('frontend.login');
        }

        $userId = auth('frontend')->id();

        // Find cart by user_id only
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            // No cart yet — show empty state
            return view('frontend.cart', [
                'items'    => collect(),
                'subtotal' => 0,
                'shipping' => 0,
                'total'    => 0,
            ]);
        }

        $items = CartItem::where('cart_id', $cart->id)
            ->with(['product.images', 'variant'])
            ->latest()
            ->get();

        $subtotal = $items->sum('total_price');
        $shipping = $subtotal > 0 && $subtotal < 999 ? 99 : 0;
        $total    = $subtotal + $shipping;

        return view('frontend.cart', compact('items', 'subtotal', 'shipping', 'total'));
    }

    // ── Add to cart ───────────────────────────────────────────────────────
    public function store(Request $request)
    {
        if (!auth('frontend')->check()) {
            return response()->json(['redirect' => route('frontend.login')]);
        }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:product_variants,id',
            'quantity'   => 'nullable|integer|min:1|max:99',
        ]);

        $userId    = auth('frontend')->id();
        $productId = $request->product_id;
        $variantId = $request->variant_id ?? null;
        $qty       = $request->quantity ?? 1;

        $product = Product::findOrFail($productId);
        $price   = $product->base_price;

        // Get or create the user's cart — only match on user_id
        $cart = Cart::firstOrCreate(['user_id' => $userId]);

        // Check if this product+variant already in cart
        $cartItem = CartItem::where('cart_id', $cart->id)
            ->where('product_id', $productId)
            ->where('variant_id', $variantId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity   += $qty;
            $cartItem->total_price = $cartItem->quantity * $price;
            $cartItem->save();
        } else {
            CartItem::create([
                'cart_id'        => $cart->id,
                'product_id'     => $productId,
                'variant_id'     => $variantId,
                'quantity'       => $qty,
                'price'          => $price,
                'discount_price' => $product->compare_price ?? null,
                'total_price'    => $qty * $price,
            ]);
        }

        $cartCount = CartItem::where('cart_id', $cart->id)->sum('quantity');

        return response()->json([
            'success'    => true,
            'cart_count' => $cartCount,
            'message'    => 'Added to cart',
        ]);
    }

    // ── Remove item ───────────────────────────────────────────────────────
    public function destroy(Request $request)
    {
        if (!auth('frontend')->check()) {
            return response()->json(['redirect' => route('frontend.login')]);
        }

        $request->validate(['product_id' => 'required|exists:products,id']);

        $cart = Cart::where('user_id', auth('frontend')->id())->first();

        if ($cart) {
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->when($request->variant_id, fn($q) => $q->where('variant_id', $request->variant_id))
                ->delete();
        }

        $cartCount = 0;
        $cartTotal = 0;
        $shipping  = 0;

        if ($cart) {
            CartItem::where('cart_id', $cart->id)
                ->where('product_id', $request->product_id)
                ->when($request->variant_id, fn($q) => $q->where('variant_id', $request->variant_id))
                ->delete();

            $remaining = CartItem::where('cart_id', $cart->id)->get();
            $cartCount = (int) $remaining->sum('quantity');
            $cartTotal = (float) $remaining->sum('total_price');
            $shipping  = $cartTotal > 0 && $cartTotal < 999 ? 99.0 : 0.0;
        }

        return response()->json([
            'success'     => true,
            'cart_count'  => $cartCount,
            'cart_total'  => round($cartTotal, 2),
            'shipping'    => round($shipping, 2),
            'grand_total' => round($cartTotal + $shipping, 2),
        ]);
    }

    // ── Update quantity ───────────────────────────────────────────────────
    public function updateQuantity(Request $request)
    {
        if (!auth('frontend')->check()) {
            return response()->json(['redirect' => route('frontend.login')]);
        }

        $request->validate([
            'cart_item_id' => 'required|exists:cart_items,id',
            'quantity'     => 'required|integer|min:1|max:99',
        ]);

        $cart = Cart::where('user_id', auth('frontend')->id())->firstOrFail();

        $cartItem = CartItem::where('id', $request->cart_item_id)
            ->where('cart_id', $cart->id)
            ->firstOrFail();

        $cartItem->quantity    = $request->quantity;
        $cartItem->total_price = $cartItem->quantity * $cartItem->price;
        $cartItem->save();

        $allItems  = CartItem::where('cart_id', $cart->id)->get();
        $cartTotal = $allItems->sum('total_price');
        $shipping  = $cartTotal > 0 && $cartTotal < 999 ? 99 : 0;

        return response()->json([
            'success'       => true,
            'item_subtotal' => round((float) $cartItem->total_price, 2),
            'cart_total'    => round((float) $cartTotal, 2),
            'shipping'      => round((float) $shipping, 2),
            'grand_total'   => round((float) ($cartTotal + $shipping), 2),
            'cart_count'    => (int) $allItems->sum('quantity'),
        ]);
    }
}