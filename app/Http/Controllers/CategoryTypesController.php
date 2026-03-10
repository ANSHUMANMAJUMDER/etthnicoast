<?php

namespace App\Http\Controllers;

use App\Models\CategoryTypes;
use Illuminate\Http\Request;

class CategoryTypesController extends Controller
{
 public function index(Request $request)
{
    $q = $request->q;

    $categoryTypes = CategoryTypes::query()
        ->when($q, function ($query) use ($q) {
            $query->where('type_name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%");
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    return view('category_types.index', compact('categoryTypes', 'q'));
}

public function store(Request $request)
{
    $request->validate([
        'type_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $categoryType = new CategoryTypes();
    $categoryType->type_name = $request->type_name;
    $categoryType->description = $request->description;
    $categoryType->save();

    return redirect()->route('category_type.index')->with('success', 'Category type created successfully.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'type_name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $categoryType = CategoryTypes::findOrFail($id);
    $categoryType->type_name = $request->type_name;
    $categoryType->description = $request->description;
    $categoryType->save();

    return redirect()->route('category_type.index')->with('success', 'Category type updated successfully.');
}

public function destroy($id)
{
    $categoryType = CategoryTypes::findOrFail($id);
    $categoryType->delete();

    return redirect()->route('category_type.index')->with('success', 'Category type deleted successfully.');
}
}
