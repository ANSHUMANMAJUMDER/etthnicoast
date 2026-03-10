<?php

namespace App\Http\Controllers;

use App\Models\StoneType;
use Illuminate\Http\Request;

class StoneTypeController extends Controller
{
      public function index(Request $request)
    {
        $q = $request->q;

        $stoneTypes = StoneType::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('display_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('stone_types.index', compact('stoneTypes', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:stone_types,name',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        StoneType::create([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('stone-types.index')->with('success', 'Stone type created successfully.');
    }

    public function update(Request $request, StoneType $stoneType)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:stone_types,name,' . $stoneType->id,
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        $stoneType->update([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('stone-types.index')->with('success', 'Stone type updated successfully.');
    }

    public function destroy(StoneType $stoneType)
    {
        $stoneType->delete();
        return redirect()->route('stone-types.index')->with('success', 'Stone type deleted successfully.');
    }

    public function toggleStatus(StoneType $stoneType)
    {
        $stoneType->is_active = !$stoneType->is_active;
        $stoneType->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
