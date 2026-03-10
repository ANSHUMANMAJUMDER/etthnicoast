<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use App\Models\CollectionRange;
use App\Models\EtthnicoastWorld;
use App\Models\HomeCustomerReview;
use App\Models\HomePageBannerSetup;
use App\Models\JewelleryInMotion;
use App\Models\OurBestSeller;
use App\Models\PromoStrip;
use App\Models\ShopByLifeStyle;
use App\Models\ShopTheLook;
use Illuminate\Http\Request;
use App\Models\OurValuedPartners;
class HomeController extends Controller
{
    public function index()
    {
        $banners = Banner::where('is_active', true)->get();
        $promoStrips  = PromoStrip::where('is_active', true)->get();
        $collection_ranges = CollectionRange::where('is_active', true)->get();
        $seasonal_banner = HomePageBannerSetup::where('type','seasonal_banner')->where('is_active', true)->first();
        $for_him_banner = HomePageBannerSetup::where('type','for_him')->where('is_active', true)->first();

        $for_her_banner = HomePageBannerSetup::where('type','for_her')->where('is_active', true)->first();
        $new_arrival_banner = HomePageBannerSetup::where('type','new_arrivals')->where('is_active', true)->first();

        $perfect_gift_banner = HomePageBannerSetup::where('type','perfect_gifts')->where('is_active', true)->first();
        $lifestyle_images = ShopByLifeStyle::where('is_active', true)->get();
        $etthnicoast_worlds = EtthnicoastWorld::where('is_active', true)->get();
        $bestsellers = OurBestSeller::where('is_active', true)->get();
        $generic_banner = HomePageBannerSetup::where('type','generic_banner')->where('is_active', true)->first();
        $exclusive_collection = HomePageBannerSetup::where('type','exclusive_collection')->where('is_active', true)->first();
        $shop_the_look = ShopTheLook::with('hotspots')->where('is_active', true)->get();
        $reels = JewelleryInMotion::with('product.images')->where('is_active', true)->get();
        $partners = OurValuedPartners::where('is_active', true)->get();
        $home_review = HomeCustomerReview::where('is_active',true)->get();
        return view('frontend.index', compact('banners', 'promoStrips', 'collection_ranges', 'seasonal_banner', 'for_him_banner', 'for_her_banner', 'new_arrival_banner','perfect_gift_banner','lifestyle_images', 'etthnicoast_worlds', 'bestsellers','generic_banner','exclusive_collection', 'shop_the_look','reels','partners','home_review'));
    }
}
