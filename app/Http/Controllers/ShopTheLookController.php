<?php

namespace App\Http\Controllers;

use App\Models\ShopTheLook;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ShopTheLookHotspot;
use App\Models\ShopTheLookHotspots;
use Illuminate\Support\Facades\Storage;

class ShopTheLookController extends Controller
{
   // ─── Main Listing ────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        $q = $request->q;

        $shopTheLooks = ShopTheLook::withCount('hotspots')
            ->when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('shop-the-looks.index', compact('shopTheLooks', 'q'));
    }

    // ─── Store ShopTheLook ────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $shopTheLook            = new ShopTheLook();
        $shopTheLook->title     = $request->title;
        $shopTheLook->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $shopTheLook->image = $request->file('image')->store('shop-the-looks', 'public');
        }

        $shopTheLook->save();

        return redirect()->route('shop-the-looks.index')->with('success', 'Shop The Look created successfully.');
    }

    // ─── Update ShopTheLook ───────────────────────────────────────────────────────

    public function update(Request $request, ShopTheLook $shopTheLook)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $shopTheLook->title     = $request->title;
        $shopTheLook->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($shopTheLook->image && Storage::disk('public')->exists($shopTheLook->image)) {
                Storage::disk('public')->delete($shopTheLook->image);
            }
            $shopTheLook->image = $request->file('image')->store('shop-the-looks', 'public');
        }

        $shopTheLook->save();

        return redirect()->route('shop-the-looks.index')->with('success', 'Shop The Look updated successfully.');
    }

    // ─── Toggle Status ────────────────────────────────────────────────────────────

    public function toggleStatus(ShopTheLook $shopTheLook)
    {
        $shopTheLook->is_active = !$shopTheLook->is_active;
        $shopTheLook->save();

        return redirect()->route('shop-the-looks.index')->with('success', 'Status updated.');
    }

    // ─── Delete ShopTheLook ───────────────────────────────────────────────────────

    public function destroy(ShopTheLook $shopTheLook)
    {
        if ($shopTheLook->image && Storage::disk('public')->exists($shopTheLook->image)) {
            Storage::disk('public')->delete($shopTheLook->image);
        }

        $shopTheLook->hotspots()->delete();
        $shopTheLook->delete();

        return redirect()->route('shop-the-looks.index')->with('success', 'Shop The Look deleted successfully.');
    }

    // ─── Hotspot Management Page ──────────────────────────────────────────────────

    public function hotspots(ShopTheLook $shopTheLook)
    {
        $hotspots = $shopTheLook->hotspots()->with('product')->get();
        $products = Product::orderBy('base_name')->get();

        return view('shop-the-looks.hotspots', compact('shopTheLook', 'hotspots', 'products'));
    }

    // ─── Store Hotspot ────────────────────────────────────────────────────────────

    public function storeHotspot(Request $request, ShopTheLook $shopTheLook)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'x_coordinate' => 'required|numeric|min:0|max:100',
            'y_coordinate' => 'required|numeric|min:0|max:100',
        ]);

        $hotspot                    = new ShopTheLookHotspots();
        $hotspot->shop_the_look_id  = $shopTheLook->id;
        $hotspot->product_id        = $request->product_id;
        $hotspot->x_coordinate      = $request->x_coordinate;
        $hotspot->y_coordinate      = $request->y_coordinate;
        $hotspot->is_active         = $request->has('is_active') ? 1 : 0;
        $hotspot->save();

        return redirect()->route('shop-the-looks.hotspots', $shopTheLook->id)
            ->with('success', 'Hotspot added successfully.');
    }

    // ─── Update Hotspot ───────────────────────────────────────────────────────────

    public function updateHotspot(Request $request, ShopTheLook $shopTheLook, ShopTheLookHotspots $hotspot)
    {
        $request->validate([
            'product_id'   => 'required|exists:products,id',
            'x_coordinate' => 'required|numeric|min:0|max:100',
            'y_coordinate' => 'required|numeric|min:0|max:100',
        ]);

        $hotspot->product_id   = $request->product_id;
        $hotspot->x_coordinate = $request->x_coordinate;
        $hotspot->y_coordinate = $request->y_coordinate;
        $hotspot->is_active    = $request->has('is_active') ? 1 : 0;
        $hotspot->save();

        return redirect()->route('shop-the-looks.hotspots', $shopTheLook->id)
            ->with('success', 'Hotspot updated successfully.');
    }

    // ─── Toggle Hotspot Status ────────────────────────────────────────────────────

    public function toggleHotspotStatus(ShopTheLook $shopTheLook, ShopTheLookHotspots $hotspot)
    {
        $hotspot->is_active = !$hotspot->is_active;
        $hotspot->save();

        return redirect()->route('shop-the-looks.hotspots', $shopTheLook->id)
            ->with('success', 'Hotspot status updated.');
    }

    // ─── Delete Hotspot ───────────────────────────────────────────────────────────

    public function destroyHotspot(ShopTheLook $shopTheLook, ShopTheLookHotspots $hotspot)
    {
        $hotspot->delete();

        return redirect()->route('shop-the-looks.hotspots', $shopTheLook->id)
            ->with('success', 'Hotspot deleted successfully.');
    }
}
