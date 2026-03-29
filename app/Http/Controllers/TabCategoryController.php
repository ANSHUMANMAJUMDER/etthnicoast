<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\TabCategories;
use App\Models\TabSubCategories;
use App\Models\Product;

class TabCategoryController extends Controller
{
    // ─────────────────────────────────────────────
    //  INDEX
    // ─────────────────────────────────────────────
    public function index(Request $request)
    {
        $q = $request->q;

        $tabCategories = TabCategories::withCount(['subCategories', 'products'])
            ->when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('display_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('tab_categories.index', compact('tabCategories', 'q'));
    }

    // ─────────────────────────────────────────────
    //  STORE (Category)
    // ─────────────────────────────────────────────
    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:tab_categories,name',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        TabCategories::create([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->route('tab-categories.index')->with('success', 'Tab category created successfully.');
    }

    // ─────────────────────────────────────────────
    //  UPDATE (Category)
    // ─────────────────────────────────────────────
    public function update(Request $request, TabCategories $tabCategory)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:tab_categories,name,' . $tabCategory->id,
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        $tabCategory->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('tab-categories.index')->with('success', 'Tab category updated successfully.');
    }

    // ─────────────────────────────────────────────
    //  DESTROY (Category)
    // ─────────────────────────────────────────────
    public function destroy(TabCategories $tabCategory)
    {
        $tabCategory->delete(); // sub-categories + pivot cascade via FK
        return redirect()->route('tab-categories.index')->with('success', 'Tab category deleted successfully.');
    }

    // ─────────────────────────────────────────────
    //  TOGGLE STATUS
    // ─────────────────────────────────────────────
    public function toggleStatus(TabCategories $tabCategory)
    {
        $tabCategory->is_active = !$tabCategory->is_active;
        $tabCategory->save();
        return redirect()->back()->with('success', 'Status updated.');
    }

    // ─────────────────────────────────────────────
    //  SUB-CATEGORIES PAGE
    // ─────────────────────────────────────────────
    public function subCategories(TabCategories $tabCategory)
    {
        $subCategories = $tabCategory->subCategories()->paginate(15);
        return view('tab_categories.sub_categories', compact('tabCategory', 'subCategories'));
    }

    public function storeSubCategory(Request $request, TabCategories $tabCategory)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        TabCategories::create([
            'category_id'   => $tabCategory->id,
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->has('is_active'),
        ]);

        return redirect()->back()->with('success', 'Sub-category added successfully.');
    }

    public function updateSubCategory(Request $request, TabCategories $tabCategory, TabSubCategories $subCategory)
    {
        $request->validate([
            'name'          => 'required|string|max:255',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        $subCategory->update([
            'name'          => $request->name,
            'slug'          => Str::slug($request->name),
            'display_order' => $request->display_order ?? 0,
            'is_active'     => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->back()->with('success', 'Sub-category updated successfully.');
    }

    public function destroySubCategory(TabCategories $tabCategory, TabCategories $subCategory)
    {
        $subCategory->delete();
        return redirect()->back()->with('success', 'Sub-category deleted successfully.');
    }

    public function toggleSubStatus(TabCategories $tabCategory, TabSubCategories $subCategory)
    {
        $subCategory->is_active = !$subCategory->is_active;
        $subCategory->save();
        return redirect()->back()->with('success', 'Status updated.');
    }

    // ─────────────────────────────────────────────
    //  PRODUCTS PAGE
    // ─────────────────────────────────────────────
    public function products(TabCategories $tabCategory)
    {
        $assignedIds = $tabCategory->products()->pluck('products.id')->toArray();

        $allProducts = Product::with('images:id,product_id,image')
            ->select('id', 'product_code', 'base_name', 'base_price')
            ->where('is_active', 1)
            ->orderBy('base_name')
            ->get();

        $assignedProducts = $tabCategory->products()
            ->with('images:id,product_id,image')
            ->select('products.id', 'products.product_code', 'products.base_name', 'products.base_price')
            ->get();

        return view('tab_categories.products', compact('tabCategory', 'allProducts', 'assignedIds', 'assignedProducts'));
    }

    public function syncProducts(Request $request, TabCategories $tabCategory)
    {
        $request->validate([
            'product_ids'   => 'nullable|array',
            'product_ids.*' => 'exists:products,id',
        ]);

        $tabCategory->products()->sync($request->product_ids ?? []);

        return redirect()->back()->with('success', 'Products updated successfully.');
    }

    public function removeProduct(TabCategories $tabCategory, Product $product)
    {
        $tabCategory->products()->detach($product->id);
        return redirect()->back()->with('success', 'Product removed.');
    }
}