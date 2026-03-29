<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Lato:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
      <link rel="stylesheet" href="{{ asset('public/frontend/css/style.css') }}">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="review-store-url" content="{{ route('reviews.store') }}">
      <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
       @stack('styles') 
    <title>ETTHNICOAST - Premium Silver Jewelry</title>
</head>
<body class="@yield('body-class')">
    <!-- ============================================================
         Navbar and hero section together
         ============================================================ -->
<nav id="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="#"><i class="fab fa-instagram"></i></a>
            <a href="#"><i class="fab fa-facebook"></i></a>
            <a href="#"><i class="fab fa-pinterest"></i></a>
        </div>

        <div class="nav-center">
            <a href="{{route('frontend.index')}}" class="nav-logo">
                <img id="navLogo" src="{{ asset('public/assets/etthnicoast.png') }}" alt="Ethnicoast Logo">
            </a>
        </div>

        <div class="nav-right">
            <a href="#" id="searchToggle"><i class="fas fa-search"></i></a>
         {{-- replace: <a href="./orders.html"><i class="fas fa-shopping-bag"></i></a> --}}

@php
    $cartCount = 0;
    if (auth('frontend')->check()) {
        $userCart  = \App\Models\Cart::where('user_id', auth('frontend')->id())->first();
        $cartCount = $userCart
            ? \App\Models\CartItem::where('cart_id', $userCart->id)->sum('quantity')
            : 0;
    }
@endphp

<a href="{{ route('frontend.cart') }}" style="position:relative;">
    <i class="fas fa-shopping-bag"></i>
    <span id="cartCount" style="
        position:absolute; top:-8px; right:-10px;
        background:var(--secondary-peach); color:var(--primary-blue);
        font-size:.55rem; font-weight:800; font-family:var(--font-secondary);
        min-width:17px; height:17px; border-radius:50%;
        display:{{ $cartCount > 0 ? 'flex' : 'none' }};
        align-items:center; justify-content:center;
        padding:0 3px; line-height:1; letter-spacing:0;
    ">{{ $cartCount ?: '' }}</span>
</a>
            {{-- <a href="./profile.html"><i class="fas fa-user"></i></a> --}}
   <a href="{{ route('frontend.profile') }}"><i class="fas fa-user"></i></a>
        </div>

        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>

        <div class="nav-links-container" id="navLinksContainer">
            <ul class="nav-links">

                @foreach($navCategories as $category)

                    @if($category->subCategories->count() > 0)

                        <li class="dropdown">
                            {{-- clicking the parent goes to the full category collection --}}
                            <a href="{{ route('collection.show', $category->slug) }}">
                                {{ $category->name }}
                            </a>

                            <ul class="dropdown-menu">
                                @foreach($category->subCategories as $sub)
                                    <li>
                                        {{-- each sub-category links to its own slug --}}
                                        <a href="{{ route('collection.show', $sub->slug) }}">
                                            {{ $sub->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>

                    @else

                        <li>
                            <a href="{{ route('collection.show', $category->slug) }}">
                                {{ $category->name }}
                            </a>
                        </li>

                    @endif

                @endforeach


                <li class="dropdown">
    <a href="#">More at Etthnicoast</a>

    <ul class="dropdown-menu more-at-menu">
        <li><a href="{{route('frontend.about')}}">About Us</a></li>
        <li><a href="{{route('frontend.why_us')}}">Why Us</a></li>
        <li><a href="{{route('frontend.chat_with_us')}}">Chat with Us</a></li>
        <li><a href="{{route("frontend.animal_welfare")}}">Animal Welfare</a></li>
    </ul>
</li>
            </ul>
        </div>
    </div>
</nav>

     @include('frontend.partials.search')
      <main>
        @yield('contents')
    </main>
     




     <footer class="ec-footer">
  <div class="ec-footer-inner">

    {{-- TOP LINKS --}}
    <div class="ec-footer-grid">

      <div class="ec-footer-col">
        <h4>SHOP</h4>
        <ul>
          <li><a href="{{ route('collection.show', 'rings') }}">Rings</a></li>
          <li><a href="{{ route('collection.show', 'earrings') }}">Earrings</a></li>
          <li><a href="{{ route('collection.show', 'necklaces') }}">Necklaces</a></li>
          <li><a href="{{ route('collection.show', 'bracelets') }}">Bracelets</a></li>
          <li><a href="{{ route('collection.show', 'new-arrivals') }}">New Arrivals</a></li>
          <li><a href="{{ route('collection.show', 'best-sellers') }}">Best Sellers</a></li>
          <li><a href="{{ route('collection.show', 'gift-sets') }}">Gift Sets</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>RESOURCES</h4>
        <ul>
          <li><a href="{{ route('frontend.profile') }}">Order Tracking</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Shipping</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Returns & Exchanges</a></li>
          <li><a href="{{ route('collection.show') }}">Size Guide</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Jewelry Care</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}#faqWrap">FAQ</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>SERVICES</h4>
        <ul>
          <li><a href="{{ route('frontend.chat_with_us') }}">Custom Orders</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Engraving</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Gift Cards</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Bulk Gifting</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Store Pickup</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>LEGAL</h4>
        <ul>
          <li><a href="#">Terms & Conditions</a></li>
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Cookie Policy</a></li>
          <li><a href="#">Refund Policy</a></li>
          <li><a href="#">Accessibility</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>ABOUT US</h4>
        <ul>
          <li><a href="{{ route('frontend.about') }}">Our Story</a></li>
          <li><a href="{{ route('frontend.why_us') }}">Why Us</a></li>
          <li><a href="{{ route('frontend.animal_welfare') }}">Animal Welfare</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Contact Us</a></li>
          <li><a href="{{ route('frontend.chat_with_us') }}">Chat With Us</a></li>
        </ul>
      </div>

    </div>

    {{-- BOTTOM BAR --}}
    <div class="ec-footer-bottom">
      <div class="ec-footer-brand">ETTHNICOAST</div>

      <div class="ec-footer-meta">
        <span class="ec-footer-country">INDIA</span>
        <span class="ec-dot">•</span>
        <span class="ec-footer-lang">English</span>
        <span class="ec-dot">•</span>
        <span class="ec-footer-copy">© ALL RIGHTS RESERVED. {{ date('Y') }} ETTHNICOAST</span>
      </div>

      <div class="ec-footer-spacer"></div>
    </div>

  </div>
</footer>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('public/frontend/js/script.js') }}"></script>
<script src="{{ asset('public/frontend/js/reels.js') }}"></script>
@stack('scripts')
</body>
    
