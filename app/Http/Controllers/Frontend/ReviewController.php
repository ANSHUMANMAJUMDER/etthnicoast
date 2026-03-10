<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request) {
  
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'name'       => 'required|string|max:40',
            'title'      => 'nullable|string|max:60',
            'message'    => 'required|string|max:600',
            'rating'     => 'required|integer|min:1|max:5',
        ]);

        Review::create($validated);

        return response()->json(['success' => true, 'message' => 'Review saved.']);
    
}

}
