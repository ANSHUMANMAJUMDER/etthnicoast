<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HomePageBannerSetup;
use App\Models\Product;
use Illuminate\Http\Request;

class BannerCollectionController extends Controller
{
  /**
     * Display a banner-driven collection page.
     *
     * Route: GET /collections/{type}
     * Example: /collections/seasonal_banner
     *          /collections/for_him
     *          /collections/for_her
     *          /collections/new_arrivals
     *          /collections/perfect_gifts
     *          /collections/generic_banner
     *          /collections/exclusive_collection
     */
    public function show(Request $request, string $type)
    {
        // Load the active banner for this type
        $banner = HomePageBannerSetup::where('type', $type)
            ->where('is_active', 1)
            ->firstOrFail();
 
        // ── Build product query ──────────────────────────────────────────
        $query = Product::query()->where('is_active', 1);
 
        // Scope products to banner type (adjust logic to match your schema)
        $this->applyBannerScope($query, $type);
 
        // ── Filters ─────────────────────────────────────────────────────
        if ($request->filled('category')) {
            $query->whereHas('category', fn ($q) =>
                $q->where('slug', $request->category)
            );
        }
 
        if ($request->filled('min_price')) {
            $query->where(fn ($q) =>
                $q->where('sale_price', '>=', $request->min_price)
                  ->orWhere(fn ($q2) =>
                      $q2->whereNull('sale_price')
                         ->where('price', '>=', $request->min_price)
                  )
            );
        }
 
        if ($request->filled('max_price')) {
            $query->where(fn ($q) =>
                $q->where('sale_price', '<=', $request->max_price)
                  ->orWhere(fn ($q2) =>
                      $q2->whereNull('sale_price')
                         ->where('price', '<=', $request->max_price)
                  )
            );
        }
 
        if ($request->availability === 'in_stock') {
            $query->where('stock_quantity', '>', 0);
        }
 
        // ── Sorting ──────────────────────────────────────────────────────
        match ($request->get('sort', 'featured')) {
            'newest'       => $query->latest(),
            'price_asc'    => $query->orderByRaw('COALESCE(sale_price, price) ASC'),
            'price_desc'   => $query->orderByRaw('COALESCE(sale_price, price) DESC'),
            'best_selling' => $query->orderByDesc('sales_count'),
            default        => $query->latest(),
        };
 
        // ── Eager load & paginate ─────────────────────────────────────────
        $products = $query
            ->with(['category'])
            ->paginate(20)
            ->withQueryString();
 
        // ── Optional: category sidebar list ──────────────────────────────
        // $categories = \App\Models\Category::orderBy('name')->get();
 
        return view('frontend.collections.banner', compact('banner', 'products'));
    }
 
    /**
     * Scope products based on banner type.
     * Adjust tag/category logic to match your database structure.
     */
    private function applyBannerScope($query, string $type): void
    {
        match ($type) {
            'for_him'              => $query->whereHas('category', fn ($q) => $q->where('slug', 'for-him'))
                                            ->orWhereHas('tags', fn ($q) => $q->where('name', 'for-him')),
            'for_her'              => $query->whereHas('category', fn ($q) => $q->where('slug', 'for-her'))
                                            ->orWhereHas('tags', fn ($q) => $q->where('name', 'for-her')),
            'new_arrivals'         => $query->where('is_new', 1)->orWhereDate('created_at', '>=', now()->subDays(30)),
            'perfect_gifts'        => $query->whereHas('tags', fn ($q) => $q->where('name', 'gift')),
            'exclusive_collection' => $query->where('is_featured', 1),
            // 'seasonal_banner'      => $query->whereHas('tags', fn ($q) => $q->where('name', 'seasonal')),
            default                => $query, // generic_banner → all active products
        };
    }
}

