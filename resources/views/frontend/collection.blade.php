<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Finger Rings — Etthnicoast</title>
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,600;1,300;1,400&family=Lato:wght@300;400;500;700&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

  <style>
    *, *::before, *::after { margin: 0; padding: 0; box-sizing: border-box; }

    :root {
      --primary-blue: #07203F;
      --secondary-peach: #EBDED4;
      --dark-black: #02000D;
      --white: #FFFFFF;
      --light-peach: #F8E3D2;
      --font-primary: 'Cormorant Garamond', 'Garamond', 'Times New Roman', serif;
      --font-secondary: 'Lato', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
      --gold: #c9a96e;
    }

    html { scroll-behavior: smooth; }
    body { font-family: var(--font-secondary); color: var(--dark-black); overflow-x: hidden; }
    body, p, span, small, label, input, textarea, select, button { font-family: var(--font-secondary); }
    h1, h2, h3, .section-title { font-family: var(--font-primary); }
    .section-subtitle { font-family: var(--font-primary); }

    /* ─── PROMO STRIP ─────────────────────────────── */
    .promo-strip { background: var(--primary-blue); color: var(--white); padding: 0.8rem 0; overflow: hidden; }
    .promo-content { display: flex; gap: 3rem; animation: marqueeScroll 22s linear infinite; width: fit-content; }
    .promo-content span { font-size: 0.85rem; letter-spacing: 2px; white-space: nowrap; }
    @keyframes marqueeScroll { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

    /* ─── NAV ─────────────────────────────────────── */
    nav { position: fixed; top: 0; width: 100%; background: transparent; z-index: 9999; transition: all 0.4s ease; }
    nav.scrolled, nav:hover { background: var(--white); box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
    .nav-container {
      max-width: 1600px; margin: 0 auto; padding: 1.2rem 3rem;
      display: grid; grid-template-columns: 1fr auto 1fr; align-items: center;
      transition: padding 0.4s ease;
    }
    nav.scrolled .nav-container, nav:hover .nav-container { padding: 0.8rem 3rem; }
    .nav-left { display: flex; gap: 1.5rem; justify-content: flex-start; align-items: center; }
    .nav-left a { color: var(--white); font-size: 0.9rem; text-decoration: none; transition: all 0.3s ease; }
    nav.scrolled .nav-left a, nav:hover .nav-left a { color: var(--dark-black); }
    nav.scrolled .nav-left a:hover, nav:hover .nav-left a:hover { color: var(--primary-blue); }
    .nav-center { display: flex; justify-content: center; }
    .nav-logo-text {
      font-family: var(--font-primary); font-size: 1.6rem; font-weight: 600;
      letter-spacing: 5px; color: var(--white); text-decoration: none;
      text-transform: uppercase; transition: color 0.3s ease;
    }
    nav.scrolled .nav-logo-text, nav:hover .nav-logo-text { color: var(--primary-blue); }
    .nav-right { display: flex; gap: 1.5rem; justify-content: flex-end; align-items: center; }
    .nav-right a { color: var(--white); font-size: 1rem; text-decoration: none; transition: all 0.3s ease; }
    nav.scrolled .nav-right a, nav:hover .nav-right a { color: var(--dark-black); }
    nav.scrolled .nav-right a:hover, nav:hover .nav-right a:hover { color: var(--primary-blue); }
    .nav-links-container { grid-column: 1 / -1; display: flex; justify-content: center; margin-top: 0.4rem; }
    .nav-links { display: flex; list-style: none; gap: 3rem; align-items: center; }
    .nav-links a {
      text-decoration: none; color: var(--white); font-size: 0.78rem;
      letter-spacing: 2px; text-transform: uppercase; font-weight: 400;
      transition: all 0.3s ease; position: relative; padding: 0.4rem 0;
    }
    nav.scrolled .nav-links a, nav:hover .nav-links a { color: var(--dark-black); }
    nav.scrolled .nav-links a:hover, nav:hover .nav-links a:hover { color: var(--primary-blue); }
    .nav-links a::after {
      content: ''; position: absolute; bottom: 0; left: 0;
      width: 0; height: 1px; background: var(--primary-blue); transition: width 0.3s ease;
    }
    .nav-links a:hover::after { width: 100%; }
    .nav-links a.active-nav { color: var(--primary-blue) !important; }
    nav.scrolled .nav-links a.active-nav, nav:hover .nav-links a.active-nav { color: var(--primary-blue); }

    /* ─── COLLECTION HERO ─────────────────────────── */
    .collection-hero {
      position: relative; height: 60vh; min-height: 420px; max-height: 580px;
      overflow: hidden; display: flex; align-items: center; justify-content: center;
    }
    .collection-hero-bg {
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(7,32,63,0.82) 0%, rgba(10,45,84,0.55) 55%, rgba(7,32,63,0.82) 100%),
        url('https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=1600&q=80') center/cover no-repeat;
      transform: scale(1.04);
      animation: heroZoom 8s ease-out forwards;
    }
    @keyframes heroZoom { from { transform: scale(1.04); } to { transform: scale(1); } }
    .collection-hero-content { position: relative; z-index: 2; text-align: center; animation: fadeInUp 1s ease forwards; }
    @keyframes fadeInUp { from { opacity: 0; transform: translateY(30px); } to { opacity: 1; transform: translateY(0); } }
    .hero-eyebrow {
      font-family: var(--font-secondary); font-size: 0.78rem; letter-spacing: 5px;
      color: var(--secondary-peach); text-transform: uppercase; margin-bottom: 1.2rem;
    }
    .hero-title {
      font-family: var(--font-primary); font-size: clamp(3rem, 7vw, 5.5rem);
      font-weight: 300; letter-spacing: 12px; color: var(--white);
      text-transform: uppercase; margin-bottom: 1rem;
    }
    .hero-sub {
      font-family: var(--font-primary); font-size: 1.15rem;
      letter-spacing: 3px; color: rgba(255,255,255,0.85); margin-bottom: 2rem;
    }

    /* ─── CTA BUTTON (matches brand style exactly) ─ */
    .cta-button {
      display: inline-block; padding: 1rem 3rem;
      background: var(--secondary-peach); color: var(--primary-blue);
      text-decoration: none; letter-spacing: 2px; font-size: 0.85rem;
      font-family: var(--font-secondary); text-transform: uppercase;
      transition: all 0.4s ease; border: 2px solid var(--secondary-peach);
    }
    .cta-button:hover { background: transparent; color: var(--secondary-peach); }

    /* ─── BREADCRUMB ──────────────────────────────── */
    .breadcrumb {
      display: flex; align-items: center; gap: 10px;
      padding: 14px 4rem; background: var(--white);
      border-bottom: 1px solid rgba(7,32,63,0.08);
    }
    .breadcrumb a, .breadcrumb span {
      font-family: var(--font-secondary); font-size: 0.72rem;
      letter-spacing: 1.5px; text-transform: uppercase;
      color: rgba(2,0,13,0.5); text-decoration: none;
    }
    .breadcrumb a:hover { color: var(--primary-blue); }
    .breadcrumb .sep { color: rgba(7,32,63,0.25); }
    .breadcrumb .current { color: var(--primary-blue); font-weight: 700; }

    /* ─── FILTER BAR ──────────────────────────────── */
    .filter-section {
      padding: 22px 4rem; background: var(--white);
      border-bottom: 1px solid rgba(7,32,63,0.08);
      display: flex; align-items: center; justify-content: space-between;
      flex-wrap: wrap; gap: 14px;
    }
    .filter-group { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
    .filter-label { font-family: var(--font-secondary); font-size: 0.68rem; letter-spacing: 2.5px; color: rgba(2,0,13,0.45); text-transform: uppercase; }
    .filter-chip {
      font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 1.5px; text-transform: uppercase;
      padding: 7px 18px; border: 1px solid rgba(7,32,63,0.2);
      background: transparent; color: rgba(2,0,13,0.6); cursor: pointer; transition: all 0.25s ease;
    }
    .filter-chip:hover, .filter-chip.active { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }
    .sort-select {
      background: transparent; border: 1px solid rgba(7,32,63,0.2);
      color: rgba(2,0,13,0.6); font-family: var(--font-secondary);
      font-size: 0.72rem; letter-spacing: 1.5px; padding: 7px 14px; cursor: pointer; outline: none;
    }
    .results-count { font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 2px; color: rgba(2,0,13,0.45); text-transform: uppercase; }

    /* ─── MAIN LAYOUT ─────────────────────────────── */
    .collection-layout { display: grid; grid-template-columns: 255px 1fr; background: #fafaf8; }

    /* ─── SIDEBAR ─────────────────────────────────── */
    .sidebar { padding: 36px 28px; background: var(--white); border-right: 1px solid rgba(7,32,63,0.08); position: sticky; top: 0; align-self: start; }
    .sidebar-block { margin-bottom: 30px; }
    .sidebar-title {
      font-family: var(--font-secondary); font-size: 0.65rem; letter-spacing: 3px;
      text-transform: uppercase; color: var(--primary-blue); font-weight: 700;
      margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid rgba(7,32,63,0.1);
    }
    .sidebar-list { list-style: none; display: flex; flex-direction: column; gap: 9px; }
    .sidebar-list li a {
      font-family: var(--font-secondary); font-size: 0.85rem; color: rgba(2,0,13,0.6);
      text-decoration: none; display: flex; justify-content: space-between; transition: color 0.2s;
    }
    .sidebar-list li a:hover, .sidebar-list li a.active { color: var(--primary-blue); }
    .sidebar-list li a span { color: rgba(7,32,63,0.35); font-size: 0.75rem; }
    .price-range-labels { display: flex; justify-content: space-between; margin-top: 8px; }
    .price-range-labels span { font-family: var(--font-secondary); font-size: 0.72rem; color: rgba(2,0,13,0.5); }
    input[type=range] { width: 100%; accent-color: var(--primary-blue); cursor: pointer; }
    .material-swatches { display: flex; gap: 10px; flex-wrap: wrap; }
    .swatch { width: 28px; height: 28px; border-radius: 50%; cursor: pointer; border: 2px solid transparent; transition: border-color .2s; }
    .swatch.active, .swatch:hover { border-color: var(--primary-blue); }
    .swatch-silver { background: linear-gradient(135deg, #c8d0dd, #f0f2f5); }
    .swatch-gold   { background: linear-gradient(135deg, #c9a96e, #e8cfa0); }
    .swatch-rose   { background: linear-gradient(135deg, #d4a0a0, #edc8c8); }
    .swatch-oxid   { background: linear-gradient(135deg, #5a5560, #7a7a85); }
    .size-grid { display: flex; gap: 7px; flex-wrap: wrap; }
    .size-chip {
      font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 1px;
      width: 36px; height: 36px; display: flex; align-items: center; justify-content: center;
      border: 1px solid rgba(7,32,63,0.2); background: transparent; color: rgba(2,0,13,0.6);
      cursor: pointer; transition: all 0.2s;
    }
    .size-chip:hover, .size-chip.active { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }

    /* ─── PRODUCTS SECTION ────────────────────────── */
    .products-section { padding: 36px 40px 80px; }

    /* ─── FEATURED BANNER — matches .new-arrivals-banner ── */
    .featured-ring-banner {
      position: relative; height: 220px; overflow: hidden;
      display: flex; align-items: center; margin-bottom: 40px;
      background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
    }
    .featured-ring-banner .banner-img {
      position: absolute; right: 0; top: 0; width: 50%; height: 100%; overflow: hidden;
    }
    .featured-ring-banner .banner-img::before {
      content: ''; position: absolute; inset: 0;
      background: linear-gradient(90deg, #0f3460 0%, transparent 55%); z-index: 1;
    }
    .featured-ring-banner .banner-img img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .featured-ring-banner:hover .banner-img img { transform: scale(1.05); }
    .featured-ring-text { position: relative; z-index: 2; padding: 0 3rem; }
    .featured-ring-text p { font-family: var(--font-secondary); font-size: 0.7rem; letter-spacing: 4px; color: var(--secondary-peach); text-transform: uppercase; margin-bottom: 0.6rem; }
    .featured-ring-text h3 { font-family: var(--font-primary); font-size: 2.4rem; font-weight: 300; color: var(--white); line-height: 1.1; letter-spacing: 3px; margin-bottom: 1.2rem; }
    .featured-ring-text .cta-button { padding: 0.8rem 2.2rem; font-size: 0.75rem; }

    /* ─── SECTION TITLE ───────────────────────────── */
    .section-title { text-align: center; font-family: var(--font-primary); font-size: 2.5rem; font-weight: 300; letter-spacing: 4px; color: var(--primary-blue); margin-bottom: 0.5rem; }
    .section-subtitle { text-align: center; font-family: var(--font-primary); font-size: 1.2rem; color: var(--dark-black); opacity: 0.7; margin-bottom: 2rem; }

    /* ─── PRODUCT GRID ────────────────────────────── */
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(255px, 1fr)); gap: 22px; }

    /* ─── PRODUCT CARD ────────────────────────────── */
    .product-card {
      background: var(--white); overflow: hidden;
      box-shadow: 0 4px 16px rgba(2,0,13,0.06);
      transition: transform 0.35s ease, box-shadow 0.35s ease; cursor: pointer;
    }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(2,0,13,0.13); }
    .card-image { position: relative; overflow: hidden; aspect-ratio: 3/4; background: var(--light-peach); }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .product-card:hover .card-image img { transform: scale(1.08); }

    /* hover overlay */
    .card-hover-overlay {
      position: absolute; inset: 0;
      background: linear-gradient(180deg, transparent 55%, rgba(7,32,63,0.88) 100%);
      display: flex; flex-direction: column; justify-content: flex-end;
      padding: 18px; opacity: 0; transition: opacity 0.3s ease;
    }
    .product-card:hover .card-hover-overlay { opacity: 1; }
    .hover-actions { display: flex; gap: 8px; }
    .btn-quick-add {
      flex: 1; padding: 10px; font-family: var(--font-secondary);
      font-size: 0.68rem; letter-spacing: 2px; text-transform: uppercase;
      background: var(--secondary-peach); color: var(--primary-blue);
      border: 2px solid var(--secondary-peach); cursor: pointer; font-weight: 700; transition: all 0.25s;
    }
    .btn-quick-add:hover { background: transparent; color: var(--secondary-peach); }
    .btn-wishlist-card {
      width: 40px; height: 40px; background: rgba(255,255,255,0.12);
      border: 1px solid rgba(255,255,255,0.3);
      display: flex; align-items: center; justify-content: center;
      cursor: pointer; transition: all 0.2s;
    }
    .btn-wishlist-card i { color: var(--white); font-size: 0.85rem; }
    .btn-wishlist-card:hover { background: var(--secondary-peach); border-color: var(--secondary-peach); }
    .btn-wishlist-card:hover i { color: var(--primary-blue); }

    /* badges */
    .card-badges { position: absolute; top: 12px; left: 12px; display: flex; flex-direction: column; gap: 5px; z-index: 2; }
    .badge { font-family: var(--font-secondary); font-size: 0.6rem; letter-spacing: 1.5px; text-transform: uppercase; padding: 4px 10px; font-weight: 700; }
    .badge-new        { background: var(--primary-blue); color: var(--white); }
    .badge-sale       { background: #c0392b; color: #fff; }
    .badge-bestseller { background: var(--dark-black); color: var(--secondary-peach); }

    /* card body */
    .card-body { padding: 16px 18px 20px; border-top: 1px solid rgba(7,32,63,0.06); }
    .card-category { font-family: var(--font-secondary); font-size: 0.62rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(7,32,63,0.45); margin-bottom: 4px; }
    .card-name { font-family: var(--font-primary); font-size: 1.18rem; font-weight: 400; line-height: 1.3; color: var(--primary-blue); margin-bottom: 5px; letter-spacing: 0.5px; }
    .card-meta { font-family: var(--font-secondary); font-size: 0.7rem; color: rgba(2,0,13,0.48); margin-bottom: 12px; }
    .card-footer { display: flex; align-items: center; justify-content: space-between; }
    .card-price { display: flex; align-items: baseline; gap: 7px; }
    .price-current { font-family: var(--font-primary); font-size: 1.2rem; font-weight: 600; color: var(--primary-blue); }
    .price-original { font-family: var(--font-secondary); font-size: 0.78rem; color: rgba(2,0,13,0.38); text-decoration: line-through; }
    .card-rating { display: flex; align-items: center; gap: 4px; }
    .stars { color: var(--gold); font-size: 0.65rem; }
    .rating-count { font-family: var(--font-secondary); font-size: 0.65rem; color: rgba(2,0,13,0.4); }

    /* ─── PAGINATION ──────────────────────────────── */
    .pagination { display: flex; justify-content: center; gap: 6px; padding: 32px 0 60px; }
    .page-btn {
      font-family: var(--font-secondary); width: 40px; height: 40px;
      display: flex; align-items: center; justify-content: center;
      font-size: 0.8rem; border: 1px solid rgba(7,32,63,0.18);
      background: var(--white); color: rgba(2,0,13,0.5); cursor: pointer; transition: all 0.2s;
    }
    .page-btn.active, .page-btn:hover { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }

    /* ─── VALUES SECTION — matches brand exactly ─── */
    .values-section { padding: 3.5rem 1.5rem; background: var(--primary-blue); color: var(--white); overflow: hidden; }
    .values-container { max-width: 1200px; margin: 0 auto; }
    .values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; }
    .value-card:nth-child(n+5) { display: none; }
    .value-card { text-align: center; padding: 1rem 0.5rem; }
    .value-icon { width: 55px; height: 55px; margin: 0 auto 1rem; background: var(--secondary-peach); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); font-size: 1.4rem; }
    .value-card h3 { font-family: var(--font-primary); font-size: 1rem; font-weight: 400; letter-spacing: 1.5px; margin-bottom: 0.6rem; color: var(--white); }
    .value-card p { font-family: var(--font-secondary); font-size: 0.85rem; opacity: 0.85; line-height: 1.45; color: var(--white); }

    /* ─── SCROLL ANIMATION ────────────────────────── */
    .scroll-lift { opacity: 0; transform: translateY(28px) scale(0.985); transition: opacity 600ms cubic-bezier(.22,1,.36,1), transform 700ms cubic-bezier(.22,1,.36,1); will-change: transform, opacity; }
    .scroll-lift.is-visible { opacity: 1; transform: translateY(0) scale(1); }

    /* ─── RESPONSIVE ──────────────────────────────── */
    @media (max-width: 1024px) {
      .collection-layout { grid-template-columns: 1fr; }
      .sidebar { display: none; }
      .filter-section { padding: 18px 1.5rem; }
      .products-section { padding: 24px 1.5rem 60px; }
      .breadcrumb { padding: 12px 1.5rem; }
      .values-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 768px) {
      .hero-title { font-size: 2.4rem; letter-spacing: 5px; }
      .collection-hero { height: 50vh; min-height: 300px; max-height: 420px; }
      .featured-ring-banner { height: 170px; }
      .featured-ring-text { padding: 0 1.5rem; }
      .featured-ring-text h3 { font-size: 1.6rem; }
      .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
      .values-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; }
      .nav-container { display: flex; justify-content: space-between; align-items: center; padding: 1rem 1.5rem; }
      .nav-links-container { display: none; }
      .nav-left { display: none; }
    }
    @media (max-width: 480px) {
      .hero-title { font-size: 2rem; letter-spacing: 3px; }
      .products-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; }
      .card-name { font-size: 1rem; }
      .price-current { font-size: 1rem; }
      .featured-ring-banner { height: 150px; }
      .featured-ring-text h3 { font-size: 1.3rem; }
    }
  </style>
</head>
<body>

<!-- NAV -->
<nav id="mainNav">
  <div class="nav-container">
    <div class="nav-left">
      <a href="#">Collections</a>
      <a href="#">New Arrivals</a>
    </div>
    <div class="nav-center">
      <a href="#" class="nav-logo-text">Etthnicoast</a>
    </div>
    <div class="nav-right">
      <a href="#"><i class="fas fa-search"></i></a>
      <a href="#"><i class="far fa-heart"></i></a>
      <a href="#"><i class="fas fa-shopping-bag"></i></a>
    </div>
    <div class="nav-links-container">
      <ul class="nav-links">
        <li><a href="#" class="active-nav">Rings</a></li>
        <li><a href="#">Pendants</a></li>
        <li><a href="#">Earrings</a></li>
        <li><a href="#">Bracelets</a></li>
        <li><a href="#">Anklets</a></li>
        <li><a href="#">Sets</a></li>
        <li><a href="#">Gifting</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- HERO -->
<section class="collection-hero">
  <div class="collection-hero-bg"></div>
  <div class="collection-hero-content">
    <p class="hero-eyebrow">925 Sterling Silver</p>
    <h1 class="hero-title">Finger Rings</h1>
    <p class="hero-sub">Crafted to adorn every story</p>
    <a href="#" class="cta-button">Explore Collection</a>
  </div>
</section>

<!-- PROMO STRIP -->
<div class="promo-strip">
  <div class="promo-content">
    <span>Free Shipping Above ₹999</span><span>•</span>
    <span>Hallmarked 925 Silver</span><span>•</span>
    <span>Easy 30-Day Returns</span><span>•</span>
    <span>Gift Packaging Available</span><span>•</span>
    <span>Free Shipping Above ₹999</span><span>•</span>
    <span>Hallmarked 925 Silver</span><span>•</span>
    <span>Easy 30-Day Returns</span><span>•</span>
    <span>Gift Packaging Available</span><span>•</span>
  </div>
</div>

<!-- BREADCRUMB -->
<div class="breadcrumb">
  <a href="#">Home</a>
  <span class="sep">›</span>
  <a href="#">Collections</a>
  <span class="sep">›</span>
  <span class="current">Finger Rings</span>
</div>

<!-- FILTER BAR -->
<div class="filter-section">
  <div class="filter-group">
    <span class="filter-label">Filter:</span>
    <button class="filter-chip active">All</button>
    <button class="filter-chip">Statement</button>
    <button class="filter-chip">Stackable</button>
    <button class="filter-chip">Oxidised</button>
    <button class="filter-chip">Gold Plated</button>
    <button class="filter-chip">Minimal</button>
  </div>
  <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
    <span class="results-count">48 Products</span>
    <select class="sort-select">
      <option>Sort: Featured</option>
      <option>Price: Low to High</option>
      <option>Price: High to Low</option>
      <option>Newest First</option>
      <option>Bestsellers</option>
    </select>
  </div>
</div>

<!-- LAYOUT -->
<div class="collection-layout">

  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="sidebar-block">
      <p class="sidebar-title">Style</p>
      <ul class="sidebar-list">
        <li><a href="#" class="active">All Rings <span>(48)</span></a></li>
        <li><a href="#">Statement Rings <span>(12)</span></a></li>
        <li><a href="#">Stackable Rings <span>(15)</span></a></li>
        <li><a href="#">Midi Rings <span>(8)</span></a></li>
        <li><a href="#">Oxidised Rings <span>(9)</span></a></li>
        <li><a href="#">Adjustable Rings <span>(4)</span></a></li>
      </ul>
    </div>
    <div class="sidebar-block">
      <p class="sidebar-title">Material</p>
      <div class="material-swatches">
        <div class="swatch swatch-silver active" title="Sterling Silver"></div>
        <div class="swatch swatch-gold" title="Gold Plated"></div>
        <div class="swatch swatch-rose" title="Rose Gold"></div>
        <div class="swatch swatch-oxid" title="Oxidised"></div>
      </div>
    </div>
    <div class="sidebar-block">
      <p class="sidebar-title">Price Range</p>
      <input type="range" min="500" max="8000" value="4000" />
      <div class="price-range-labels"><span>₹500</span><span>₹4,000</span></div>
    </div>
    <div class="sidebar-block">
      <p class="sidebar-title">Ring Size</p>
      <div class="size-grid">
        <button class="size-chip">6</button>
        <button class="size-chip active">7</button>
        <button class="size-chip">8</button>
        <button class="size-chip">9</button>
        <button class="size-chip">10</button>
        <button class="size-chip">Free</button>
      </div>
    </div>
    <div class="sidebar-block">
      <p class="sidebar-title">Occasion</p>
      <ul class="sidebar-list">
        <li><a href="#">Everyday Wear</a></li>
        <li><a href="#">Wedding &amp; Bridal</a></li>
        <li><a href="#">Festive</a></li>
        <li><a href="#">Gifting</a></li>
        <li><a href="#">Office Wear</a></li>
      </ul>
    </div>
  </aside>

  <!-- PRODUCTS -->
  <main class="products-section">

    <!-- Featured Banner (new-arrivals style) -->
    <div class="featured-ring-banner scroll-lift">
      <div class="banner-img">
        <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=800&q=80" alt="Statement Rings" />
      </div>
      <div class="featured-ring-text">
        <p>New Drop</p>
        <h3>Statement Ring Edit</h3>
        <a href="#" class="cta-button">Explore Now</a>
      </div>
    </div>

    <!-- Section heading -->
    <div style="margin-bottom:28px;">
      <h2 class="section-title">Our Finger Rings</h2>
      <p class="section-subtitle">Handcrafted in 925 sterling silver</p>
    </div>

    <!-- Product Grid -->
    <div class="products-grid">

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=600&q=80" alt="Twisted Infinity Band" />
          <div class="card-badges"><span class="badge badge-bestseller">Bestseller</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Sterling Silver</p>
          <h3 class="card-name">Twisted Infinity Band</h3>
          <p class="card-meta">925 Silver · Adjustable</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹1,299</span><span class="price-original">₹1,799</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(84)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1561828995-aa79a2db86dd?w=600&q=80" alt="Oxidised Lotus Bloom" />
          <div class="card-badges"><span class="badge badge-new">New</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Oxidised Silver</p>
          <h3 class="card-name">Oxidised Lotus Bloom</h3>
          <p class="card-meta">Oxidised 925 · Size 7–8</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹999</span></div>
            <div class="card-rating"><span class="stars">★★★★☆</span><span class="rating-count">(43)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=600&q=80" alt="Hexagon Statement Ring" />
          <div class="card-badges"><span class="badge badge-sale">20% Off</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Gold Plated</p>
          <h3 class="card-name">Hexagon Statement Ring</h3>
          <p class="card-meta">Gold-Plated 925 · Size 8</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹1,599</span><span class="price-original">₹1,999</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(62)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=600&q=80" alt="Moonstone Solitaire" />
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Gemstone</p>
          <h3 class="card-name">Moonstone Solitaire</h3>
          <p class="card-meta">Sterling Silver · Moonstone</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹2,499</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(97)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1611591437281-460bfbe1220a?w=600&q=80" alt="Triple Stack Ring Set" />
          <div class="card-badges"><span class="badge badge-bestseller">Bestseller</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Stackable Set</p>
          <h3 class="card-name">Triple Stack Ring Set</h3>
          <p class="card-meta">925 Silver · Set of 3</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹2,199</span><span class="price-original">₹2,799</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(131)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=600&q=80" alt="Filigree Jali Band" />
          <div class="card-badges"><span class="badge badge-new">New</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Bridal</p>
          <h3 class="card-name">Filigree Jali Band</h3>
          <p class="card-meta">Oxidised 925 · Handcrafted</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹3,299</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(56)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1569397288884-4d43d6738fbd?w=600&q=80" alt="Hammered Midi Band" />
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Midi Ring</p>
          <h3 class="card-name">Hammered Midi Band</h3>
          <p class="card-meta">925 Silver · Adjustable</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹749</span></div>
            <div class="card-rating"><span class="stars">★★★★☆</span><span class="rating-count">(29)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1506630448388-4e683c67ddb0?w=600&q=80" alt="Turquoise Boho Ring" />
          <div class="card-badges"><span class="badge badge-sale">15% Off</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Gemstone</p>
          <h3 class="card-name">Turquoise Boho Ring</h3>
          <p class="card-meta">Sterling Silver · Turquoise</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹1,849</span><span class="price-original">₹2,199</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(73)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1573408301185-9519da7036cd?w=600&q=80" alt="Thin Minimal Band" />
          <div class="card-badges"><span class="badge badge-bestseller">Bestseller</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Minimal</p>
          <h3 class="card-name">Thin Minimal Band</h3>
          <p class="card-meta">925 Silver · Everyday Wear</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹599</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(218)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1601121141461-9d6647bef0a0?w=600&q=80" alt="Custom Engraved Band" />
          <div class="card-badges"><span class="badge badge-new">New</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Personalised</p>
          <h3 class="card-name">Custom Engraved Band</h3>
          <p class="card-meta">925 Silver · Customisable</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹1,999</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(41)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1616967167571-64d6c1d9c7ef?w=600&q=80" alt="Wide Tribal Thumb Ring" />
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Thumb Ring</p>
          <h3 class="card-name">Wide Tribal Thumb Ring</h3>
          <p class="card-meta">Oxidised 925 · Adjustable</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹1,149</span><span class="price-original">₹1,399</span></div>
            <div class="card-rating"><span class="stars">★★★★☆</span><span class="rating-count">(37)</span></div>
          </div>
        </div>
      </div>

      <div class="product-card scroll-lift">
        <div class="card-image">
          <img src="https://images.unsplash.com/photo-1598560917807-1bae44bd2be8?w=600&q=80" alt="Rose CZ Cocktail Ring" />
          <div class="card-badges"><span class="badge badge-bestseller">Bestseller</span></div>
          <div class="card-hover-overlay"><div class="hover-actions"><button class="btn-quick-add">Quick Add</button><button class="btn-wishlist-card"><i class="far fa-heart"></i></button></div></div>
        </div>
        <div class="card-body">
          <p class="card-category">Cocktail</p>
          <h3 class="card-name">Rose CZ Cocktail Ring</h3>
          <p class="card-meta">Rose Gold-Plated · CZ Stone</p>
          <div class="card-footer">
            <div class="card-price"><span class="price-current">₹2,799</span></div>
            <div class="card-rating"><span class="stars">★★★★★</span><span class="rating-count">(89)</span></div>
          </div>
        </div>
      </div>

    </div><!-- /products-grid -->

    <!-- Pagination -->
    <div class="pagination">
      <button class="page-btn active">1</button>
      <button class="page-btn">2</button>
      <button class="page-btn">3</button>
      <button class="page-btn">4</button>
      <button class="page-btn"><i class="fas fa-chevron-right"></i></button>
    </div>

  </main>
</div>

<!-- VALUES STRIP — matches homepage exactly -->
<section class="values-section">
  <div class="values-container">
    <div class="values-grid">
      <div class="value-card"><div class="value-icon"><i class="fas fa-certificate"></i></div><h3>Purity Guarantee</h3><p>100% hallmarked 925 sterling silver</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-truck"></i></div><h3>Free Shipping</h3><p>Complimentary on orders above ₹999</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-undo"></i></div><h3>Easy Returns</h3><p>Hassle-free 30-day return policy</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-gift"></i></div><h3>Gift Packaging</h3><p>Complimentary wrapping on all orders</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-certificate"></i></div><h3>Purity Guarantee</h3><p>100% hallmarked 925 sterling silver</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-truck"></i></div><h3>Free Shipping</h3><p>Complimentary on orders above ₹999</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-undo"></i></div><h3>Easy Returns</h3><p>Hassle-free 30-day return policy</p></div>
      <div class="value-card"><div class="value-icon"><i class="fas fa-gift"></i></div><h3>Gift Packaging</h3><p>Complimentary wrapping on all orders</p></div>
    </div>
  </div>
</section>

<script>
  // Nav scroll behaviour
  const nav = document.getElementById('mainNav');
  window.addEventListener('scroll', () => nav.classList.toggle('scrolled', window.scrollY > 40));

  // Filter chips
  document.querySelectorAll('.filter-chip').forEach(chip => {
    chip.addEventListener('click', function() {
      this.closest('.filter-group').querySelectorAll('.filter-chip').forEach(c => c.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Size chips
  document.querySelectorAll('.size-chip').forEach(chip => {
    chip.addEventListener('click', function() {
      document.querySelectorAll('.size-chip').forEach(c => c.classList.remove('active'));
      this.classList.add('active');
    });
  });

  // Scroll reveal
  const observer = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
      if (e.isIntersecting) {
        setTimeout(() => e.target.classList.add('is-visible'), i * 55);
        observer.unobserve(e.target);
      }
    });
  }, { threshold: 0.07 });
  document.querySelectorAll('.scroll-lift').forEach(el => observer.observe(el));

  // Wishlist toggle
  document.querySelectorAll('.btn-wishlist-card').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.stopPropagation();
      const icon = this.querySelector('i');
      icon.classList.toggle('far'); icon.classList.toggle('fas');
      if (icon.classList.contains('fas')) { icon.style.color = 'var(--primary-blue)'; this.style.background = 'var(--secondary-peach)'; this.style.borderColor = 'var(--secondary-peach)'; }
      else { icon.style.color = ''; this.style.background = ''; this.style.borderColor = ''; }
    });
  });

  // Pagination
  document.querySelectorAll('.page-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      document.querySelectorAll('.page-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });
</script>

</body>
</html>