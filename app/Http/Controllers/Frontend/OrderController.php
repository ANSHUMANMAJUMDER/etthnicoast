<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Razorpay\Api\Api;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Invoice;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\OrderTaxDetail;
class OrderController extends Controller
{
   // ── Step 1: Create Razorpay Order ─────────────────────────
    public function createRazorpayOrder(Request $request)
    {
      
        // if (!Auth::guard('frontend')->check()) {
        //     return response()->json([
        //         'success'  => false,
        //         'redirect' => route('frontend.login'),
        //     ], 401);
        // }

        $request->validate([
            'product_id' => 'required|exists:products,id',
            'variant_id' => 'nullable|exists:variants,id',
            'quantity'   => 'integer|min:1|max:100',
        ]);

        $product   = Product::findOrFail($request->product_id);
        
        $variant   = $request->variant_id ? $product->variants->find($request->variant_id) : null;
        $quantity  = $request->quantity ?? 1;

        $price         = $variant ? $variant->base_price         : $product->base_price;
        $discountPrice = $variant ? $variant->discount_price : $product->discount_price;
        $effectivePrice = $discountPrice ?? $price;
        $totalAmount    = $effectivePrice * $quantity;

        // dd([
        //     'product_id'    => $product->id,
        //     'variant_id'    => $variant?->id,
        //     'quantity'      => $quantity,
        //     'price'         => $price,
        //     'discount_price'=> $discountPrice,
        //     'effective_price'=> $effectivePrice,
        //     'total_amount'  => $totalAmount,
        //  ]);

        // Razorpay order
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        $razorpayOrder = $api->order->create([
            'amount'          => (int)($totalAmount * 100), // paise
            'currency'        => 'INR',
            'receipt'         => 'rcpt_' . Str::random(10),
            'payment_capture' => 1,
        ]);

        return response()->json([
            'success'          => true,
            'razorpay_order_id'=> $razorpayOrder->id,
            'amount'           => (int)($totalAmount * 100),
            'currency'         => 'INR',
            'key'              => config('services.razorpay.key'),
            'product_id'       => $product->id,
            'variant_id'       => $request->variant_id,
            'quantity'         => $quantity,
            'product_name'     => $product->base_name,
        ]);
    }

    // ── Step 2: Verify Payment & Store Order ──────────────────
    public function verifyAndStore(Request $request)
    {
        // if (!Auth::guard('frontend')->check()) {
        //     return response()->json(['success' => false, 'redirect' => route('frontend.login')], 401);
        // }
      
        $request->validate([
            'razorpay_order_id'   => 'required|string',
            'razorpay_payment_id' => 'required|string',
            'razorpay_signature'  => 'required|string',
            'product_id'          => 'required|exists:products,id',
            'variant_id'          => 'nullable|exists:variants,id',
            'quantity'            => 'integer|min:1',
        ]);

        // Verify signature
        $api = new \Razorpay\Api\Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );

        try {
            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Payment verification failed.'], 422);
        }

        $userId   = Auth::guard('frontend')->id()??2; // Fallback to user ID 2 for testing
        $product  = Product::findOrFail($request->product_id);
        $variant  = $request->variant_id ? $product->variants->find($request->variant_id) : null;
        $quantity = $request->quantity ?? 1;

        $price         = $variant ? $variant->base_price         : $product->base_price;
        $discountPrice = $variant ? $variant->discount_price : $product->discount_price;
        $cgst          = $variant ? $variant->cgst           : $product->cgst;
        $sgst          = $variant ? $variant->sgst           : $product->sgst;
        $weight        = $variant ? $variant->weight         : $product->weight;
        $effectivePrice = $discountPrice ?? $price;
        $totalPrice     = $effectivePrice * $quantity;

        DB::transaction(function () use (
            $userId, $product, $variant, $quantity,
            $price, $discountPrice, $cgst, $sgst, $weight,
            $effectivePrice, $totalPrice, $request
        ) {
            // ── Create Order ──────────────────────────────────
            $order = Order::create([
                'order_code'   => 'ORD-' . strtoupper(Str::random(8)),
                'user_id'      => $userId,
                'total_amount' => $totalPrice,
                'status'       => 'paid',
            ]);

            // ── Create Order Item ─────────────────────────────
            OrderItem::create([
                'order_id'      => $order->id,
                'product_id'    => $product->id,
                'variant_id'    => $variant?->id,
                'quantity'      => $quantity,
                'price'         => $price,
                'discount_price'=> $discountPrice,
                'cgst'          => $cgst,
                'sgst'          => $sgst,
                'weight'        => $weight,
                'total_price'   => $totalPrice,
            ]);

            // ── Create Invoice ────────────────────────────────
            $invoice = Invoice::create([
                'invoice_number' => 'INV-' . date('Ymd') . '-' . strtoupper(Str::random(5)),
                'user_id'        => $userId,
                'order_id'       => $order->id,
                'total_amount'   => $totalPrice,
            ]);

            // ── Create Invoice Item ───────────────────────────
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



            // new 
            $deliveryState = $request->delivery_state ?? null;
$isIntrastate  = strtolower($deliveryState ?? '') === 'west bengal';

$price       = $variant?->discount_price ?? $variant?->price 
             ?? $product->discount_price  ?? $product->base_price;
$amount      = $price * $quantity;
$deliveryCost = 0; // your shipping logic

// Pull rates from product
$cgstRate = $isIntrastate ? ($product->cgst ?? 1.5) : 0;
$sgstRate = $isIntrastate ? ($product->sgst ?? 1.5) : 0;
$igstRate = !$isIntrastate ? ($product->igst ?? 3.0) : 0;

// Calculate amounts
$cgstAmount = round($amount * ($cgstRate / 100), 2);
$sgstAmount = round($amount * ($sgstRate / 100), 2);
$igstAmount = round($amount * ($igstRate / 100), 2);
$grossAmount = $amount + $deliveryCost;

// ── Store in dedicated tax table ──────────────────────
OrderTaxDetail::create([
    'order_id'      => $order->id,
    'invoice_id'    => $invoice->id,
    'product_id'    => $product->id,
    'sale_date'     => now()->toDateString(),
    'quantity'      => $quantity,
    'unit_price'    => $price,
    'amount'        => $amount,
    'delivery_state'=> $deliveryState,
    'delivery_cost' => $deliveryCost,
    'cgst_rate'     => $cgstRate,
    'sgst_rate'     => $sgstRate,
    'igst_rate'     => $igstRate,
    'cgst_amount'   => $cgstAmount,
    'sgst_amount'   => $sgstAmount,
    'igst_amount'   => $igstAmount,
    'gross_amount'  => $grossAmount,
]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Order placed successfully!',
        ]);
    }

    // ── Monthly Sales Report ───────────────────────────────────
    // public function monthlyReport(Request $request)
    // {
    //     $from = $request->from ? \Carbon\Carbon::parse($request->from)->startOfDay() : now()->startOfMonth();
    //     $to   = $request->to   ? \Carbon\Carbon::parse($request->to)->endOfDay()     : now()->endOfMonth();

    //     $orders = Order::with(['items.product', 'invoice', 'user'])
    //         ->where('status', 'paid')
    //         ->whereBetween('created_at', [$from, $to])
    //         ->orderBy('created_at')
    //         ->get();

    //     return view('admin.reports.monthly-sales', compact('orders', 'from', 'to'));
    // }
}
