<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Razorpay\Api\Api;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\InvoiceItems;   // your existing model name
use App\Models\Product;
use App\Models\OrderTaxDetail;

class OrderController extends Controller
{
    // ═══════════════════════════════════════════════════════════════
    //  BUY NOW — single product (existing, unchanged)
    // ═══════════════════════════════════════════════════════════════

    public function createRazorpayOrder(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'quantity'   => 'integer|min:1|max:100',
        ]);

        $product        = Product::findOrFail($request->product_id);
        $variant        = $request->variant_id ? $product->variants->find($request->variant_id) : null;
        $quantity       = $request->quantity ?? 1;
        $price          = $variant ? $variant->base_price     : $product->base_price;
        $discountPrice  = $variant ? $variant->discount_price : $product->discount_price;
        $effectivePrice = $discountPrice ?? $price;
        $totalAmount    = $effectivePrice * $quantity;

        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

        $razorpayOrder = $api->order->create([
            'amount'          => (int) ($totalAmount * 100),
            'currency'        => 'INR',
            'receipt'         => 'rcpt_' . Str::random(10),
            'payment_capture' => 1,
        ]);

        return response()->json([
            'success'           => true,
            'razorpay_order_id' => $razorpayOrder->id,
            'amount'            => (int) ($totalAmount * 100),
            'currency'          => 'INR',
            'key'               => config('services.razorpay.key'),
            'product_id'        => $product->id,
            'variant_id'        => $request->variant_id,
            'quantity'          => $quantity,
            'product_name'      => $product->base_name,
        ]);
    }

    public function verifyAndStore(Request $request)
    {
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
            'product_id'          => 'required|exists:products,id',
            'variant_id'          => 'nullable|exists:variants,id',
            'quantity'            => 'integer|min:1',
        ]);

        // Verify signature
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed.'], 422);
        }

        $userId   = Auth::guard('frontend')->id() ?? 2;
        $product  = Product::findOrFail($request->product_id);
        $variant  = $request->variant_id ? $product->variants->find($request->variant_id) : null;
        $quantity = $request->quantity ?? 1;

        $price          = $variant ? $variant->base_price     : $product->base_price;
        $discountPrice  = $variant ? $variant->discount_price : $product->discount_price;
        $cgst           = $variant ? $variant->cgst           : $product->cgst;
        $sgst           = $variant ? $variant->sgst           : $product->sgst;
        $weight         = $variant ? $variant->weight         : $product->weight;
        $effectivePrice = $discountPrice ?? $price;
        $totalPrice     = $effectivePrice * $quantity;

        DB::transaction(function () use (
            $userId, $product, $variant, $quantity,
            $price, $discountPrice, $cgst, $sgst, $weight,
            $effectivePrice, $totalPrice, $request
        ) {
            // Unique order code
            do { $orderCode = 'ORD-' . strtoupper(Str::random(8)); }
            while (Order::where('order_code', $orderCode)->exists());

            $order = Order::create([
                'order_code'   => $orderCode,
                'user_id'      => $userId,
                'total_amount' => $totalPrice,
                'status'       => 'paid',
            ]);

            OrderItem::create([
                'order_id'       => $order->id,
                'product_id'     => $product->id,
                'variant_id'     => $variant?->id,
                'quantity'       => $quantity,
                'price'          => $price,
                'discount_price' => $discountPrice,
                'cgst'           => $cgst,
                'sgst'           => $sgst,
                'weight'         => $weight,
                'total_price'    => $totalPrice,
            ]);

            // Unique invoice number
            do { $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)); }
            while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id'        => $userId,
                'order_id'       => $order->id,
                'total_amount'   => $totalPrice,
            ]);

            InvoiceItems::create([
                'invoice_id'  => $invoice->id,
                'product_id'  => $product->id,
                'variant_id'  => $variant?->id,
                'quantity'    => $quantity,
                'price'       => $effectivePrice,
                'total_price' => $totalPrice,
                'cgst'        => $cgst,
                'sgst'        => $sgst,
            ]);

            // Tax detail
            $deliveryState = $request->delivery_state ?? null;
            $isIntrastate  = strtolower($deliveryState ?? '') === 'west bengal';
            $amount        = $effectivePrice * $quantity;
            $deliveryCost  = 0;
            $cgstRate      = $isIntrastate ? ($product->cgst ?? 1.5) : 0;
            $sgstRate      = $isIntrastate ? ($product->sgst ?? 1.5) : 0;
            $igstRate      = !$isIntrastate ? ($product->igst ?? 3.0) : 0;

            OrderTaxDetail::create([
                'order_id'       => $order->id,
                'invoice_id'     => $invoice->id,
                'product_id'     => $product->id,
                'sale_date'      => now()->toDateString(),
                'quantity'       => $quantity,
                'unit_price'     => $effectivePrice,
                'amount'         => $amount,
                'delivery_state' => $deliveryState,
                'delivery_cost'  => $deliveryCost,
                'cgst_rate'      => $cgstRate,
                'sgst_rate'      => $sgstRate,
                'igst_rate'      => $igstRate,
                'cgst_amount'    => round($amount * ($cgstRate / 100), 2),
                'sgst_amount'    => round($amount * ($sgstRate / 100), 2),
                'igst_amount'    => round($amount * ($igstRate / 100), 2),
                'gross_amount'   => $amount + $deliveryCost,
            ]);

            session(['last_order_id' => $order->id]);
        });

        return response()->json(['success' => true, 'message' => 'Order placed successfully!']);
    }

    // ═══════════════════════════════════════════════════════════════
    //  CHECKOUT (cart) — Step 1: create Razorpay order from cart
    // ═══════════════════════════════════════════════════════════════

    public function createCartRazorpayOrder(Request $request)
    {
        if (!auth('frontend')->check()) {
            return response()->json(['redirect' => route('frontend.login')]);
        }

        $userId = auth('frontend')->id();
        $cart   = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        $items = CartItem::where('cart_id', $cart->id)->with('product')->get();

        if ($items->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Your cart is empty.']);
        }

        $subtotal    = $items->sum('total_price');
        $shipping    = $subtotal < 999 ? 99 : 0;
        $total       = $subtotal + $shipping;
        $amountPaise = (int) round($total * 100);

        try {
            $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));

            $razorpayOrder = $api->order->create([
                'receipt'         => 'cart_' . Str::random(8),
                'amount'          => $amountPaise,
                'currency'        => 'INR',
                'payment_capture' => 1,
            ]);

            return response()->json([
                'success'           => true,
                'key'               => config('services.razorpay.key'),
                'amount'            => $amountPaise,
                'currency'          => 'INR',
                'razorpay_order_id' => $razorpayOrder->id,
                'product_name'      => $items->count() . ' item(s) from Etthnicoast',
            ]);

        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // ═══════════════════════════════════════════════════════════════
    //  CHECKOUT (cart) — Step 2: verify + create order + clear cart
    // ═══════════════════════════════════════════════════════════════

    public function verifyCartAndStore(Request $request)
    {
        if (!auth('frontend')->check()) {
            return response()->json(['redirect' => route('frontend.login')]);
        }

        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        // Verify signature
        $api = new Api(config('services.razorpay.key'), config('services.razorpay.secret'));
        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed.'], 422);
        }

        $userId    = auth('frontend')->id();
        $cart      = Cart::where('user_id', $userId)->first();
        $cartItems = $cart ? CartItem::where('cart_id', $cart->id)->with('product')->get() : collect();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Cart is empty.']);
        }

        DB::transaction(function () use ($userId, $cart, $cartItems, $request) {

            $subtotal = $cartItems->sum('total_price');
            $shipping = $subtotal < 999 ? 99 : 0;
            $total    = $subtotal + $shipping;

            // Unique order code
            do { $orderCode = 'ORD-' . strtoupper(Str::random(8)); }
            while (Order::where('order_code', $orderCode)->exists());

            // ── Order ─────────────────────────────────────────────────────
            $order = Order::create([
                'order_code'   => $orderCode,
                'user_id'      => $userId,
                'total_amount' => $total,
                'status'       => 'confirmed',
            ]);

            // ── Order items ───────────────────────────────────────────────
            foreach ($cartItems as $item) {
                OrderItem::create([
                    'order_id'       => $order->id,
                    'product_id'     => $item->product_id,
                    'variant_id'     => $item->variant_id,
                    'quantity'       => $item->quantity,
                    'price'          => $item->price,
                    'discount_price' => $item->discount_price,
                    'cgst'           => $item->cgst,
                    'sgst'           => $item->sgst,
                    'weight'         => $item->weight,
                    'total_price'    => $item->total_price,
                ]);
            }

            // Unique invoice number
            do { $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)); }
            while (Invoice::where('invoice_number', $invoiceNumber)->exists());

            // ── Invoice ───────────────────────────────────────────────────
            $invoice = Invoice::create([
                'invoice_number' => $invoiceNumber,
                'user_id'        => $userId,
                'order_id'       => $order->id,
                'total_amount'   => $total,
            ]);

            // ── Invoice items ─────────────────────────────────────────────
            foreach ($cartItems as $item) {
                InvoiceItems::create([
                    'invoice_id'  => $invoice->id,
                    'product_id'  => $item->product_id,
                    'variant_id'  => $item->variant_id,
                    'quantity'    => $item->quantity,
                    'price'       => $item->price,
                    'total_price' => $item->total_price,
                    'cgst'        => $item->cgst,
                    'sgst'        => $item->sgst,
                ]);
            }

            // ── Clear cart ────────────────────────────────────────────────
            CartItem::where('cart_id', $cart->id)->delete();

            session(['last_order_id' => $order->id]);
        });

        return response()->json([
            'success'  => true,
            'message'  => 'Order placed successfully!',
            'redirect' => route('order.success'),
        ]);
    }

    // ═══════════════════════════════════════════════════════════════
    //  Order success page
    // ═══════════════════════════════════════════════════════════════

    public function success()
    {
        $orderId = session('last_order_id');

        if (!$orderId) {
            return redirect()->route('frontend.index');
        }

        $order = Order::with(['items.product.images', 'invoice'])
            ->where('user_id', auth('frontend')->id())
            ->findOrFail($orderId);

        return view('frontend.order-success', compact('order'));
    }
}