<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\CategoryTypesController;
use App\Http\Controllers\Frontend\ProductListingController;
use App\Http\Controllers\PearlTypeController;
use App\Http\Controllers\PolishTypeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\StoneTypeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PromoStripController; 
use App\Http\Controllers\CollectionRangeController;
use App\Http\Controllers\HomePageBannerSetupController;
use App\Http\Controllers\ShopByLifeStyleController;
use App\Http\Controllers\JewelleryInMotionController;
use App\Http\Controllers\OurBestSellerController;
use App\Http\Controllers\Frontend\HomeController as FrontendHomeController;
use App\Http\Controllers\Frontend\ReviewController;
use App\Http\Controllers\EtthnicoastWorldController;
use App\Http\Controllers\OurValuedPartnerController;
use App\Http\Controllers\ShopTheLookController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\AuthController as FrontEndAuthController;
use App\Http\Controllers\Frontend\OrderController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\HomeCustomerReviewController;
// Route::get('/', function () {

//     return view('frontend.index');
// });
Route::get('/',[FrontendHomeController::class,'index'])->name('frontend.index');

//   Route::get('/frontend/login',function(){   
   
//         return view('frontend.login');
//     })->name('frontend.login');
Route::get('/user/login',[FrontEndAuthController::class,'login'])->name('frontend.login');
Route::post('/user/login',[FrontEndAuthController::class,'login_store'])->name('frontend.login.store');

Route::get('/user/register',[FrontEndAuthController::class,'register'])->name('frontend.register');
Route::post('/user/register',[FrontEndAuthController::class,'register_store'])->name('frontend.register.store');


    Route::get('/frontend/register',function(){
        return view('frontend.register');
    })->name('frontend.register');

    Route::get('/men',function (){
      
        return view('frontend.men');
    })->name('frontend.men');

    // Route::get('/product-details',function(){
    //     return view('frontend.product-details');
    // })->name('frontend.product-details');
    Route::get('/product-details/{id}', [ProductListingController::class, 'index'])->name('frontend.product-details');
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');


Route::middleware('ethnicoast_user')->group(function () {
    Route::post('/cart',         [CartController::class, 'store'])->name('cart.store');
    Route::delete('/cart',       [CartController::class, 'destroy'])->name('cart.destroy');
});

// Route::middleware('ethnicoast_user')->group(function () {
    Route::post('/order/razorpay',       [OrderController::class, 'createRazorpayOrder'])->name('order.razorpay.create');
    Route::post('/order/verify',         [OrderController::class, 'verifyAndStore'])->name('order.verify');
// });
    // ── Similar Items ─────────────────────────────────────────────────────────────
Route::post('/products/{product}/similar/sync',          [ProductController::class, 'syncSimilar'])->name('products.similar.sync');
Route::delete('/products/{product}/similar/{similarProductId}', [ProductController::class, 'removeSimilar'])->name('products.similar.remove');
Route::get('/products/{product}/similar/data',           [ProductController::class, 'getSimilar'])->name('products.similar.data');

// ── Complete The Look ─────────────────────────────────────────────────────────
Route::post('/products/{product}/complete-look/sync',             [ProductController::class, 'syncCompleteLook'])->name('products.completeLook.sync');
Route::delete('/products/{product}/complete-look/{lookProductId}',[ProductController::class, 'removeCompleteLook'])->name('products.completeLook.remove');
Route::get('/products/{product}/complete-look/data',              [ProductController::class, 'getCompleteLook'])->name('products.completeLook.data');
    Route::get('cart',function(){
        return view('frontend.cart');
    })->name('frontend.cart');

  Route::get('/women',function (){
        return view('frontend.women');
    })->name('frontend.women');

Route::group(['middleware'=>'auth'],function()
{
    Route::get('home',function()
    {
        return view('dashboard.home');
    });

  
    Route::get('dashboard',function()
    {
        return view('dashboard.home');
    })->name('dashboard');
});

Auth::routes();

Route::group(['namespace' => 'App\Http\Controllers\Auth'],function()
{
    // -----------------------------login----------------------------------------//
    Route::controller(LoginController::class)->group(function () {
        Route::get('/admin/login', 'login')->name('admin.login');
        Route::post('/admin/login', 'authenticate')->name('admin.login');
        Route::get('/admin/logout', 'logout')->name('logout');
        Route::get('/admin/logout/page', 'logoutPage')->name('logout/page');
    });

    // ------------------------------ register ----------------------------------//
    Route::controller(RegisterController::class)->group(function () {
        Route::get('/register', 'register')->name('register');
        Route::post('/register','storeUser')->name('register');    
    });

    // ----------------------------- forget password ----------------------------//
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('forget-password', 'getEmail')->name('forget-password');
        Route::post('forget-password', 'postEmail')->name('forget-password');    
    });

    // ----------------------------- reset password -----------------------------//
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('reset-password/{token}', 'getPassword');
        Route::post('reset-password', 'updatePassword');    
    });
});

Route::middleware(['auth'])->group(function () {
Route::group(['namespace' => 'App\Http\Controllers'],function()
{
    Route::middleware('auth')->group(function () {
        // --------------------- main dashboard ------------------//
        Route::controller(HomeController::class)->group(function () {
            Route::get('/home', 'index')->name('home');
            Route::get('profile', 'profile')->name('profile');
        });
    });

    // ------------------------ Product ------------------------//
 

    // ------------------------ Sales ---------------------------//

    
    // ------------------------ Expenses ------------------------//
   

    // ------------------------ Transfer ------------------------//
   
    // ------------------------ Application ------------------------//
   
    // ------------------------- User -----------------------------//
    Route::middleware('auth')->prefix('user')->group(function () {
        Route::controller(UserController::class)->group(function () {
            Route::get('list', 'list')->name('user/list');
            Route::get('new', 'new')->name('user/new');
        });
    });
    // ----------------------- Settings ----------------------------//
    Route::middleware('auth')->prefix('setting')->group(function () {
        Route::controller(SettingsController::class)->group(function () {
            Route::get('general', 'general')->name('setting/general');
            Route::get('email', 'email')->name('setting/email');
          
        });
    });

      Route::middleware('auth')->prefix('category_type')->group(function () {
        Route::get('category_type_list', [CategoryTypesController::class, 'index'])->name('category_type.index');
        Route::post('category_type_store', [CategoryTypesController::class, 'store'])->name('category_type.store'); 
        Route::put('category_type_update/{id}', [CategoryTypesController::class, 'update'])->name('category_type.update');
        Route::delete('category_type_delete/{id}', [CategoryTypesController::class, 'destroy'])->name('category_type.destroy');

});
  

Route::resource('categories', CategoriesController::class)->middleware('auth');
Route::patch('categories/{category}/toggle-status', [CategoriesController::class, 'toggleStatus'])
    ->name('categories.toggleStatus')
    ->middleware('auth');

    Route::resource('pearl-types', PearlTypeController::class)->only(['index','store','update','destroy']);
Route::patch('pearl-types/{pearlType}/toggle-status', [PearlTypeController::class, 'toggleStatus'])->name('pearl-types.toggleStatus');
    
Route::resource('polish-types', PolishTypeController::class)->only(['index','store','update','destroy']);
Route::patch('polish-types/{polishType}/toggle-status', [PolishTypeController::class, 'toggleStatus'])->name('polish-types.toggleStatus');



Route::resource('stone-types', StoneTypeController::class)->only(['index','store','update','destroy']);
Route::patch('stone-types/{stoneType}/toggle-status', [StoneTypeController::class, 'toggleStatus'])
    ->name('stone-types.toggleStatus');

    Route::resource('products', ProductController::class)->only(['index','store','update','destroy']);
Route::patch('products/{product}/toggle-status', [ProductController::class, 'toggleStatus'])->name('products.toggleStatus');

Route::post('products/{product}/variants', [ProductController::class, 'storeVariant'])->name('products.variants.store');
Route::put('products/variants/{variant}', [ProductController::class, 'updateVariant'])->name('products.variants.update');
Route::delete('products/variants/{variant}', [ProductController::class, 'destroyVariant'])->name('products.variants.destroy');

Route::get('/banners',                  [BannerController::class, 'index'])->name('banners.index');
Route::post('/banners',                 [BannerController::class, 'store'])->name('banners.store');
Route::put('/banners/{banner}',         [BannerController::class, 'update'])->name('banners.update');
Route::patch('/banners/{banner}/status',[BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');
Route::delete('/banners/{banner}',      [BannerController::class, 'destroy'])->name('banners.destroy');


Route::get('/promo-strips',                      [PromoStripController::class, 'index'])->name('promo-strips.index');
Route::post('/promo-strips',                     [PromoStripController::class, 'store'])->name('promo-strips.store');
Route::put('/promo-strips/{promoStrip}',         [PromoStripController::class, 'update'])->name('promo-strips.update');
Route::patch('/promo-strips/{promoStrip}/status',[PromoStripController::class, 'toggleStatus'])->name('promo-strips.toggleStatus');
Route::delete('/promo-strips/{promoStrip}',      [PromoStripController::class, 'destroy'])->name('promo-strips.destroy');

Route::get('/collection-ranges',                          [CollectionRangeController::class, 'index'])->name('collection-ranges.index');
Route::post('/collection-ranges',                         [CollectionRangeController::class, 'store'])->name('collection-ranges.store');
Route::put('/collection-ranges/{collectionRange}',        [CollectionRangeController::class, 'update'])->name('collection-ranges.update');
Route::patch('/collection-ranges/{collectionRange}/status',[CollectionRangeController::class, 'toggleStatus'])->name('collection-ranges.toggleStatus');
Route::delete('/collection-ranges/{collectionRange}',     [CollectionRangeController::class, 'destroy'])->name('collection-ranges.destroy');


Route::get('/home-page-banner-setups',                              [HomePageBannerSetupController::class, 'index'])->name('home-page-banner-setups.index');
Route::post('/home-page-banner-setups',                             [HomePageBannerSetupController::class, 'store'])->name('home-page-banner-setups.store');
Route::put('/home-page-banner-setups/{homePageBannerSetup}',        [HomePageBannerSetupController::class, 'update'])->name('home-page-banner-setups.update');
Route::patch('/home-page-banner-setups/{homePageBannerSetup}/status',[HomePageBannerSetupController::class, 'toggleStatus'])->name('home-page-banner-setups.toggleStatus');
Route::delete('/home-page-banner-setups/{homePageBannerSetup}',     [HomePageBannerSetupController::class, 'destroy'])->name('home-page-banner-setups.destroy');


Route::get('/shop-by-life-styles',                           [ShopByLifeStyleController::class, 'index'])->name('shop-by-life-styles.index');
Route::post('/shop-by-life-styles',                          [ShopByLifeStyleController::class, 'store'])->name('shop-by-life-styles.store');
Route::put('/shop-by-life-styles/{shopByLifeStyle}',         [ShopByLifeStyleController::class, 'update'])->name('shop-by-life-styles.update');
Route::patch('/shop-by-life-styles/{shopByLifeStyle}/status',[ShopByLifeStyleController::class, 'toggleStatus'])->name('shop-by-life-styles.toggleStatus');
Route::delete('/shop-by-life-styles/{shopByLifeStyle}',      [ShopByLifeStyleController::class, 'destroy'])->name('shop-by-life-styles.destroy');


Route::get('/jewellery-in-motions',                              [JewelleryInMotionController::class, 'index'])->name('jewellery-in-motions.index');
Route::post('/jewellery-in-motions',                             [JewelleryInMotionController::class, 'store'])->name('jewellery-in-motions.store');
Route::put('/jewellery-in-motions/{jewelleryInMotion}',          [JewelleryInMotionController::class, 'update'])->name('jewellery-in-motions.update');
Route::patch('/jewellery-in-motions/{jewelleryInMotion}/status', [JewelleryInMotionController::class, 'toggleStatus'])->name('jewellery-in-motions.toggleStatus');
Route::delete('/jewellery-in-motions/{jewelleryInMotion}',       [JewelleryInMotionController::class, 'destroy'])->name('jewellery-in-motions.destroy');



Route::get('/our-best-sellers',                           [OurBestSellerController::class, 'index'])->name('our-best-sellers.index');
Route::post('/our-best-sellers',                          [OurBestSellerController::class, 'store'])->name('our-best-sellers.store');
Route::put('/our-best-sellers/{ourBestSeller}',           [OurBestSellerController::class, 'update'])->name('our-best-sellers.update');
Route::patch('/our-best-sellers/{ourBestSeller}/status',  [OurBestSellerController::class, 'toggleStatus'])->name('our-best-sellers.toggleStatus');
Route::delete('/our-best-sellers/{ourBestSeller}',        [OurBestSellerController::class, 'destroy'])->name('our-best-sellers.destroy');



Route::get('/etthnicoast-worlds',                              [EtthnicoastWorldController::class, 'index'])->name('etthnicoast-worlds.index');
Route::post('/etthnicoast-worlds',                             [EtthnicoastWorldController::class, 'store'])->name('etthnicoast-worlds.store');
Route::put('/etthnicoast-worlds/{etthnicoastWorld}',           [EtthnicoastWorldController::class, 'update'])->name('etthnicoast-worlds.update');
Route::patch('/etthnicoast-worlds/{etthnicoastWorld}/status',  [EtthnicoastWorldController::class, 'toggleStatus'])->name('etthnicoast-worlds.toggleStatus');
Route::delete('/etthnicoast-worlds/{etthnicoastWorld}',        [EtthnicoastWorldController::class, 'destroy'])->name('etthnicoast-worlds.destroy');



// ── Shop The Look (main) ──────────────────────────────────────────────────────
Route::get('/shop-the-looks',                          [ShopTheLookController::class, 'index'])->name('shop-the-looks.index');
Route::post('/shop-the-looks',                         [ShopTheLookController::class, 'store'])->name('shop-the-looks.store');
Route::put('/shop-the-looks/{shopTheLook}',            [ShopTheLookController::class, 'update'])->name('shop-the-looks.update');
Route::patch('/shop-the-looks/{shopTheLook}/status',   [ShopTheLookController::class, 'toggleStatus'])->name('shop-the-looks.toggleStatus');
Route::delete('/shop-the-looks/{shopTheLook}',         [ShopTheLookController::class, 'destroy'])->name('shop-the-looks.destroy');

// ── Hotspots (nested under ShopTheLook) ──────────────────────────────────────
Route::get('/shop-the-looks/{shopTheLook}/hotspots',                                    [ShopTheLookController::class, 'hotspots'])->name('shop-the-looks.hotspots');
Route::post('/shop-the-looks/{shopTheLook}/hotspots',                                   [ShopTheLookController::class, 'storeHotspot'])->name('shop-the-looks.hotspots.store');
Route::put('/shop-the-looks/{shopTheLook}/hotspots/{hotspot}',                          [ShopTheLookController::class, 'updateHotspot'])->name('shop-the-looks.hotspots.update');
Route::patch('/shop-the-looks/{shopTheLook}/hotspots/{hotspot}/status',                 [ShopTheLookController::class, 'toggleHotspotStatus'])->name('shop-the-looks.hotspots.toggleStatus');
Route::delete('/shop-the-looks/{shopTheLook}/hotspots/{hotspot}',                       [ShopTheLookController::class, 'destroyHotspot'])->name('shop-the-looks.hotspots.destroy');


Route::get('/our-valued-partners',                            [OurValuedPartnerController::class, 'index'])->name('our-valued-partners.index');
Route::post('/our-valued-partners',                           [OurValuedPartnerController::class, 'store'])->name('our-valued-partners.store');
Route::put('/our-valued-partners/{ourValuedPartner}',         [OurValuedPartnerController::class, 'update'])->name('our-valued-partners.update');
Route::patch('/our-valued-partners/{ourValuedPartner}/status',[OurValuedPartnerController::class, 'toggleStatus'])->name('our-valued-partners.toggleStatus');
Route::delete('/our-valued-partners/{ourValuedPartner}',      [OurValuedPartnerController::class, 'destroy'])->name('our-valued-partners.destroy');


Route::prefix('home-customer-reviews')->name('home-customer-reviews.')->group(function () {
    Route::get('/',                         [HomeCustomerReviewController::class, 'index'])        ->name('index');
    Route::post('/',                        [HomeCustomerReviewController::class, 'store'])        ->name('store');
    Route::put('/{homeCustomerReview}',     [HomeCustomerReviewController::class, 'update'])       ->name('update');
    Route::patch('/{homeCustomerReview}/toggle-status',
                                            [HomeCustomerReviewController::class, 'toggleStatus']) ->name('toggleStatus');
    Route::delete('/{homeCustomerReview}',  [HomeCustomerReviewController::class, 'destroy'])      ->name('destroy');
});

Route::get('/reports/sales',[ReportController::class,'monthlyReport'])->name('reports.sales');
});
});