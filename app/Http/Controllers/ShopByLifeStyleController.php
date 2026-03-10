<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ShopByLifeStyle;
use Illuminate\Support\Facades\Storage;

class ShopByLifeStyleController extends Controller
{
   public function index(Request $request)
    {
        $q = $request->q;

        $lifeStyles = ShopByLifeStyle::when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('shop-by-life-styles.index', compact('lifeStyles', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $lifeStyle            = new ShopByLifeStyle();
        $lifeStyle->name      = $request->name;
        $lifeStyle->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $lifeStyle->image = $request->file('image')->store('shop-by-life-styles', 'public');
        }

        $lifeStyle->save();

        return redirect()->route('shop-by-life-styles.index')->with('success', 'Shop By Life Style added successfully.');
    }

    public function update(Request $request, ShopByLifeStyle $shopByLifeStyle)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $shopByLifeStyle->name      = $request->name;
        $shopByLifeStyle->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($shopByLifeStyle->image && Storage::disk('public')->exists($shopByLifeStyle->image)) {
                Storage::disk('public')->delete($shopByLifeStyle->image);
            }
            $shopByLifeStyle->image = $request->file('image')->store('shop-by-life-styles', 'public');
        }

        $shopByLifeStyle->save();

        return redirect()->route('shop-by-life-styles.index')->with('success', 'Shop By Life Style updated successfully.');
    }

    public function toggleStatus(ShopByLifeStyle $shopByLifeStyle)
    {
        $shopByLifeStyle->is_active = !$shopByLifeStyle->is_active;
        $shopByLifeStyle->save();

        return redirect()->route('shop-by-life-styles.index')->with('success', 'Status updated.');
    }

    public function destroy(ShopByLifeStyle $shopByLifeStyle)
    {
        if ($shopByLifeStyle->image && Storage::disk('public')->exists($shopByLifeStyle->image)) {
            Storage::disk('public')->delete($shopByLifeStyle->image);
        }

        $shopByLifeStyle->delete();

        return redirect()->route('shop-by-life-styles.index')->with('success', 'Shop By Life Style deleted successfully.');
    }
}
