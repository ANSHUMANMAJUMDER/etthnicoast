<?php

namespace App\Http\Controllers;

use App\Models\PolishType;
use Illuminate\Http\Request;

class PolishTypeController extends Controller
{
      public function index(Request $request)
    {
        $q = $request->q;

        $polishTypes = PolishType::query()
            ->when($q, function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->orderBy('display_order')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('polish_types.index', compact('polishTypes', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:polish_types,name',
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        PolishType::create([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'color_code' => $request->color_code ?? '#ffffff',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('polish-types.index')->with('success', 'Polish type created successfully.');
    }

    public function update(Request $request, PolishType $polishType)
    {
        $request->validate([
            'name'          => 'required|string|max:255|unique:polish_types,name,' . $polishType->id,
            'display_order' => 'nullable|integer|min:0',
            'is_active'     => 'nullable',
        ]);

        $polishType->update([
            'name' => $request->name,
            'display_order' => $request->display_order ?? 0,
            'color_code' => $request->color_code ?? '#ffffff',
            'is_active' => $request->has('is_active') ? 1 : 0,
        ]);

        return redirect()->route('polish-types.index')->with('success', 'Polish type updated successfully.');
    }

    public function destroy(PolishType $polishType)
    {
        $polishType->delete();
        return redirect()->route('polish-types.index')->with('success', 'Polish type deleted successfully.');
    }

    public function toggleStatus(PolishType $polishType)
    {
        $polishType->is_active = !$polishType->is_active;
        $polishType->save();

        return redirect()->back()->with('success', 'Status updated successfully.');
    }
}
