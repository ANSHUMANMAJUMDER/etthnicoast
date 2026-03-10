<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\CategoryTypes;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function index(Request $request)
{
    $q = $request->q;
    $typeId = $request->type_id;

    $categories = Category::with('type')
        ->when($q, function ($query) use ($q) {
            $query->where('category_name', 'like', "%{$q}%")
                  ->orWhere('description', 'like', "%{$q}%")
                  ->orWhereHas('type', function ($t) use ($q) {
                      $t->where('type_name', 'like', "%{$q}%");
                  });
        })
        ->when($typeId, function ($query) use ($typeId) {
            $query->where('category_type_id', $typeId);
        })
        ->latest()
        ->paginate(10)
        ->withQueryString();

    $categoryTypes = CategoryTypes::orderBy('type_name')->get();

    return view('categories.index', compact('categories', 'categoryTypes', 'q', 'typeId'));
}

    public function store(Request $request)
    {
        $request->validate([
            'category_type_id' => 'required',
            'category_name'    => 'required',
            'description'      => 'nullable',
            'status'           => 'nullable',
        ]);

        $category = new Category();
        $category->category_type_id = $request->category_type_id;
        $category->category_name = $request->category_name;
        $category->description = $request->description;
        $category->status = $request->has('status') ? 1 : 0;
        $category->save();

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_type_id' => 'required|exists:category_types,id',
            'category_name'    => 'required|string|max:255',
            'description'      => 'nullable|string',
            'status'           => 'nullable|boolean',
        ]);

        $category->update([
            'category_type_id' => $request->category_type_id,
            'category_name'    => $request->category_name,
            'description'      => $request->description,
            'status'           => $request->has('status') ? 1 : 0,
        ]);

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    public function toggleStatus(Category $category)
{
    $category->status = !$category->status;
    $category->save();

    return redirect()->back()->with('success', 'Status updated successfully.');
}
}
