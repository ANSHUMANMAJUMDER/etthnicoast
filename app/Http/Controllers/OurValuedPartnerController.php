<?php

namespace App\Http\Controllers;

use App\Models\OurValuedPartners;
use Illuminate\Http\Request;

class OurValuedPartnerController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $valuedPartners = OurValuedPartners::when($q, fn($query) => $query->where('name', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('our-valued-partners.index', compact('valuedPartners', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $valuedPartner            = new OurValuedPartners();
        $valuedPartner->name      = $request->name;
        $valuedPartner->is_active = $request->has('is_active') ? 1 : 0;
        $valuedPartner->save();

        return redirect()->route('our-valued-partners.index')->with('success', 'Valued Partner added successfully.');
    }

    public function update(Request $request, OurValuedPartners $ourValuedPartner)
    {
        $request->validate([
            'name' => 'nullable|string|max:255',
        ]);

        $ourValuedPartner->name      = $request->name;
        $ourValuedPartner->is_active = $request->has('is_active') ? 1 : 0;
        $ourValuedPartner->save();

        return redirect()->route('our-valued-partners.index')->with('success', 'Valued Partner updated successfully.');
    }

    public function toggleStatus(OurValuedPartners $ourValuedPartner)
    {
        $ourValuedPartner->is_active = !$ourValuedPartner->is_active;
        $ourValuedPartner->save();

        return redirect()->route('our-valued-partners.index')->with('success', 'Status updated.');
    }

    public function destroy(OurValuedPartners $ourValuedPartner)
    {
        $ourValuedPartner->delete();

        return redirect()->route('our-valued-partners.index')->with('success', 'Valued Partner deleted successfully.');
    }
}
