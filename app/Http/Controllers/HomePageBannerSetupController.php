<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomePageBannerSetup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class HomePageBannerSetupController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->q;

        $bannerSetups = HomePageBannerSetup::when($q, fn($query) => $query->where('title', 'like', "%{$q}%")
                ->orWhere('banner_title', 'like', "%{$q}%"))
            ->orderBy('id', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('home-page-banner-setups.index', compact('bannerSetups', 'q'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner_image'    => 'required|image|mimes:jpg,jpeg,png,webp,gif',
            'banner_title'    => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_link'     => 'nullable|url|max:255',
            'button_text'     => 'nullable|string|max:255',
            'button_text_2'   => 'nullable|string|max:255',
            'title'           => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:1000',
        ]);

        $bannerSetup                  = new HomePageBannerSetup();
        $bannerSetup->user_id         = Auth::id();
        $bannerSetup->banner_title    = $request->banner_title;
        $bannerSetup->banner_subtitle = $request->banner_subtitle;
        $bannerSetup->banner_link     = $request->banner_link;
        $bannerSetup->button_text     = $request->button_text;
        $bannerSetup->button_text_2   = $request->button_text_2;
        $bannerSetup->title           = $request->title;
        $bannerSetup->description     = $request->description;
        $bannerSetup->is_active       = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('banner_image')) {
            $bannerSetup->banner_image = $request->file('banner_image')->store('home-page-banners', 'public');
        }

        $bannerSetup->save();

        return redirect()->route('home-page-banner-setups.index')->with('success', 'Home Page Banner Setup added successfully.');
    }

    public function update(Request $request, HomePageBannerSetup $homePageBannerSetup)
    {
        $request->validate([
            'banner_image'    => 'nullable|image|mimes:jpg,jpeg,png,webp,gif',
            'banner_title'    => 'nullable|string|max:255',
            'banner_subtitle' => 'nullable|string|max:255',
            'banner_link'     => 'nullable|url|max:255',
            'button_text'     => 'nullable|string|max:255',
            'button_text_2'   => 'nullable|string|max:255',
            'title'           => 'nullable|string|max:255',
            'description'     => 'nullable|string|max:1000',
        ]);

        $homePageBannerSetup->banner_title    = $request->banner_title;
        $homePageBannerSetup->banner_subtitle = $request->banner_subtitle;
        $homePageBannerSetup->banner_link     = $request->banner_link;
        $homePageBannerSetup->button_text     = $request->button_text;
        $homePageBannerSetup->button_text_2   = $request->button_text_2;
        $homePageBannerSetup->title           = $request->title;
        $homePageBannerSetup->description     = $request->description;
        $homePageBannerSetup->is_active       = $request->has('is_active') ? 1 : 0;

        if ($request->hasFile('banner_image')) {
            // Delete old image
            if ($homePageBannerSetup->banner_image && Storage::disk('public')->exists($homePageBannerSetup->banner_image)) {
                Storage::disk('public')->delete($homePageBannerSetup->banner_image);
            }
            $homePageBannerSetup->banner_image = $request->file('banner_image')->store('home-page-banners', 'public');
        }

        $homePageBannerSetup->save();

        return redirect()->route('home-page-banner-setups.index')->with('success', 'Home Page Banner Setup updated successfully.');
    }

    public function toggleStatus(HomePageBannerSetup $homePageBannerSetup)
    {
        $homePageBannerSetup->is_active = !$homePageBannerSetup->is_active;
        $homePageBannerSetup->save();

        return redirect()->route('home-page-banner-setups.index')->with('success', 'Status updated.');
    }

    public function destroy(HomePageBannerSetup $homePageBannerSetup)
    {
        if ($homePageBannerSetup->banner_image && Storage::disk('public')->exists($homePageBannerSetup->banner_image)) {
            Storage::disk('public')->delete($homePageBannerSetup->banner_image);
        }

        $homePageBannerSetup->delete();

        return redirect()->route('home-page-banner-setups.index')->with('success', 'Home Page Banner Setup deleted successfully.');
    }
}
