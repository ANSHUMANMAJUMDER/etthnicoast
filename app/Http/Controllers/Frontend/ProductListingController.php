<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index(Request $request,$id){
        
        //    pagination make with products ,variants and images
        $product = Product::with(['variants.images','images','pearl','stone','polish','similarProducts.images','completeLookProducts.images','reviews'])
        ->where('is_active',true)->where('id',$id)->firstOrFail();
        // dd($product->reviews);
       
        return view('frontend.product-details',compact('product'));
    }
}
