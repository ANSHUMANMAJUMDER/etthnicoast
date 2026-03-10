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
                <a href="/" class="nav-logo">
                    <img id="navLogo" src="{{ asset('public/assets/etthnicoast.png') }}" alt="Ethnicoast Logo">
                </a>
            </div>

            <div class="nav-right">
                <a href="#" id="searchToggle"><i class="fas fa-search"></i></a>
                <a href="./orders.html"><i class="fas fa-shopping-bag"></i></a>
                <a href="./profile.html"><i class="fas fa-user"></i></a>
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
                <a href="#">{{ $category->name }}</a>

                <ul class="dropdown-menu">
                    @foreach($category->subCategories as $sub)
                        <li>
                            <a href="{{ url('sub-category'.$sub->slug) }}">
                                {{ $sub->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </li>

        @else

            <li>
                <a href="{{ url('category/'.$category->slug) }}">
                    {{ $category->name }}
                </a>
            </li>

        @endif

    @endforeach

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

    <!-- TOP LINKS -->
    <div class="ec-footer-grid">
      <div class="ec-footer-col">
        <h4>SHOP</h4>
        <ul>
          <li><a href="#">Rings</a></li>
          <li><a href="#">Earrings</a></li>
          <li><a href="#">Necklaces</a></li>
          <li><a href="#">Bracelets</a></li>
          <li><a href="#">New Arrivals</a></li>
          <li><a href="#">Best Sellers</a></li>
          <li><a href="#">Gift Sets</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>RESOURCES</h4>
        <ul>
          <li><a href="#">Order Tracking</a></li>
          <li><a href="#">Shipping</a></li>
          <li><a href="#">Returns & Exchanges</a></li>
          <li><a href="#">Size Guide</a></li>
          <li><a href="#">Jewelry Care</a></li>
          <li><a href="#">FAQ</a></li>
        </ul>
      </div>

      <div class="ec-footer-col">
        <h4>SERVICES</h4>
        <ul>
          <li><a href="#">Custom Orders</a></li>
          <li><a href="#">Engraving</a></li>
          <li><a href="#">Gift Cards</a></li>
          <li><a href="#">Bulk Gifting</a></li>
          <li><a href="#">Store Pickup</a></li>
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
          <li><a href="#">Our Story</a></li>
          <li><a href="#">Craftsmanship</a></li>
          <li><a href="#">Sustainability</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Contact Us</a></li>
        </ul>
      </div>
    </div>

    <!-- BOTTOM BAR -->
    <div class="ec-footer-bottom">
      <div class="ec-footer-brand">ETTHNICOAST</div>

      <div class="ec-footer-meta">
        <a href="#" class="ec-footer-country">INDIA</a>
        <span class="ec-dot">•</span>
        <a href="#" class="ec-footer-lang">English</a>
        <span class="ec-dot">•</span>
        <span class="ec-footer-copy">© ALL RIGHTS RESERVED. 2026 ETTHNICOAST</span>
      </div>

      <!-- no social icons (as requested) -->
      <div class="ec-footer-spacer"></div>
    </div>

  </div>
</footer>
   <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="{{ asset('public/frontend/js/script.js') }}"></script>
<script src="{{ asset('public/frontend/js/reels.js') }}"></script>
@stack('scripts')
</body>
    
