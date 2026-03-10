<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
     public function store(Request $request)
    {
        if (!Auth::guard('frontend')->check()) {
            return response()->json([
                'success'  => false,
                'redirect' => route('frontend.login'),
                'message'  => 'Please login to continue.',
            ], 401);
        }
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'quantity'   => 'integer|min:1|max:100',
        ]);

         $userId    = Auth::guard('frontend')->id();
        $productId = $request->product_id;
        $variantId = $request->variant_id;
        $quantity  = $request->quantity ?? 1;
        $totalPrice =0;

        $product = Product::findOrFail($productId);
        $variant = $variantId ? $product->variants->find($variantId) : null;

        // Determine pricing
        $price         = $variant ? $variant->base_price         : $product->base_price;
        $discountPrice = $variant ? $variant->discount_price : $product->discount_price;
        $cgst          = $variant ? $variant->cgst           : $product->cgst;
        $sgst          = $variant ? $variant->sgst           : $product->sgst;
        $weight        = $variant ? $variant->weight         : $product->weight;

        $effectivePrice = $discountPrice ?? $price;
        $totalPrice     = $effectivePrice * $quantity;

        DB::transaction(function () use (
            $userId, $productId, $variantId, $quantity,
            $price, $discountPrice, $cgst, $sgst, $weight,$totalPrice
        ) {
            // Get or create cart for user
            $cart = Cart::firstOrCreate(
                ['user_id' => $userId, 'product_id' => $productId, 'variant_id' => $variantId],
                ['quantity' => 0]
            );

            // Update cart quantity
            $cart->increment('quantity', $quantity);

            // Check if cart item exists
            $cartItem = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->first();

            if ($cartItem) {
                // Update existing item
                $cartItem->quantity   += $quantity;
                $cartItem->total_price = ($cartItem->discount_price ?? $cartItem->price) * $cartItem->quantity;
                $cartItem->save();
            } else {
                // Create new cart item
                CartItem::create([
                    'cart_id'        => $cart->id,
                    'product_id'     => $productId,
                    'variant_id'     => $variantId,
                    'quantity'       => $quantity,
                    'price'          => $price,
                    'discount_price' => $discountPrice,
                    'cgst'           => $cgst,
                    'sgst'           => $sgst,
                    'weight'         => $weight,
                    'total_price'    => $totalPrice,
                ]);
            }
        });

        return response()->json([
            'success'    => true,
            'message'    => 'Added to cart.',
            'cart_count' => $this->getCartCount($userId),
        ]);
    }


        public function destroy(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
        ]);

         $userId    = Auth::guard('frontend')->id();
        $productId = $request->product_id;
        $variantId = $request->variant_id;

        DB::transaction(function () use ($userId, $productId, $variantId) {
            $cart = Cart::where('user_id', $userId)
                ->where('product_id', $productId)
                ->where('variant_id', $variantId)
                ->first();

            if ($cart) {
                // cascadeOnDelete removes cart_items automatically
                $cart->items->delete();
                $cart->delete();
            }
        });

        return response()->json([
            'success'    => true,
            'message'    => 'Removed from cart.',
            'cart_count' => $this->getCartCount($userId),
        ]);
    }

    // ── Cart Count helper ────────────────────────────────────
    private function getCartCount($userId)
    {
        return Cart::where('user_id', $userId)->sum('quantity');
    }
}
