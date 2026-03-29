<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
  public function ajax(Request $request)
    {
        $query = $request->get('q', '');

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $products = Product::where(function($q) use ($query) {
                $q->where('base_name', 'LIKE', "%{$query}%")
                  ->orWhere('description', 'LIKE', "%{$query}%");
            })
            ->where('is_active', true)   // remove if column doesn't exist
            ->limit(8)
            ->get()
            ->map(fn($product) => [
                'name'  => $product->name,
                'price' => '₹' . number_format($product->price, 2),
                'image' => asset('public/storage/' . $product->image),
                'url'   => route('frontend.product-details', $product->slug), // adjust route
            ]);

        return response()->json($products);
    }
}
