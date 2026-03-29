<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Wishlist;

class ProfileController extends Controller
{
    public function index()
    {
        if (!auth('frontend')->check()) {
            return redirect()->route('frontend.login');
        }

        $user = auth('frontend')->user();

        $orders = Order::where('user_id', $user->id)
            ->with(['items.product.images', 'invoice'])
            ->latest()
            ->get();

        $wishlistItems = Wishlist::where('user_id', $user->id)
            ->with(['product' => fn($q) => $q->with('images')])
            ->latest()
            ->get();

        return view('frontend.profile', compact('user', 'orders', 'wishlistItems'));
    }
}