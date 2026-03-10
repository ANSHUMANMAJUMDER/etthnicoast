@extends('frontend.layouts.master')
@section('contents')

<style>
     .women-hero{
      position:relative;
      height:92vh;
      min-height:620px;
      overflow:hidden;
      background:#000;
    }
    .women-hero img{
      position:absolute;
      inset:0;
      width:100%;
      height:100%;
      object-fit:cover;
      object-position:center;
      transform:scale(1.02);
    }
    .women-hero::before{
      content:'';
      position:absolute;
      inset:0;
      background:linear-gradient(135deg, rgba(235,222,212,0.25) 0%, rgba(2,0,13,0.35) 100%);
      z-index:1;
    }
    .women-hero-content{
      position:absolute;
      z-index:2;
      top:50%;
      left:50%;
      transform:translate(-50%,-50%);
      text-align:center;
      width:90%;
      max-width:900px;
      color:var(--white);
    }
    .women-hero-content h1{
      font-size:4.2rem;
      font-weight:300;
      letter-spacing:12px;
      text-transform:uppercase;
      margin-bottom:1.1rem;
    }
    .women-hero-content p{
      font-size:.95rem;
      letter-spacing:4px;
      text-transform:uppercase;
      opacity:.95;
      margin-bottom:2.4rem;
    }
    .cta-button{
      display:inline-block;
      padding:1.1rem 3.2rem;
      background:transparent;
      color:var(--white);
      text-decoration:none;
      letter-spacing:3px;
      font-size:.8rem;
      text-transform:uppercase;
      transition:.35s ease;
      border:1px solid var(--white);
    }
    .cta-button:hover{
      background:var(--white);
      color:var(--primary-blue);
    }

    /* ===== Container / Section Titles ===== */
    .container{
      max-width:1300px;
      margin:0 auto;
      padding:0 2rem;
    }
    .section{
      padding:4.5rem 0;
    }
    .section-title-wrap{
      text-align:center;
      margin-bottom:2.2rem;
    }
    .section-title{
      font-size:2.2rem;
      font-weight:300;
      letter-spacing:4px;
      color:var(--primary-blue);
      margin-bottom:.5rem;
    }
    .section-subtitle{
      font-size:.85rem;
      letter-spacing:2px;
      text-transform:uppercase;
      opacity:.7;
    }

    /* ===== Category Grid (FIXED ASPECT RATIO) ===== */
    .category-grid{
      display:grid;
      grid-template-columns:repeat(4, minmax(0,1fr));
      gap:1.25rem;
    }
    .cat-card{
      position:relative;
      overflow:hidden;
      border-radius:2px;
      background:#111;
      aspect-ratio:3/4;          /* ✅ consistent */
      box-shadow:0 18px 40px rgba(0,0,0,.14);
    }
    .cat-card img{
      width:100%;
      height:100%;
      object-fit:cover;
      object-position:center;
      display:block;
      transition:transform .5s ease;
    }
    .cat-card:hover img{ transform:scale(1.05); }
    .cat-card::before{
      content:'';
      position:absolute;
      inset:0;
      background:linear-gradient(180deg, rgba(0,0,0,0.05) 0%, rgba(0,0,0,0.65) 100%);
      z-index:1;
    }
    .cat-overlay{
      position:absolute;
      left:0;
      right:0;
      bottom:0;
      z-index:2;
      padding:1.6rem 1.4rem;
      color:#fff;
      text-align:left;
    }
    .cat-overlay h3{
      font-size:1.35rem;
      font-weight:400;
      letter-spacing:1px;
      margin-bottom:.35rem;
    }
    .cat-overlay span{
      font-size:.78rem;
      letter-spacing:2px;
      text-transform:uppercase;
      opacity:.9;
    }
    .cat-overlay a{
      display:inline-flex;
      margin-top:1rem;
      gap:.6rem;
      align-items:center;
      color:#fff;
      text-decoration:none;
      font-size:.75rem;
      letter-spacing:2px;
      text-transform:uppercase;
      padding:.7rem 1.1rem;
      border:1px solid rgba(255,255,255,.75);
      transition:.3s ease;
      background:transparent;
    }
    .cat-overlay a:hover{
      background:#fff;
      color:var(--primary-blue);
      border-color:#fff;
    }

    /* ===== Products Grid (CONSISTENT IMAGES) ===== */
    .product-grid{
      display:grid;
      grid-template-columns:repeat(4, minmax(0,1fr));
      gap:1.25rem;
    }
    .product-card{
      background:#fff;
      border:1px solid rgba(2,0,13,.08);
      border-radius:2px;
      overflow:hidden;
      transition:.25s ease;
    }
    .product-card:hover{
      transform:translateY(-4px);
      box-shadow:0 20px 45px rgba(0,0,0,.12);
    }
    .product-img{
      width:100%;
      aspect-ratio:4/5;      /* ✅ consistent */
      height:auto;
      object-fit:cover;
      object-position:center;
      display:block;
      background:#f2f2f2;
    }
    .product-body{
      padding:1.2rem 1.1rem 1.3rem;
    }
    .product-body h4{
      font-size:1.05rem;
      font-weight:500;
      letter-spacing:.6px;
      margin-bottom:.35rem;
      color:var(--primary-blue);
    }
    .product-meta{
      font-size:.75rem;
      letter-spacing:2px;
      text-transform:uppercase;
      opacity:.7;
      margin-bottom:.9rem;
    }
    .product-footer{
      display:flex;
      align-items:center;
      justify-content:space-between;
      gap:.75rem;
    }
    .price{
      font-weight:700;
      letter-spacing:1px;
      font-size:.95rem;
      color:var(--dark-black);
    }
    .btn{
      appearance:none;
      border:none;
      cursor:pointer;
      padding:.75rem 1rem;
      font-size:.72rem;
      letter-spacing:2px;
      text-transform:uppercase;
      background:var(--primary-blue);
      color:#fff;
      transition:.25s ease;
    }
    .btn:hover{ background:#050f21; }

    /* ===== Banner ===== */
    .women-banner{
      background:linear-gradient(135deg, #f8f3ec 0%, #fdf9f5 100%);
      border-top:1px solid rgba(2,0,13,.06);
      border-bottom:1px solid rgba(2,0,13,.06);
    }
    .banner-inner{
      display:grid;
      grid-template-columns:1.1fr .9fr;
      gap:2rem;
      align-items:center;
      padding:3rem 0;
    }
    .banner-inner h2{
      font-size:2.3rem;
      font-weight:300;
      letter-spacing:3px;
      color:var(--primary-blue);
      margin-bottom:.7rem;
    }
    .banner-inner p{
      opacity:.8;
      letter-spacing:1px;
      line-height:1.7;
      margin-bottom:1.2rem;
    }
    .banner-img{
      border-radius:2px;
      overflow:hidden;
      aspect-ratio:4/3;
      box-shadow:0 18px 45px rgba(0,0,0,.12);
    }
    .banner-img img{
      width:100%;
      height:100%;
      object-fit:cover;
      display:block;
    }

    /* ============================================================
       RESPONSIVE
       ============================================================ */
    @media (max-width: 1024px){
      .category-grid, .product-grid{ grid-template-columns:repeat(2, minmax(0,1fr)); }
      .banner-inner{ grid-template-columns:1fr; }
      .women-hero-content h1{ font-size:3rem; letter-spacing:8px; }
    }

   @media (max-width: 480px){
      .women-hero{ height:78vh; }
      .women-hero-content h1{ font-size:1.55rem; letter-spacing:3px; }
      .container{ padding:0 1.15rem; }
    }
</style>
 <!-- HERO -->
  <section class="women-hero">
    <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=2000&q=80" alt="Women Hero">
    <div class="women-hero-content">
      <h1>FOR HER</h1>
      <p>Elegant. Timeless. Silver.</p>
      <a class="cta-button" href="#women-products">Explore Women Collection</a>
    </div>
  </section>

  <!-- CATEGORIES -->
  <section class="section" id="women-categories">
    <div class="container">
      <div class="section-title-wrap">
        <h2 class="section-title">Women Essentials</h2>
        <div class="section-subtitle">Everyday elegance, refined</div>
      </div>

      <div class="category-grid">
        <div class="cat-card">
          <img src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1200&q=80" alt="Earrings">
          <div class="cat-overlay">
            <h3>Earrings</h3>
            <span>Delicate shine</span><br />
            <a href="#women-products"><span>Shop Now</span> <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="cat-card">
          <img src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1200&q=80" alt="Necklaces">
          <div class="cat-overlay">
            <h3>Necklaces</h3>
            <span>Layer & glow</span><br />
            <a href="#women-products"><span>Shop Now</span> <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="cat-card">
          <img src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=1200&q=80" alt="Rings">
          <div class="cat-overlay">
            <h3>Rings</h3>
            <span>Signature style</span><br />
            <a href="#women-products"><span>Shop Now</span> <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>

        <div class="cat-card">
          <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1200&q=80" alt="Bracelets">
          <div class="cat-overlay">
            <h3>Bracelets</h3>
            <span>Chic essentials</span><br />
            <a href="#women-products"><span>Shop Now</span> <i class="fa-solid fa-arrow-right"></i></a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- BANNER -->
  <section class="women-banner">
    <div class="container">
      <div class="banner-inner">
        <div>
          <h2>Designed for Her</h2>
          <p>
            Premium silver jewelry with soft elegance and modern detail.
            From everyday earrings to statement necklaces — curated to elevate every look.
          </p>
          <a class="cta-button" href="#women-products">Shop Women</a>
        </div>
        <div class="banner-img">
          <img src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1600&q=80" alt="Women banner">
        </div>
      </div>
    </div>
  </section>

  <!-- PRODUCTS -->
  <section class="section" id="women-products">
    <div class="container">
      <div class="section-title-wrap">
        <h2 class="section-title">Featured for Her</h2>
        <div class="section-subtitle">Popular picks from the women collection</div>
      </div>

      <div class="product-grid">
        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1599643478518-a784e5dc4c8f?w=1200&q=80" alt="Product 1">
          <div class="product-body">
            <h4>Elegant Earrings</h4>
            <div class="product-meta">925 Silver • Women</div>
            <div class="product-footer">
              <div class="price">₹1,799</div>
              <button class="btn">Add to Bag</button>
            </div>
          </div>
        </div>

        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1515562141207-7a88fb7ce338?w=1200&q=80" alt="Product 2">
          <div class="product-body">
            <h4>Layered Necklace</h4>
            <div class="product-meta">925 Silver • Women</div>
            <div class="product-footer">
              <div class="price">₹3,299</div>
              <button class="btn">Add to Bag</button>
            </div>
          </div>
        </div>

        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1535632066927-ab7c9ab60908?w=1200&q=80" alt="Product 3">
          <div class="product-body">
            <h4>Minimal Ring</h4>
            <div class="product-meta">925 Silver • Women</div>
            <div class="product-footer">
              <div class="price">₹1,499</div>
              <button class="btn">Add to Bag</button>
            </div>
          </div>
        </div>

        <div class="product-card">
          <img class="product-img" src="https://images.unsplash.com/photo-1611652022419-a9419f74343d?w=1200&q=80" alt="Product 4">
          <div class="product-body">
            <h4>Classic Bracelet</h4>
            <div class="product-meta">925 Silver • Women</div>
            <div class="product-footer">
              <div class="price">₹2,199</div>
              <button class="btn">Add to Bag</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  @endsection