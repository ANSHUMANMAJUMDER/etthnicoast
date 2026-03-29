 @extends('frontend.layouts.master')

@section('contents')
   

    <section class="hero-slider-section">
    <div class="hero-slider">

        @foreach($banners as $index => $banner)
            <div class="slide {{ $index == 0 ? 'active' : '' }}">
                
                <img src="{{ asset('public/storage/' . $banner->image) }}" 
                     alt="{{ $banner->title }}">

                <div class="slide-content">
                    <h1>{{ $banner->title }}</h1>
                    <p>{{ $banner->subtitle }}</p>
                    
                    <a href="#" class="cta-button">
                        {{ $banner->button }}
                    </a>
                </div>

            </div>
        @endforeach

    </div>

    <!-- Previous Button -->
    <button class="slider-btn prev-btn" onclick="changeSlide(-1)">
        <i class="fas fa-chevron-left"></i>
    </button>

    <!-- Next Button -->
    <button class="slider-btn next-btn" onclick="changeSlide(1)">
        <i class="fas fa-chevron-right"></i>
    </button>

    <!-- Dynamic Dots -->
    <div class="slider-dots">
        @foreach($banners as $index => $banner)
            <span class="dot {{ $index == 0 ? 'active' : '' }}" 
                  onclick="goToSlide({{ $index }})">
            </span>
        @endforeach
    </div>
</section>

    <!-- ============================================================
         PROMO STRIP
         ============================================================ -->
   
<div class="promo-strip">
    <div class="promo-content">

        @for($i = 0; $i < 3; $i++) {{-- Repeat 3 times for smooth marquee --}}
            @foreach($promoStrips as $strip)
                
                <a href="{{ $strip->link ?? '#' }}">
                    <span>{{ $strip->title }}</span>
                </a>

                <span>•</span>

            @endforeach
        @endfor

    </div>
</div>


    <!-- ============================================================
         COLLECTION RANGE SLIDER
         ============================================================ -->
  
{{-- <section class="collection-range-section">
    <div class="collection-range-container">
     
        <div class="collection-cards-wrapper">
            <div class="collection-cards" id="collectionCards">

                @foreach($collection_ranges as $range)
                    <div class="collection-range-card">

                 
                        @php
                            $rangeSlug = \App\Models\TabCategories::where('slug', \Illuminate\Support\Str::slug($range->name))
                                ->where('is_active', true)
                                ->value('slug');
                        @endphp

                        <a href="{{ $rangeSlug ? route('collection.show', $rangeSlug) : route('collection.show') }}">

                            <div class="collection-card-image">
                                <img src="{{ asset('public/storage/' . $range->image) }}" 
                                     alt="{{ $range->name }}">
                            </div>

                            <div class="collection-range-overlay">
                                <h3>{{ $range->name }}</h3>
                            </div>

                        </a>
                    </div>
                @endforeach

            </div>
        </div>
        
        <div style="text-align: center;">
            <a href="{{ route('collection.show') }}" class="collection-range-link">
                Collection Range
            </a>
        </div>
            
    </div>
</section> --}}
<section class="collection-range-section">
    <div class="collection-range-container">

        <button class="collection-nav-btn prev" onclick="scrollCollection(-1)">  <i class="fas fa-chevron-left"></i></button>

        <div class="collection-cards-wrapper" id="collectionWrapper">
            <div class="collection-cards" id="collectionCards">

                @foreach($collection_ranges as $range)
                    <div class="collection-range-card">

                        @php
                            $rangeSlug = \App\Models\TabCategories::where('slug', \Illuminate\Support\Str::slug($range->name))
                                ->where('is_active', true)
                                ->value('slug');
                        @endphp

                        <a href="{{ $rangeSlug ? route('collection.show', $rangeSlug) : route('collection.show') }}">
                            <div class="collection-card-image">
                                <img src="{{ asset('public/storage/' . $range->image) }}"
                                     alt="{{ $range->name }}">
                            </div>
                            <div class="collection-range-overlay">
                                <h3>{{ $range->name }}</h3>
                            </div>
                        </a>

                    </div>
                @endforeach

            </div>
        </div>

        <button class="collection-nav-btn next" onclick="scrollCollection(1)">  <i class="fas fa-chevron-right"></i></button>


    </div>
</section>

<script>
    function scrollCollection(direction) {
        const wrapper = document.getElementById('collectionWrapper');
        wrapper.scrollBy({ left: direction * 220, behavior: 'smooth' });
    }
</script>
    <!-- ============================================================
         GENERAL BANNER
         ============================================================ -->
  
    {{-- dynamic general banner  --}}
    @if ($seasonal_banner->type == 'seasonal_banner')
        <section class="general-banner scroll-lift card-lift">
            <div class="general-banner-container">
                <img src="{{ asset('public/storage/' . $seasonal_banner->banner_image) }}" alt="{{ $seasonal_banner->banner_title }}">
                <div class="general-banner-overlay">
                    <h2>{{ $seasonal_banner->banner_title }}</h2>
                    <p>{{ $seasonal_banner->banner_subtitle }}</p>
                    <a href="{{ $seasonal_banner->banner_link ?? '#' }}" class="cta-button">
                        {{ $seasonal_banner->button_text ?? 'SHOP NOW' }}
                    </a>
                </div>
            </div>
        </section>
    @endif

    <!-- ============================================================
         GENDER SECTION
         ============================================================ -->
    <section class="gender-section">
        <div class="gender-container">
            <h2 class="section-title">SHOP BY GENDER</h2>
            <p class="section-subtitle">Discover collections crafted for every style</p>
            <div class="gender-grid">
                <!-- For Him -->
               @isset($for_him_banner)
                   
         @if ($for_him_banner)
         
        <div class="gender-row" id="men">
                    <div class="gender-card">
                        <img src="{{ asset('public/storage/' . $for_him_banner->banner_image) }}" alt="{{ $for_him_banner->title }}">
                        <div class="gender-overlay">
                            <div class="gender-info">
                                <h3>{{ $for_him_banner->title }}</h3>
                                <p>{{ $for_him_banner->subtitle }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="gender-text">
                        <h3>{{ $for_him_banner->title }}</h3>
                        <p>{{ $for_him_banner->description }}</p>
                        <a href="{{ $for_him_banner->button_link ?? '#' }}" class="cta-button">
                            {{ $for_him_banner->button_text ?? 'SHOP NOW' }}
                        </a>
                    </div>
                </div>
                     
                 @endif
                 @endisset
                  

                 @isset($for_her_banner)
                     @if ($for_her_banner)
                     <div class="gender-row reverse" id="women">
                    <div class="gender-card">
                        {{-- <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=800&q=80" alt="For Her"> --}}
                        <img src="{{ asset('public/storage/' . $for_her_banner->banner_image) }}" alt="{{ $for_her_banner->title }}">
                        <div class="gender-overlay">
                            <div class="gender-info">
                                <h3>FOR {{ $for_her_banner->title }}</h3>
                                <p>{{ $for_her_banner->subtitle }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="gender-text" >
                        <h3>{{ $for_her_banner->title }}</h3>
                        <p>{{ $for_her_banner->description }}</p>
                        <a href="{{ $for_her_banner->button_link ?? '#' }}" class="cta-button">
                            {{ $for_her_banner->button_text ?? 'SHOP NOW' }}
                        </a>
                    </div>
                    
                </div>


                     @endif
                 @endisset
                <!-- For Her -->
                
            </div>
        </div>
    </section>

    <!-- ============================================================
         NEW ARRIVALS BANNER (MODERN DARK BANNER STYLE)
         ============================================================ -->
  
    {{-- dynamic new arrival  --}}

    @isset($new_arrival_banner)
         @if ($new_arrival_banner->type =='new_arrivals')
        <section class="new-arrivals-banner scroll-lift card-lift" id="new-arrivals">
            <div class="banner-container">
                <div class="banner-content">
                    <h2>{{ $new_arrival_banner->title }}</h2>
                    <p>{{ $new_arrival_banner->subtitle }}</p>
                    <a href="{{ $new_arrival_banner->button_link ?? '#' }}" class="cta-button">
                        {{ $new_arrival_banner->button_text ?? 'SHOP NOW' }}
                    </a>
                </div>
                <div class="banner-image">
                    <img src="{{ asset('public/storage/' . $new_arrival_banner->banner_image) }}" alt="{{ $new_arrival_banner->title }}">
                </div>
            </div>
        </section>
    @endif
    @endisset
   

    <!-- ============================================================
         GIFTING BANNER (STYLE 2 - OVERLAY DESIGN)
         ============================================================ -->
    {{-- gifting banner dynamic 2 --}}
    @isset($perfect_gift_banner)
        @if ($perfect_gift_banner->type == 'perfect_gifts')
            <section class="gifting-banner scroll-lift card-lift">
                <div class="gifting-banner-container">
                    <img src="{{ asset('public/storage/' . $perfect_gift_banner->banner_image) }}" alt="{{ $perfect_gift_banner->banner_title }}">
                    <div class="gifting-banner-overlay">
                        <h2>{{ $perfect_gift_banner->banner_title }}</h2>
                        <p>{{ $perfect_gift_banner->banner_subtitle }}</p>
                        <a href="{{ $perfect_gift_banner->button_link ?? '#' }}" class="cta-button">
                            {{ $perfect_gift_banner->button_text ?? 'SHOP NOW' }}
                        </a>
                    </div>
                </div>
            </section>
        @endif
    @endisset

    <!-- ============================================================
         LIFESTYLE SECTION
         ============================================================ -->
        <div class="swiper-section">  
    <div class="lifestyle-container"> 
        <h2 class="section-title">SHOP BY LIFESTYLE</h2>
        <p class="section-subtitle">For every you</p>
        <div class="swiper-wrapper-container">
            
          <div class="swiper mySwiper">
        @isset($lifestyle_images)
        <div class="swiper-wrapper">
            @foreach ($lifestyle_images as $image)
                <div class="swiper-slide">
                    <img src="{{ asset('public/storage/' . $image->image) }}" alt="{{ $image->title }}">
                </div>
                
            @endforeach
        </div>    
        @endisset

        <div class="swiper-button-next"></div>
        <div class="swiper-button-prev"></div>
    </div>
        </div>
    </div>
        </div>
   
    <!-- ============================================================
         WORLD SECTION
         ============================================================ -->
    <section class="world-section">
        <div class="world-container">
            <h2 class="section-title">ETTHNICOAST WORLD</h2>
            <p class="section-subtitle">Explore our exquisite collections</p>

            <div class="world-grid">
                {{-- <div class="world-card">
                    <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=1000&q=80" alt="Silver">
                    <div class="world-overlay">
                        <div class="world-info">
                            <h3>SILVER</h3>
                            <p>Pure 925 Sterling Silver</p>
                        </div>
                    </div>
                </div>

                <div class="world-card">
                    <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1000&q=80" alt="Gold Plated">
                    <div class="world-overlay">
                        <div class="world-info">
                            <h3>GOLD PLATED</h3>
                            <p>Luxury Layered Shine</p>
                        </div>
                    </div>
                </div>

                <div class="world-card">
                    <img src="https://images.unsplash.com/photo-1522335789203-aabd1fc54bc9?w=1000&q=80" alt="XOXO">
                    <div class="world-overlay">
                        <div class="world-info">
                            <h3>XOXO</h3>
                            <p>Younger • Trendier • Everyday Styles</p>
                        </div>
                    </div>
                </div>

                <div class="world-card">
                    <img src="https://images.unsplash.com/photo-1526170375885-4d8ecf77b99f?w=1000&q=80" alt="XOXO">
                    <div class="world-overlay">
                        <div class="world-info">
                            <h3>XOXO</h3>
                            <p>Minimal & Modern Elegance</p>
                        </div>
                    </div>
                </div> --}}
                @isset($etthnicoast_worlds)
                    @foreach ($etthnicoast_worlds as $world)
                        <div class="world-card">
                            <img src="{{ asset('public/storage/' . $world->image) }}" alt="{{ $world->title }}">
                            <div class="world-overlay">
                                <div class="world-info">
                                    <h3>{{ $world->title }}</h3>
                                    <p>{{ $world->subtitle }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>

    <!-- ============================================================
         BESTSELLERS SECTION
         ============================================================ -->
    <section class="bestsellers-section">
        <div class="bestsellers-container">
            <h2 class="section-title">OUR BESTSELLERS</h2>
            <p class="section-subtitle">The most loved pieces from Etthnicoast</p>
   

            <div class="bestsellers-grid">
                @isset($bestsellers)
                    @foreach ($bestsellers as $bestseller)
                        <div class="bestseller-card scroll-animate">
                            <div class="bestseller-image">
                                <img src="{{ asset('public/storage/' . $bestseller->image) }}" alt="{{ $bestseller->title }}">
                                <div class="bestseller-badge">{{ $bestseller->tags }}</div>
                            </div>
                            <div class="bestseller-info">
                                <h3>{{ $bestseller->title }}</h3>
                                <p>{{ $bestseller->subtitle }}</p>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>


 {{-- <section class="jm-reels-section">
        <div class="jm-reels-inner">
            <div class="jm-reels-header">
                <div class="jm-section-title">
                    JEWELLERY IN MOTION</div>
                <div class="jm-section-subtitle">Scroll through our latest styling videos</div>
            </div>
            <div class="jm-reels-slider">
                <button class="jm-reels-arrow jm-reels-prev" type="button">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <div class="jm-reels-track">

            <div class="jm-reel-card jm-scroll-animate" data-product="1">
                <video src="videos/jewellery1.mp4" muted loop autoplay playsinline></video>
                <div class="jm-reel-product">
                    <img src="images/product1.jpg">
                    <div class="jm-reel-product-info">
                        <!-- <span class="jm-reel-title">Diamond Necklace</span> -->
                         <span class="jm-reel-desc">
        Elegant handcrafted diamond necklace for special occasions
    </span>
                        <span class="jm-reel-price">₹24,999</span>
                    </div>
                </div>
            </div>

            <div class="jm-reel-card jm-scroll-animate" data-product="2">
                <video src="videos/jewellery2.mp4" muted loop autoplay playsinline></video>
                <div class="jm-reel-product">
                    <img src="images/product2.jpg">
                    <div class="jm-reel-product-info">
                        <!-- <span class="jm-reel-title">Gold Earrings</span> -->
                         <span class="jm-reel-desc">
        Elegant handcrafted diamond necklace for special occasions
    </span>
                        <span class="jm-reel-price">₹18,499</span>
                    </div>
                </div>
            </div>

            <div class="jm-reel-card jm-scroll-animate" data-product="3">
                <video src="videos/jewellery3.mp4" muted loop autoplay playsinline></video>
                <div class="jm-reel-product">
                    <img src="images/product3.jpg">
                    <div class="jm-reel-product-info">
                        <!-- <span class="jm-reel-title">Bracelet</span> -->
                         <span class="jm-reel-desc">
        Elegant handcrafted diamond necklace for special occasions
    </span>
                        <span class="jm-reel-price">₹12,999</span>
                    </div>
                </div>
            </div>
            <div class="jm-reel-card jm-scroll-animate" data-product="4">
                <video src="videos/jewellery4.mp4" muted loop autoplay playsinline></video>
                <div class="jm-reel-product">
                    <img src="images/product4.jpg">
                    <div class="jm-reel-product-info">
                        <!-- <span class="jm-reel-title">Sapphire Ring</span> -->
                         <span class="jm-reel-desc">
        Elegant handcrafted diamond necklace for special occasions
    </span>
                        <span class="jm-reel-price">₹15,499</span>
                    </div>
                </div>
            </div>
            <div class="jm-reel-card jm-scroll-animate" data-product="5">
                <video src="videos/jewellery5.mp4" muted loop autoplay playsinline></video>
                <div class="jm-reel-product">
                    <img src="images/product5.jpg">
                    <div class="jm-reel-product-info">
                        <!-- <span class="jm-reel-title">Emerald Pendant</span> -->
                         <span class="jm-reel-desc">
        Elegant handcrafted diamond necklace for special occasions
    </span>
                        <span class="jm-reel-price">₹22,999</span>
                    </div>
                </div>
            </div>

        </div>
                <button class="jm-reels-arrow jm-reels-next" type="button">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </section>

    <!-- PRODUCT MODAL -->
    <div class="jm-modal" id="jmModal">
        <!-- modal left/right arrows -->
        <button class="jm-modal-arrow jm-modal-prev" type="button">
            <i class="fas fa-chevron-left"></i>
        </button>

        <div class="jm-modal-content">
            <button class="jm-modal-close" id="jmModalClose">
                <i class="fas fa-times"></i>
            </button>
            
            <div class="jm-modal-video">
                <video id="jmModalVideo" controls muted loop playsinline>
                    <source src="" type="video/mp4">
                </video>
            </div>
            
            <div class="jm-modal-product">
                <img id="jmModalProductImage" src="" alt="" class="jm-modal-product-image">
                
                <div class="jm-modal-badges">
                    <span class="jm-badge jm-badge-free">FREE GIFT</span>
                    <span class="jm-badge jm-badge-award">AWARD WINNING</span>
                </div>
                
                <h2 id="jmModalTitle" class="jm-modal-title"></h2>
                <p id="jmModalPrice" class="jm-modal-price"></p>
                
                <h3 class="jm-modal-desc-title">Description</h3>
                <p id="jmModalDescription" class="jm-modal-desc-text"></p>
                <span class="jm-read-more">Read more</span>
                
                <div class="jm-modal-buttons">
                    <button class="jm-modal-btn jm-btn-more-info">
                        More info
                    </button>
                    <button class="jm-modal-btn jm-btn-add-cart">
                        Add to cart
                    </button>
                    <div class="jm-btn-cart-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                </div>
            </div>
        </div>

        <button class="jm-modal-arrow jm-modal-next" type="button">
            <i class="fas fa-chevron-right"></i>
        </button>
    </div> --}}




    {{-- Reels  --}}
    @if($reels && $reels->isNotEmpty())

<section class="jm-reels-section">
    <div class="jm-reels-inner">
        <div class="jm-reels-header">
            <div class="jm-section-title">JEWELLERY IN MOTION</div>
            <div class="jm-section-subtitle">Scroll through our latest styling videos</div>
        </div>
        <div class="jm-reels-slider">
            <button class="jm-reels-arrow jm-reels-prev" type="button">
                <i class="fas fa-chevron-left"></i>
            </button>
            <div class="jm-reels-track">

                @foreach($reels as $index => $reel)
                @php
                    $product    = $reel->product;
                    $img        = $product?->images->first();
                    $imgUrl     = $img ? asset('public/storage/' . $img->image) : 'https://via.placeholder.com/300x300';
                    $videoUrl   = asset('public/storage/' . $reel->video);
                    $price      = $product?->discount_price ?? $product?->base_price ?? 0;
                    $productUrl = $product ? route('frontend.product-details', $product->id) : '#';
                @endphp
                <div class="jm-reel-card jm-scroll-animate"
                     data-index="{{ $index }}"
                     data-video="{{ $videoUrl }}"
                     data-image="{{ $imgUrl }}"
                     data-name="{{ $product?->base_name ?? 'Product' }}"
                     data-price="₹{{ number_format($price, 0) }}"
                     data-description="{{ Str::limit($product?->description ?? '', 160) }}"
                     data-url="{{ $productUrl }}">
                    <video src="{{ $videoUrl }}" muted loop autoplay playsinline></video>
                    <div class="jm-reel-product">
                        <img src="{{ $imgUrl }}" alt="{{ $product?->base_name }}">
                        <div class="jm-reel-product-info">
                            <span class="jm-reel-desc">
                                {{ Str::limit($product?->description ?? '', 60) }}
                            </span>
                            <span class="jm-reel-price">₹{{ number_format($price, 0) }}</span>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            <button class="jm-reels-arrow jm-reels-next" type="button">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
    </div>
</section>

{{-- Modal — same structure, no changes --}}
<div class="jm-modal" id="jmModal">
    <button class="jm-modal-arrow jm-modal-prev" type="button">
        <i class="fas fa-chevron-left"></i>
    </button>
    <div class="jm-modal-content">
        <button class="jm-modal-close" id="jmModalClose">
            <i class="fas fa-times"></i>
        </button>
        <div class="jm-modal-video">
            <video id="jmModalVideo" controls muted loop playsinline>
                <source src="" type="video/mp4">
            </video>
        </div>
        <div class="jm-modal-product">
            <img id="jmModalProductImage" src="" alt="" class="jm-modal-product-image">
            <div class="jm-modal-badges">
                <span class="jm-badge jm-badge-free">FREE GIFT</span>
                <span class="jm-badge jm-badge-award">AWARD WINNING</span>
            </div>
            <h2 id="jmModalTitle" class="jm-modal-title"></h2>
            <p id="jmModalPrice" class="jm-modal-price"></p>
            <h3 class="jm-modal-desc-title">Description</h3>
            <p id="jmModalDescription" class="jm-modal-desc-text"></p>
            <span class="jm-read-more">Read more</span>
            <div class="jm-modal-buttons">
                <button class="jm-modal-btn jm-btn-more-info">More info</button>
                <button class="jm-modal-btn jm-btn-add-cart">Add to cart</button>
                <div class="jm-btn-cart-icon"><i class="fas fa-shopping-cart"></i></div>
            </div>
        </div>
    </div>
    <button class="jm-modal-arrow jm-modal-next" type="button">
        <i class="fas fa-chevron-right"></i>
    </button>
</div>

@endif

<!-- =============================================================
DIWALI SECTION 
==================================================================-->
{{-- <section class="ec-diwali-banner scroll-lift card-lift" id="diwali-banner">
  <div class="ec-diwali-container">

    <div class="ec-diwali-content">
      <p class="ec-diwali-eyebrow">DIWALI CELEBRATIONS</p>
      <h2>Shine Brighter This Diwali</h2>
      <p class="ec-diwali-sub">
        Celebrate the festival of lights with premium silver jewelry—crafted to glow with every moment.
      </p>

      <div class="ec-diwali-actions">
        <a href="#" class="ec-diwali-btn primary">SHOP DIWALI EDIT</a>
        <a href="#" class="ec-diwali-btn secondary">GIFT GUIDE</a>
      </div>

      <p class="ec-diwali-note">Limited festive pieces • Fast delivery • Gift-ready packaging</p>
    </div>

    <div class="ec-diwali-visual">
      <img
        src="https://images.unsplash.com/photo-1603565816030-6b389eeb23cb?w=1400&q=80"
        alt="Diwali jewelry collection"
      />
      <div class="ec-diwali-badge">FESTIVE</div>
    </div>

  </div>
</section> --}}
{{-- dynamic generic banner --}}
{{-- @isset($generic_banner) --}}
     <section class="ec-diwali-banner scroll-lift card-lift" id="diwali-banner">
  <div class="ec-diwali-container">

    <div class="ec-diwali-content">
      <p class="ec-diwali-eyebrow">DIWALI CELEBRATIONS</p>
      <h2>{{ $generic_banner->banner_title }}</h2>
      <p class="ec-diwali-sub">
        {{ $generic_banner->banner_subtitle }}
      </p>
      <div class="ec-diwali-actions">
        <a href="#" class="ec-diwali-btn primary">{{ $generic_banner->button_text }}</a>
        <a href="#" class="ec-diwali-btn secondary">{{ $generic_banner->button_text_2 }}</a>
      </div>

      <p class="ec-diwali-note">Limited festive pieces • Fast delivery • Gift-ready packaging</p>
    </div>

    <div class="ec-diwali-visual">
      {{-- <img
        src="https://images.unsplash.com/photo-1603565816030-6b389eeb23cb?w=1400&q=80"
        alt="Diwali jewelry collection"
      /> --}}
        <img src="{{ asset('public/storage/' . $generic_banner->banner_image) }}" alt="{{ $generic_banner->banner_title }}" />
      <div class="ec-diwali-badge">FESTIVE</div>
    </div>

  </div>
</section>

{{-- @endisset --}}


    <!-- ============================================================
         VALUES SECTION
         ============================================================ -->
  
<section class="values-section">
    <div class="values-container">
        <div class="values-scroll-wrapper">
            <div class="values-grid">
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-certificate"></i></div>
                    <h3>PURITY GUARANTEE</h3>
                    <p>100% hallmarked 925 sterling silver</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-eye"></i></div>
                    <h3>TRANSPARENCY</h3>
                    <p>Clear pricing, no hidden costs</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-handshake"></i></div>
                    <h3>TRUST</h3>
                    <p>Trusted by thousands of customers</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-gem"></i></div>
                    <h3>QUALITY</h3>
                    <p>Premium craftsmanship guaranteed</p>
                </div>

                <!-- Duplicate for seamless loop -->
                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-certificate"></i></div>
                    <h3>PURITY GUARANTEE</h3>
                    <p>100% hallmarked 925 sterling silver</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-eye"></i></div>
                    <h3>TRANSPARENCY</h3>
                    <p>Clear pricing, no hidden costs</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-handshake"></i></div>
                    <h3>TRUST</h3>
                    <p>Trusted by thousands of customers</p>
                </div>

                <div class="value-card">
                    <div class="value-icon"><i class="fas fa-gem"></i></div>
                    <h3>QUALITY</h3>
                    <p>Premium craftsmanship guaranteed</p>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- ============================================================
         ANIMAL WELFARE SECTION
         ============================================================ -->
    <section class="animal-welfare-section">
        <div class="animal-welfare-container">
            <div class="animal-welfare-content">
                <h3>COMPASSION IN EVERY PURCHASE</h3>
                <p>With every purchase you make, ₹10-20 goes directly to animal welfare organizations. Together, we're making a difference in the lives of animals in need.</p>
                <div class="animal-welfare-highlight">
                    <i class="fas fa-heart"></i>
                    <span>Your Purchase = Their Hope</span>
                </div>
            </div>
            <div class="animal-welfare-image">
                <div class="animal-welfare-icon-box">
                    <i class="fas fa-paw"></i>
                    <span>RESCUE</span>
                </div>
                <div class="animal-welfare-icon-box">
                    <i class="fas fa-heart"></i>
                    <span>CARE</span>
                </div>
                <div class="animal-welfare-icon-box">
                    <i class="fas fa-home"></i>
                    <span>SHELTER</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ============================================================
         PRICE SECTION
         ============================================================ -->
    <section class="price-section">
        <div class="price-container">
            <h2 class="section-title">Shop by Price</h2>
            <p class="section-subtitle">For every occasion & gifting needs</p>
            <div class="price-grid">
                <div class="price-card">
                    <div class="price-card-image">
                        <img src="https://images.unsplash.com/photo-1549062572-544a64fb0c56?w=600&q=80" alt="Upto ₹2000">
                    </div>
                    <div class="price-card-content">
                        <h3>Upto ₹2000</h3>
                    </div>
                </div>
                <div class="price-card">
                    <div class="price-card-image">
                        <img src="https://images.unsplash.com/photo-1603561596112-0a132b757442?w=600&q=80" alt="₹2000 to ₹4000">
                    </div>
                    <div class="price-card-content">
                        <h3>₹2000 to ₹4000</h3>
                    </div>
                </div>
                <div class="price-card">
                    <div class="price-card-image">
                        <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600&q=80" alt="₹4000 to ₹5000">
                    </div>
                    <div class="price-card-content">
                        <h3>₹4000 to ₹5000</h3>
                    </div>
                </div>
                <div class="price-card">
                    <div class="price-card-image">
                        <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=600&q=80" alt="Above ₹5000">
                    </div>
                    <div class="price-card-content">
                        <h3>Above ₹5000</h3>
                    </div>
                </div>
            </div>
        </div>
    </section>

<!-- ============================================================
         OPTIONAL BANNER (SPLIT DESIGN WITH ANIMATION)
         ============================================================ -->

    @isset($exclusive_collection)
           <section class="optional-banner scroll-lift card-lift">
        <div class="optional-banner-container">
            <div class="optional-banner-left">
                <div class="optional-banner-content">
                    <h2>{{ $exclusive_collection->banner_title }}</h2>
                    <p>{{ $exclusive_collection->banner_subtitle }}</p>
                    <a href="#" class="cta-button">{{ $exclusive_collection->button_text }}</a>
                </div>
            </div>
            <div class="optional-banner-right">
                <img src="{{ asset('public/storage/' . $exclusive_collection->banner_image) }}" alt="{{ $exclusive_collection->banner_title }}">
                <div class="optional-banner-badge">NEW</div>
            </div>
        </div>
    </section>
    @endisset


    
    <!-- ============================================================
         Hotspot SECTION
         ============================================================ -->

    @if($shop_the_look && $shop_the_look->isNotEmpty())
@php
  $look = $shop_the_look->first();
  $activeHotspots = $look->hotspots->where('is_active', true)->values();
  $firstHotspot = $activeHotspots->first();
  $firstProduct = $firstHotspot?->product;
  $firstImg = $firstProduct?->images->first();
  $firstImgUrl = $firstImg ? asset('public/storage/' . $firstImg->image) : 'https://via.placeholder.com/600x600';
  $firstPrice = $firstProduct?->discount_price ?? $firstProduct?->base_price ?? 0;
@endphp

<section class="hotspot-section">
    <div class="hotspot-container">
        <div class="hotspot-title">
            <h2>SHOP THE LOOK</h2>
            <p>Tap the hotspots to explore the highlighted pieces</p>
        </div>
        
        <div class="hotspot-layout">
            <div class="hotspot-image-wrapper">
                <img src="{{ asset('public/storage/' . $look->image) }}" 
                     alt="{{ $look->title }}" 
                     class="hotspot-main-image">
                
                @foreach($activeHotspots as $hotspot)
                @php
                    $product    = $hotspot->product;
                    $img        = $product?->images->first();
                    $imgUrl     = $img ? asset('public/storage/' . $img->image) : 'https://via.placeholder.com/600x600';
                    $price      = $product?->discount_price ?? $product?->base_price ?? 0;
                    $productUrl = $product ? route('frontend.product-details', $product->id) : '#';
                @endphp
                <div class="hotspot" 
                     style="top: {{ $hotspot->y_coordinate }}%; left: {{ $hotspot->x_coordinate }}%;" 
                     data-product="{{ $product?->id }}"
                     data-title="{{ $product?->base_name ?? 'Product' }}"
                     data-category="{{ $product?->category?->name ?? 'Jewellery' }}"
                     data-description="{{ Str::limit($product?->description ?? '', 120) }}"
                     data-price="₹{{ number_format($price, 0) }}"
                     data-badge="Focus: {{ $product?->category?->name ?? 'Jewellery' }}"
                     data-image="{{ $imgUrl }}"
                     data-url="{{ $productUrl }}">
                    <span class="hotspot-pulse"></span>
                    <span class="hotspot-dot">+</span>
                </div>
                @endforeach
            </div>
            
            <div class="hotspot-details-panel">
                <div class="hotspot-detail-image-wrapper">
                    <img id="lookImage"
                         src="{{ $firstImgUrl }}"
                         alt="Selected jewelry piece"
                         class="hotspot-detail-image">
                </div>
                <p class="hotspot-eyebrow" id="lookBadge">
                    Focus: {{ $firstProduct?->category?->name ?? 'Jewellery' }}
                </p>
                <div class="hotspot-divider"></div>
                <h3 class="hotspot-product-title" id="lookTitle">
                    {{ $firstProduct?->base_name ?? '' }}
                </h3>
                <p class="hotspot-product-meta" id="lookCategory">
                    {{ $firstProduct?->category?->name ?? '' }}
                </p>
                <p class="hotspot-product-description" id="lookDescription">
                    {{ Str::limit($firstProduct?->description ?? '', 120) }}
                </p>
                <p class="hotspot-product-price" id="lookPrice">
                    ₹{{ number_format($firstPrice, 0) }}
                </p>
                <div class="hotspot-buttons">
                    <a href="{{ $firstProduct ? route('frontend.product-details', $firstProduct->id) : '#' }}" 
                       id="lookShopBtn" 
                       class="product-btn primary">Shop Now</a>
                    <a href="#" class="product-btn secondary">Price on Request</a>
                </div>
                <p class="hotspot-hint">
                    Tap the <strong>+</strong> icons on the image to change the highlighted piece.
                </p>
            </div>
        </div>

        <p class="shop-look-note">
            Tap on the <strong>+</strong> buttons to view product details, pricing, and explore each highlighted piece.
        </p>
    </div>
</section>

<div class="hotspot-modal" id="hotspotModal">
    <div class="modal-content">
        <button class="modal-close" id="modalClose">
            <i class="fas fa-times"></i>
        </button>
        <img id="modalImage" src="" alt="Product" class="modal-product-image">
        <div class="modal-product-details">
            <p class="modal-eyebrow" id="modalBadge">Featured Look</p>
            <div class="modal-divider"></div>
            <h3 class="modal-product-title" id="modalTitle">Product Name</h3>
            <p class="modal-product-meta" id="modalCategory">Category</p>
            <p class="modal-product-description" id="modalDescription">Description</p>
            <p class="modal-product-price" id="modalPrice">Price</p>
            <div class="modal-buttons">
                <a href="#" id="modalShopBtn" class="product-btn primary">Shop Now</a>
                <a href="#" class="product-btn secondary">Price on Request</a>
            </div>
        </div>
    </div>
</div>

@endif
    

    <!-- ============================================================
         PARTNERS SECTION
         ============================================================ -->
    <section class="partners-section">
    <div class="partners-container">
        <h2 class="section-title">OUR VALUED PARTNERS</h2>
        <p class="section-subtitle">Trusted collaborations</p>
        <div class="partners-grid">
            @isset($partners)
                @foreach ($partners as $partner)
                    <div class="partner-logo">
                       <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">{{ $partner->name }}</span>
                    </div>
                @endforeach
            @endisset
        {{-- <div class="partners-grid">
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">MICROSOFT</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">GOOGLE</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">AMAZON</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">SALESFORCE</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">IBM</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">ORACLE</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">SAP</span>
            </div>
            <div class="partner-logo">
                <span style="font-size: 1.5rem; font-weight: 300; letter-spacing: 2px; color: var(--primary-blue);">ADOBE</span>
            </div>
        </div> --}}
    </div>
</section>

    <!-- ============================================================
         REVIEWS SECTION
         ============================================================ -->
    <section class="reviews-section">
        <div class="reviews-container">
            <h2 class="section-title">CUSTOMER REVIEWS</h2>
            <p class="section-subtitle">What our customers say</p>
          <div class="reviews-grid">
    @isset($home_review)
        @foreach($home_review as $review)
            @php
                $filled = str_repeat('★', $review->rating);
                $empty  = str_repeat('☆', 5 - $review->rating);
            @endphp
            <div class="review-card">
                <div class="review-rating">{{ $filled . $empty }}</div>
                <p class="review-text">"{{ $review->review }}"</p>
                <p class="review-author">- {{ $review->customer_name }}</p>
            </div>
        @endforeach
    @endisset
</div>
        </div>
    </section>

 





@endsection