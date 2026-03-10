<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $banners = Banner::when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('banners.index', compact('banners', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button'   => 'required|string|max:255',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp,gif',
        ]);

        $banner           = new Banner();
        $banner->title    = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->button   = $request->button;
        $banner->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner added successfully.');
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'button'   => 'required|string|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
        ]);

        $banner->title    = $request->title;
        $banner->subtitle = $request->subtitle;
        $banner->button   = $request->button;
        $banner->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $banner->image = $request->file('image')->store('banners', 'public');
        }

        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function toggleStatus(Banner $banner)
    {
        $banner->is_active = !$banner->is_active;
        $banner->save();

        return redirect()->route('banners.index')->with('success', 'Banner status updated.');
    }

    public function destroy(Banner $banner)
    {
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }
}
