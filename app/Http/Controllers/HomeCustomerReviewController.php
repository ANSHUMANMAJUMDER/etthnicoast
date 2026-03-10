<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeCustomerReview;
class HomeCustomerReviewController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $reviews = HomeCustomerReview::when($q, fn($query) => $query->where('customer_name', 'like', "%{$q}%")
                ->orWhere('review', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('home-customer-reviews.index', compact('reviews', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
        
            'rating'        => 'required|integer|min:1|max:5',
            'review'        => 'nullable|string',
        ]);

        $review                = new HomeCustomerReview();
        $review->user_id       = auth()->id() ?? 1;
        $review->customer_name = $request->customer_name;

        $review->rating        = $request->rating;
        $review->review        = $request->review;
        $review->is_active     = $request->has('is_active') ? 1 : 0;
        $review->save();

        return redirect()->route('home-customer-reviews.index')
            ->with('success', 'Review added successfully.');
    }

    public function update(Request $request, HomeCustomerReview $homeCustomerReview)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'rating'        => 'required|integer|min:1|max:5',
            'review'        => 'nullable|string',
        ]);

        $homeCustomerReview->customer_name = $request->customer_name;
    
        $homeCustomerReview->rating        = $request->rating;
        $homeCustomerReview->review        = $request->review;
        $homeCustomerReview->is_active     = $request->has('is_active') ? 1 : 0;
        $homeCustomerReview->save();

        return redirect()->route('home-customer-reviews.index')
            ->with('success', 'Review updated successfully.');
    }

    public function toggleStatus(HomeCustomerReview $homeCustomerReview)
    {
        $homeCustomerReview->is_active = !$homeCustomerReview->is_active;
        $homeCustomerReview->save();

        return redirect()->route('home-customer-reviews.index')
            ->with('success', 'Review status updated.');
    }

    public function destroy(HomeCustomerReview $homeCustomerReview)
    {
        $homeCustomerReview->delete();

        return redirect()->route('home-customer-reviews.index')
            ->with('success', 'Review deleted successfully.');
    }
}
