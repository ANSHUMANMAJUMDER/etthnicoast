<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CollectionRange;
use Illuminate\Support\Facades\Storage;

class CollectionRangeController extends Controller
{
       public function index(Request $request)
    {
        $q = $request->q;

        $collectionRanges = CollectionRange::when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('collection-ranges.index', compact('collectionRanges', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'url'   => 'nullable|url|max:255',
        ]);

        $collectionRange            = new CollectionRange();
        $collectionRange->name      = $request->name;
        $collectionRange->url       = $request->url;
        $collectionRange->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $collectionRange->image = $request->file('image')->store('collection-ranges', 'public');
        }

        $collectionRange->save();

        return redirect()->route('collection-ranges.index')->with('success', 'Collection Range added successfully.');
    }

    public function update(Request $request, CollectionRange $collectionRange)
    {
        $request->validate([
            'name'  => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
            'url'   => 'nullable|url|max:255',
        ]);

        $collectionRange->name      = $request->name;
        $collectionRange->url       = $request->url;
        $collectionRange->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($collectionRange->image && Storage::disk('public')->exists($collectionRange->image)) {
                Storage::disk('public')->delete($collectionRange->image);
            }
            $collectionRange->image = $request->file('image')->store('collection-ranges', 'public');
        }

        $collectionRange->save();

        return redirect()->route('collection-ranges.index')->with('success', 'Collection Range updated successfully.');
    }

    public function toggleStatus(CollectionRange $collectionRange)
    {
        $collectionRange->is_active = !$collectionRange->is_active;
        $collectionRange->save();

        return redirect()->route('collection-ranges.index')->with('success', 'Collection Range status updated.');
    }

    public function destroy(CollectionRange $collectionRange)
    {
        if ($collectionRange->image && Storage::disk('public')->exists($collectionRange->image)) {
            Storage::disk('public')->delete($collectionRange->image);
        }

        $collectionRange->delete();

        return redirect()->route('collection-ranges.index')->with('success', 'Collection Range deleted successfully.');
    }

}
