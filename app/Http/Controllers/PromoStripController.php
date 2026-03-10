<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PromoStrip;
class PromoStripController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $promoStrips = PromoStrip::when($q, fn($query) => $query->where('title', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('promo-strips.index', compact('promoStrips', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $promoStrip            = new PromoStrip();
        $promoStrip->title     = $request->title;
        $promoStrip->is_active = $request->has('is_active') ? 1 : 0;
        $promoStrip->save();

        return redirect()->route('promo-strips.index')->with('success', 'Promo Strip added successfully.');
    }

    public function update(Request $request, PromoStrip $promoStrip)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $promoStrip->title     = $request->title;
        $promoStrip->is_active = $request->has('is_active') ? 1 : 0;
        $promoStrip->save();

        return redirect()->route('promo-strips.index')->with('success', 'Promo Strip updated successfully.');
    }

    public function toggleStatus(PromoStrip $promoStrip)
    {
        $promoStrip->is_active = !$promoStrip->is_active;
        $promoStrip->save();

        return redirect()->route('promo-strips.index')->with('success', 'Promo Strip status updated.');
    }

    public function destroy(PromoStrip $promoStrip)
    {
        $promoStrip->delete();

        return redirect()->route('promo-strips.index')->with('success', 'Promo Strip deleted successfully.');
    }
}
