<?php

namespace App\Http\Controllers;
use App\Models\OurBestSeller;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class OurBestSellerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $bestSellers = OurBestSeller::when($q, fn($query) => $query->where('title', 'like', "%{$q}%")
                ->orWhere('tags', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('our-best-sellers.index', compact('bestSellers', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'tags'     => 'nullable|string|max:500',
        ]);

        $bestSeller           = new OurBestSeller();
        $bestSeller->title    = $request->title;
        $bestSeller->subtitle = $request->subtitle;
        $bestSeller->tags     = $request->tags;
        $bestSeller->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $bestSeller->image = $request->file('image')->store('our-best-sellers', 'public');
        }

        $bestSeller->save();

        return redirect()->route('our-best-sellers.index')->with('success', 'Best Seller added successfully.');
    }

    public function update(Request $request, OurBestSeller $ourBestSeller)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'tags'     => 'nullable|string|max:500',
        ]);

        $ourBestSeller->title    = $request->title;
        $ourBestSeller->subtitle = $request->subtitle;
        $ourBestSeller->tags     = $request->tags;
        $ourBestSeller->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($ourBestSeller->image && Storage::disk('public')->exists($ourBestSeller->image)) {
                Storage::disk('public')->delete($ourBestSeller->image);
            }
            $ourBestSeller->image = $request->file('image')->store('our-best-sellers', 'public');
        }

        $ourBestSeller->save();

        return redirect()->route('our-best-sellers.index')->with('success', 'Best Seller updated successfully.');
    }

    public function toggleStatus(OurBestSeller $ourBestSeller)
    {
        $ourBestSeller->is_active = !$ourBestSeller->is_active;
        $ourBestSeller->save();

        return redirect()->route('our-best-sellers.index')->with('success', 'Status updated.');
    }

    public function destroy(OurBestSeller $ourBestSeller)
    {
        if ($ourBestSeller->image && Storage::disk('public')->exists($ourBestSeller->image)) {
            Storage::disk('public')->delete($ourBestSeller->image);
        }

        $ourBestSeller->delete();

        return redirect()->route('our-best-sellers.index')->with('success', 'Best Seller deleted successfully.');
    }
}
