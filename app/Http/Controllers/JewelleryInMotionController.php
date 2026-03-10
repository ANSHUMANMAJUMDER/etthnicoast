<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\JewelleryInMotion;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class JewelleryInMotionController extends Controller
{
     public function index(Request $request)
    {
        $q = $request->q;

        $jewelleryInMotions = JewelleryInMotion::with('product')
            ->when($q, fn($query) => $query->whereHas('product', fn($q2) => $q2->where('name', 'like', "%{$q}%")))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        $products = Product::with('images')->orderBy('base_name')->get();


        return view('jewellery-in-motions.index', compact('jewelleryInMotions', 'products', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'video'      => 'required|mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm,video/x-msvideo|max:51200',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $jewelleryInMotion             = new JewelleryInMotion();
        $jewelleryInMotion->user_id    = Auth::id();
        $jewelleryInMotion->product_id = $request->product_id ?: null;
        $jewelleryInMotion->is_active  = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('video')) {
            $jewelleryInMotion->video = $request->file('video')->store('jewellery-in-motions', 'public');
        }

        $jewelleryInMotion->save();

        return redirect()->route('jewellery-in-motions.index')->with('success', 'Jewellery In Motion added successfully.');
    }

    public function update(Request $request, JewelleryInMotion $jewelleryInMotion)
    {
        $request->validate([
            'video'      => 'nullable|mimetypes:video/mp4,video/mpeg,video/quicktime,video/webm,video/x-msvideo|max:51200',
            'product_id' => 'nullable|exists:products,id',
        ]);

        $jewelleryInMotion->product_id = $request->product_id ?: null;
        $jewelleryInMotion->is_active  = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('video')) {
            // Delete old video
            if ($jewelleryInMotion->video && Storage::disk('public')->exists($jewelleryInMotion->video)) {
                Storage::disk('public')->delete($jewelleryInMotion->video);
            }
            $jewelleryInMotion->video = $request->file('video')->store('jewellery-in-motions', 'public');
        }

        $jewelleryInMotion->save();

        return redirect()->route('jewellery-in-motions.index')->with('success', 'Jewellery In Motion updated successfully.');
    }

    public function toggleStatus(JewelleryInMotion $jewelleryInMotion)
    {
        $jewelleryInMotion->is_active = !$jewelleryInMotion->is_active;
        $jewelleryInMotion->save();

        return redirect()->route('jewellery-in-motions.index')->with('success', 'Status updated.');
    }

    public function destroy(JewelleryInMotion $jewelleryInMotion)
    {
        if ($jewelleryInMotion->video && Storage::disk('public')->exists($jewelleryInMotion->video)) {
            Storage::disk('public')->delete($jewelleryInMotion->video);
        }

        $jewelleryInMotion->delete();

        return redirect()->route('jewellery-in-motions.index')->with('success', 'Jewellery In Motion deleted successfully.');
    }
}
