<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EtthnicoastWorld;
use Illuminate\Support\Facades\Storage;

class EtthnicoastWorldController extends Controller
{
     public function index(Request $request)
    {
        $q = $request->q;

        $etthnicoastWorlds = EtthnicoastWorld::when($q, fn($query) => $query->where('title', 'like', "%{$q}%")
                ->orWhere('subtitle', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('etthnicoast-worlds.index', compact('etthnicoastWorlds', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $etthnicoastWorld           = new EtthnicoastWorld();
        $etthnicoastWorld->title    = $request->title;
        $etthnicoastWorld->subtitle = $request->subtitle;
        $etthnicoastWorld->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            $etthnicoastWorld->image = $request->file('image')->store('etthnicoast-worlds', 'public');
        }

        $etthnicoastWorld->save();

        return redirect()->route('etthnicoast-worlds.index')->with('success', 'Etthnicoast World added successfully.');
    }

    public function update(Request $request, EtthnicoastWorld $etthnicoastWorld)
    {
        $request->validate([
            'title'    => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'image'    => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $etthnicoastWorld->title    = $request->title;
        $etthnicoastWorld->subtitle = $request->subtitle;
        $etthnicoastWorld->is_active = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('image')) {
            if ($etthnicoastWorld->image && Storage::disk('public')->exists($etthnicoastWorld->image)) {
                Storage::disk('public')->delete($etthnicoastWorld->image);
            }
            $etthnicoastWorld->image = $request->file('image')->store('etthnicoast-worlds', 'public');
        }

        $etthnicoastWorld->save();

        return redirect()->route('etthnicoast-worlds.index')->with('success', 'Etthnicoast World updated successfully.');
    }

    public function toggleStatus(EtthnicoastWorld $etthnicoastWorld)
    {
        $etthnicoastWorld->is_active = !$etthnicoastWorld->is_active;
        $etthnicoastWorld->save();

        return redirect()->route('etthnicoast-worlds.index')->with('success', 'Status updated.');
    }

    public function destroy(EtthnicoastWorld $etthnicoastWorld)
    {
        if ($etthnicoastWorld->image && Storage::disk('public')->exists($etthnicoastWorld->image)) {
            Storage::disk('public')->delete($etthnicoastWorld->image);
        }

        $etthnicoastWorld->delete();

        return redirect()->route('etthnicoast-worlds.index')->with('success', 'Etthnicoast World deleted successfully.');
    }
}
