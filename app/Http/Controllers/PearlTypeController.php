<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PearlType;
class PearlTypeController extends Controller
{
     public function index(Request $request)
    {
        $q = $request->q;

        $pearlTypes = PearlType::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('display_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('pearl_types.index', compact('pearlTypes', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:pearl_types,name',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        PearlType::create([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->has('is_active') ? true : false,
        ]);

        return redirect()->route('pearl-types.index')->with('success', 'Pearl type created successfully.');
    }

    public function update(Request $request, PearlType $pearlType)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:pearl_types,name,' . $pearlType->id,
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        $pearlType->update([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('pearl-types.index')->with('success', 'Pearl type updated successfully.');
    }

    public function destroy(PearlType $pearlType)
    {
        $pearlType->delete();
        return redirect()->route('pearl-types.index')->with('success', 'Pearl type deleted successfully.');
    }

    public function toggleStatus(PearlType $pearlType)
    {
        $pearlType->is_active = !$pearlType->is_active;
        $pearlType->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
