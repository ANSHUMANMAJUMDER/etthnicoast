<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TabCategories;
use App\Models\TabSubCategories;
use App\Models\Product;

class CollectionController extends Controller
{
    public function index(Request $request, string $slug = null)
    {
        // ── 1. Resolve slug → category or sub-category ──────────────────────

        $category    = null;
        $subCategory = null;

        if ($slug) {
            // Try sub-category first (more specific)
            $subCategory = TabSubCategories::with('category')
                ->where('slug', $slug)
                ->where('is_active', true)
                ->first();

            if ($subCategory) {
                $category = $subCategory->category;
            } else {
                // Fall back to main category — first() not firstOrFail()
                $category = TabCategories::where('slug', $slug)
                    ->where('is_active', true)
                    ->first();
                // null here = slug given but not found → show all products
            }
        }
        // null slug = /collection with no param → show all products

        // ── 2. Breadcrumb labels ─────────────────────────────────────────────

        if ($subCategory) {
            $breadcrumb = [
                ['label' => 'Collections',      'url' => route('collection.show')],
                ['label' => $category->name,    'url' => route('collection.show', $category->slug)],
                ['label' => $subCategory->name, 'url' => null],
            ];
        } elseif ($category) {
            $breadcrumb = [
                ['label' => 'Collections',   'url' => route('collection.show')],
                ['label' => $category->name, 'url' => null],
            ];
        } else {
            $breadcrumb = [
                ['label' => 'Collections', 'url' => null],
            ];
        }

        // ── 3. Fetch products ────────────────────────────────────────────────

        $sortMap = [
            'price_asc'  => ['base_price', 'asc'],
            'price_desc' => ['base_price', 'desc'],
            'newest'     => ['created_at', 'desc'],
            'featured'   => ['display_order', 'asc'],
        ];

        $sort        = $request->get('sort', 'featured');
        [$col, $dir] = $sortMap[$sort] ?? ['display_order', 'asc'];

        $minPrice  = $request->get('min_price');
        $maxPrice  = $request->get('max_price');
        $pearlType = $request->get('pearl_type');

        if ($category) {
            // Scoped to this category's assigned products
            $targetCategory = $subCategory ? $subCategory->category : $category;

            $productsQuery = $targetCategory->products()
                ->with('images:id,product_id,image')
                ->where('products.is_active', 1)
                ->when($pearlType, fn($q) => $q->where('pearl_type_id', $pearlType));

            $priceMin = $targetCategory->products()->where('is_active', 1)->min('base_price') ?? 0;
            $priceMax = $targetCategory->products()->where('is_active', 1)->max('base_price') ?? 10000;
        } else {
            // No category resolved → all active products
            $productsQuery = Product::with('images:id,product_id,image')
                ->where('is_active', 1)
                ->when($pearlType, fn($q) => $q->where('pearl_type_id', $pearlType));

            $priceMin = Product::where('is_active', 1)->min('base_price') ?? 0;
            $priceMax = Product::where('is_active', 1)->max('base_price') ?? 10000;
        }

        $products = $productsQuery
            ->when($minPrice, fn($q) => $q->where('base_price', '>=', $minPrice))
            ->when($maxPrice, fn($q) => $q->where('base_price', '<=', $maxPrice))
            ->orderBy($col, $dir)
            ->paginate(12)
            ->withQueryString();

        // ── 4. Sub-categories for filter chips ───────────────────────────────

        $subCategories = $category
            ? $category->subCategories()->where('is_active', true)->get()
            : collect();

        // ── 5. All categories for sidebar ────────────────────────────────────

        $allCategories = TabCategories::where('is_active', true)
            ->withCount(['products' => fn($q) => $q->where('is_active', 1)])
            ->orderBy('display_order')
            ->get();

        // ── 6. Hero title & subtitle ─────────────────────────────────────────

        if ($subCategory) {
            $heroTitle    = $subCategory->name;
            $heroSubtitle = 'Part of ' . $category->name;
        } elseif ($category) {
            $heroTitle    = $category->name;
            $heroSubtitle = 'Handcrafted with love';
        } else {
            $heroTitle    = 'All Collections';
            $heroSubtitle = 'Browse our complete range';
        }

        return view('frontend.collection', compact(
            'category',
            'subCategory',
            'products',
            'breadcrumb',
            'subCategories',
            'allCategories',
            'sort',
            'minPrice',
            'maxPrice',
            'priceMin',
            'priceMax',
            'heroTitle',
            'heroSubtitle',
            'slug'
        ));
    }
}