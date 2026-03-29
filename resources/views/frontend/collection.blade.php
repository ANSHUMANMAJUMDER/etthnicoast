@extends('frontend.layouts.master')

@section('contents')
<style>
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
    .hero-eyebrow { font-family: var(--font-secondary); font-size: 0.78rem; letter-spacing: 5px; color: var(--secondary-peach); text-transform: uppercase; margin-bottom: 1.2rem; }
    .hero-title { font-family: var(--font-primary); font-size: clamp(3rem, 7vw, 5.5rem); font-weight: 300; letter-spacing: 12px; color: var(--white); text-transform: uppercase; margin-bottom: 1rem; }
    .hero-sub { font-family: var(--font-primary); font-size: 1.15rem; letter-spacing: 3px; color: rgba(255,255,255,0.85); margin-bottom: 2rem; }
    .cta-button { display: inline-block; padding: 1rem 3rem; background: var(--secondary-peach); color: var(--primary-blue); text-decoration: none; letter-spacing: 2px; font-size: 0.85rem; font-family: var(--font-secondary); text-transform: uppercase; transition: all 0.4s ease; border: 2px solid var(--secondary-peach); }
    .cta-button:hover { background: transparent; color: var(--secondary-peach); }

    .breadcrumb { display: flex; align-items: center; gap: 10px; padding: 14px 4rem; background: var(--white); border-bottom: 1px solid rgba(7,32,63,0.08); }
    .breadcrumb a, .breadcrumb span { font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(2,0,13,0.5); text-decoration: none; }
    .breadcrumb a:hover { color: var(--primary-blue); }
    .breadcrumb .sep { color: rgba(7,32,63,0.25); }
    .breadcrumb .current { color: var(--primary-blue); font-weight: 700; }

    .filter-section { padding: 22px 4rem; background: var(--white); border-bottom: 1px solid rgba(7,32,63,0.08); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 14px; }
    .filter-group { display: flex; align-items: center; gap: 9px; flex-wrap: wrap; }
    .filter-label { font-family: var(--font-secondary); font-size: 0.68rem; letter-spacing: 2.5px; color: rgba(2,0,13,0.45); text-transform: uppercase; }
    .filter-chip { font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 1.5px; text-transform: uppercase; padding: 7px 18px; border: 1px solid rgba(7,32,63,0.2); background: transparent; color: rgba(2,0,13,0.6); cursor: pointer; transition: all 0.25s ease; text-decoration: none; display: inline-block; }
    .filter-chip:hover, .filter-chip.active { background: var(--primary-blue); color: var(--white); border-color: var(--primary-blue); }
    .sort-select { background: transparent; border: 1px solid rgba(7,32,63,0.2); color: rgba(2,0,13,0.6); font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 1.5px; padding: 7px 14px; cursor: pointer; outline: none; }
    .results-count { font-family: var(--font-secondary); font-size: 0.72rem; letter-spacing: 2px; color: rgba(2,0,13,0.45); text-transform: uppercase; }

    .collection-layout { display: grid; grid-template-columns: 255px 1fr; background: #fafaf8; }
    .sidebar { padding: 36px 28px; background: var(--white); border-right: 1px solid rgba(7,32,63,0.08); position: sticky; top: 0; align-self: start; }
    .sidebar-block { margin-bottom: 30px; }
    .sidebar-title { font-family: var(--font-secondary); font-size: 0.65rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); font-weight: 700; margin-bottom: 14px; padding-bottom: 10px; border-bottom: 1px solid rgba(7,32,63,0.1); }
    .sidebar-list { list-style: none; display: flex; flex-direction: column; gap: 9px; }
    .sidebar-list li a { font-family: var(--font-secondary); font-size: 0.85rem; color: rgba(2,0,13,0.6); text-decoration: none; display: flex; justify-content: space-between; transition: color 0.2s; }
    .sidebar-list li a:hover, .sidebar-list li a.active { color: var(--primary-blue); }
    .sidebar-list li a span { color: rgba(7,32,63,0.35); font-size: 0.75rem; }
    .price-range-labels { display: flex; justify-content: space-between; margin-top: 8px; }
    .price-range-labels span { font-family: var(--font-secondary); font-size: 0.72rem; color: rgba(2,0,13,0.5); }
    input[type=range] { width: 100%; accent-color: var(--primary-blue); cursor: pointer; }

    .products-section { padding: 36px 40px 80px; }
    .section-title { text-align: center; font-family: var(--font-primary); font-size: 2.5rem; font-weight: 300; letter-spacing: 4px; color: var(--primary-blue); margin-bottom: 0.5rem; }
    .section-subtitle { text-align: center; font-family: var(--font-primary); font-size: 1.2rem; color: var(--dark-black); opacity: 0.7; margin-bottom: 2rem; }
    .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(255px, 1fr)); gap: 22px; }

    .product-card { background: var(--white); overflow: hidden; box-shadow: 0 4px 16px rgba(2,0,13,0.06); transition: transform 0.35s ease, box-shadow 0.35s ease; cursor: pointer; }
    .product-card:hover { transform: translateY(-8px); box-shadow: 0 15px 40px rgba(2,0,13,0.13); }
    .card-image { position: relative; overflow: hidden; aspect-ratio: 3/4; background: var(--light-peach); }
    .card-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.6s ease; }
    .product-card:hover .card-image img { transform: scale(1.08); }
    .card-hover-overlay { position: absolute; inset: 0; background: linear-gradient(180deg, transparent 55%, rgba(7,32,63,0.88) 100%); display: flex; flex-direction: column; justify-content: flex-end; padding: 18px; opacity: 0; transition: opacity 0.3s ease; }
    .product-card:hover .card-hover-overlay { opacity: 1; }
    .hover-actions { display: flex; gap: 8px; }
    .btn-quick-add { flex: 1; padding: 10px; font-family: var(--font-secondary); font-size: 0.68rem; letter-spacing: 2px; text-transform: uppercase; background: var(--secondary-peach); color: var(--primary-blue); border: 2px solid var(--secondary-peach); cursor: pointer; font-weight: 700; transition: all 0.25s; }
    .btn-quick-add:hover { background: transparent; color: var(--secondary-peach); }
    .btn-wishlist-card { width: 40px; height: 40px; background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.3); display: flex; align-items: center; justify-content: center; cursor: pointer; transition: all 0.2s; }
    .btn-wishlist-card i { color: var(--white); font-size: 0.85rem; }
    .btn-wishlist-card:hover { background: var(--secondary-peach); border-color: var(--secondary-peach); }
    .btn-wishlist-card:hover i { color: var(--primary-blue); }
    .card-badges { position: absolute; top: 12px; left: 12px; display: flex; flex-direction: column; gap: 5px; z-index: 2; }
    .badge { font-family: var(--font-secondary); font-size: 0.6rem; letter-spacing: 1.5px; text-transform: uppercase; padding: 4px 10px; font-weight: 700; }
    .badge-new        { background: var(--primary-blue); color: var(--white); }
    .badge-sale       { background: #c0392b; color: #fff; }
    .badge-bestseller { background: var(--dark-black); color: var(--secondary-peach); }
    .card-body { padding: 16px 18px 20px; border-top: 1px solid rgba(7,32,63,0.06); }
    .card-category { font-family: var(--font-secondary); font-size: 0.62rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(7,32,63,0.45); margin-bottom: 4px; }
    .card-name { font-family: var(--font-primary); font-size: 1.18rem; font-weight: 400; line-height: 1.3; color: var(--primary-blue); margin-bottom: 5px; letter-spacing: 0.5px; }
    .card-meta { font-family: var(--font-secondary); font-size: 0.7rem; color: rgba(2,0,13,0.48); margin-bottom: 12px; }
    .card-footer { display: flex; align-items: center; justify-content: space-between; }
    .card-price { display: flex; align-items: baseline; gap: 7px; }
    .price-current { font-family: var(--font-primary); font-size: 1.2rem; font-weight: 600; color: var(--primary-blue); }
    .price-original { font-family: var(--font-secondary); font-size: 0.78rem; color: rgba(2,0,13,0.38); text-decoration: line-through; }

    .empty-state { text-align: center; padding: 80px 20px; color: rgba(2,0,13,0.4); }
    .empty-state i { font-size: 3rem; margin-bottom: 1rem; display: block; }
    .empty-state p { font-family: var(--font-secondary); font-size: 0.85rem; letter-spacing: 2px; text-transform: uppercase; }

    .values-section { padding: 3.5rem 1.5rem; background: var(--primary-blue); color: var(--white); overflow: hidden; }
    .values-container { max-width: 1200px; margin: 0 auto; }
    .values-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; }
    .value-card { text-align: center; padding: 1rem 0.5rem; }
    .value-icon { width: 55px; height: 55px; margin: 0 auto 1rem; background: var(--secondary-peach); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: var(--primary-blue); font-size: 1.4rem; }
    .value-card h3 { font-family: var(--font-primary); font-size: 1rem; font-weight: 400; letter-spacing: 1.5px; margin-bottom: 0.6rem; color: var(--white); }
    .value-card p { font-family: var(--font-secondary); font-size: 0.85rem; opacity: 0.85; line-height: 1.45; color: var(--white); }

    .scroll-lift { opacity: 0; transform: translateY(28px) scale(0.985); transition: opacity 600ms cubic-bezier(.22,1,.36,1), transform 700ms cubic-bezier(.22,1,.36,1); will-change: transform, opacity; }
    .scroll-lift.is-visible { opacity: 1; transform: translateY(0) scale(1); }

    @media (max-width: 1024px) { .collection-layout { grid-template-columns: 1fr; } .sidebar { display: none; } .filter-section { padding: 18px 1.5rem; } .products-section { padding: 24px 1.5rem 60px; } .breadcrumb { padding: 12px 1.5rem; } .values-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 768px) { .hero-title { font-size: 2.4rem; letter-spacing: 5px; } .products-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; } .values-grid { grid-template-columns: repeat(2, 1fr); gap: 1rem; } }
    @media (max-width: 480px) { .hero-title { font-size: 2rem; letter-spacing: 3px; } .products-grid { grid-template-columns: repeat(2, 1fr); gap: 10px; } }
</style>

<section style="padding-top:155px">

{{-- BREADCRUMB --}}
<div class="breadcrumb">
    <a href="{{ url('/') }}">Home</a>
    @foreach($breadcrumb as $crumb)
        <span class="sep">›</span>
        @if($crumb['url'])
            <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
        @else
            <span class="current">{{ $crumb['label'] }}</span>
        @endif
    @endforeach
</div>

{{-- FILTER BAR --}}
<div class="filter-section">
    <div class="filter-group">
        <span class="filter-label">Filter:</span>

        {{-- FIX 1: $category may be null (all-products page) --}}
        @if($category)
            <a href="{{ route('collection.show', $category->slug) }}"
               class="filter-chip {{ !$subCategory ? 'active' : '' }}">
                All
            </a>
            @foreach($subCategories as $sub)
                <a href="{{ route('collection.show', $sub->slug) }}"
                   class="filter-chip {{ $subCategory && $subCategory->id === $sub->id ? 'active' : '' }}">
                    {{ $sub->name }}
                </a>
            @endforeach
        @else
            <a href="{{ route('collection.show') }}" class="filter-chip active">All</a>
        @endif
    </div>

    <div style="display:flex;align-items:center;gap:16px;flex-wrap:wrap;">
        <span class="results-count">{{ $products->total() }} Products</span>
        <form method="GET" action="{{ request()->url() }}" id="sortForm">
            @if(request('min_price')) <input type="hidden" name="min_price" value="{{ request('min_price') }}"> @endif
            @if(request('max_price')) <input type="hidden" name="max_price" value="{{ request('max_price') }}"> @endif
            <select class="sort-select" name="sort" onchange="document.getElementById('sortForm').submit()">
                <option value="featured"   {{ $sort === 'featured'   ? 'selected' : '' }}>Sort: Featured</option>
                <option value="price_asc"  {{ $sort === 'price_asc'  ? 'selected' : '' }}>Price: Low to High</option>
                <option value="price_desc" {{ $sort === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                <option value="newest"     {{ $sort === 'newest'     ? 'selected' : '' }}>Newest First</option>
            </select>
        </form>
    </div>
</div>

{{-- MAIN LAYOUT --}}
<div class="collection-layout">

    {{-- SIDEBAR --}}
    <aside class="sidebar">

        <div class="sidebar-block">
            <p class="sidebar-title">Collections</p>
            <ul class="sidebar-list">
                {{-- FIX 2: "All" link at top of sidebar --}}
                <li>
                    <a href="{{ route('collection.show') }}"
                       class="{{ !$category ? 'active' : '' }}">
                        All Collections
                    </a>
                </li>
                @foreach($allCategories as $cat)
                    <li>
                        {{-- FIX 3: $category may be null so use optional chaining --}}
                        <a href="{{ route('collection.show', $cat->slug) }}"
                           class="{{ $category && $cat->id === $category->id && !$subCategory ? 'active' : '' }}">
                            {{ $cat->name }}
                            <span>({{ $cat->products_count }})</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- FIX 4: only show sub-category block when a category is resolved --}}
        @if($category && $subCategories->count())
        <div class="sidebar-block">
            <p class="sidebar-title">{{ $category->name }}</p>
            <ul class="sidebar-list">
                <li>
                    <a href="{{ route('collection.show', $category->slug) }}"
                       class="{{ !$subCategory ? 'active' : '' }}">
                        All {{ $category->name }} <span>({{ $products->total() }})</span>
                    </a>
                </li>
                @foreach($subCategories as $sub)
                    <li>
                        <a href="{{ route('collection.show', $sub->slug) }}"
                           class="{{ $subCategory && $subCategory->id === $sub->id ? 'active' : '' }}">
                            {{ $sub->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="sidebar-block">
            <p class="sidebar-title">Price Range</p>
            <form method="GET" action="{{ request()->url() }}" id="priceForm">
                @if(request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                <input type="range"
                       name="max_price"
                       min="{{ (int)$priceMin }}"
                       max="{{ (int)$priceMax }}"
                       value="{{ request('max_price', (int)$priceMax) }}"
                       id="priceRange"
                       onchange="document.getElementById('priceForm').submit()" />
                <div class="price-range-labels">
                    <span>₹{{ number_format($priceMin) }}</span>
                    <span id="priceLabel">₹{{ number_format(request('max_price', $priceMax)) }}</span>
                </div>
            </form>
        </div>

    </aside>

    {{-- PRODUCTS --}}
    <main class="products-section">

        <div style="margin-bottom:28px;">
            <h2 class="section-title">{{ $heroTitle }}</h2>
            <p class="section-subtitle">{{ $heroSubtitle }}</p>
        </div>

        @if($products->count())
            <div class="products-grid">
                @foreach($products as $product)
                    @php
                        $thumb    = $product->images->first()?->image ?? null;
                        $thumbUrl = $thumb
                            ? asset('public/storage/' . $thumb)
                            : 'https://images.unsplash.com/photo-1605100804763-247f67b3557e?w=600&q=80';
                        $isNew   = $product->created_at->diffInDays(now()) <= 30;
                        $hasSale = isset($product->compare_price) && $product->compare_price > $product->base_price;
                    @endphp

                    <a href="{{ route('frontend.product-details', $product->slug ?? $product->id) }}"
                       class="product-card scroll-lift text-decoration-none">

                        <div class="card-image">
                            <img src="{{ $thumbUrl }}" alt="{{ $product->base_name }}" loading="lazy" />

                            <div class="card-badges">
                                @if($isNew)  <span class="badge badge-new">New</span> @endif
                                @if($hasSale)
                                    @php $disc = round((($product->compare_price - $product->base_price) / $product->compare_price) * 100); @endphp
                                    <span class="badge badge-sale">{{ $disc }}% Off</span>
                                @endif
                            </div>

                            <div class="card-hover-overlay">
                                <div class="hover-actions">
                                    <button class="btn-quick-add"
                                            onclick="event.preventDefault(); addToCart({{ $product->id }}, this)">
                                        Quick Add
                                    </button>
                                    <button class="btn-wishlist-card"
                                            onclick="event.preventDefault(); toggleWishlist(this, {{ $product->id }})">
                                        <i class="far fa-heart"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="card-body">
                            {{-- FIX 5: $category may be null — use null-safe fallback --}}
                            <p class="card-category">{{ $product->pearlType?->name ?? ($category?->name ?? 'Jewellery') }}</p>
                            <h3 class="card-name">{{ $product->base_name }}</h3>
                            <p class="card-meta">Code: {{ $product->product_code }}</p>
                            <div class="card-footer">
                                <div class="card-price">
                                    <span class="price-current">₹{{ number_format($product->base_price) }}</span>
                                    @if($hasSale)
                                        <span class="price-original">₹{{ number_format($product->compare_price) }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </a>
                @endforeach
            </div>

            <div style="display:flex;justify-content:center;padding:32px 0 60px;">
                {{ $products->links('vendor.pagination.simple-collection') }}
            </div>

        @else
            <div class="empty-state scroll-lift">
                <i class="fas fa-gem"></i>
                <p>No products found in this collection</p>
                {{-- FIX 6: $category may be null in empty state --}}
                @if($category)
                    <a href="{{ route('collection.show', $category->slug) }}" class="cta-button mt-4">
                        Browse All {{ $category->name }}
                    </a>
                @else
                    <a href="{{ route('collection.show') }}" class="cta-button mt-4">
                        Browse All Collections
                    </a>
                @endif
            </div>
        @endif

    </main>
</div>

{{-- VALUES --}}
<section class="values-section">
    <div class="values-container">
        <div class="values-grid">
            <div class="value-card"><div class="value-icon"><i class="fas fa-certificate"></i></div><h3>Purity Guarantee</h3><p>100% hallmarked 925 sterling silver</p></div>
            <div class="value-card"><div class="value-icon"><i class="fas fa-truck"></i></div><h3>Free Shipping</h3><p>Complimentary on orders above ₹999</p></div>
            <div class="value-card"><div class="value-icon"><i class="fas fa-undo"></i></div><h3>Easy Returns</h3><p>Hassle-free 30-day return policy</p></div>
            <div class="value-card"><div class="value-icon"><i class="fas fa-gift"></i></div><h3>Gift Packaging</h3><p>Complimentary wrapping on all orders</p></div>
        </div>
    </div>
</section>

</section>

<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

// ── Scroll animations ─────────────────────────────────────────────────────
const scrollObserver = new IntersectionObserver((entries) => {
    entries.forEach((e, i) => {
        if (e.isIntersecting) {
            setTimeout(() => e.target.classList.add('is-visible'), i * 55);
            scrollObserver.unobserve(e.target);
        }
    });
}, { threshold: 0.07 });
document.querySelectorAll('.scroll-lift').forEach(el => scrollObserver.observe(el));

// ── Price range ───────────────────────────────────────────────────────────
const rangeInput = document.getElementById('priceRange');
const priceLabel = document.getElementById('priceLabel');
if (rangeInput && priceLabel) {
    rangeInput.addEventListener('input', function () {
        priceLabel.textContent = '₹' + parseInt(this.value).toLocaleString('en-IN');
    });
}

// ── Toast ─────────────────────────────────────────────────────────────────
function showToast(msg) {
    let t = document.getElementById('collectionToast');
    if (!t) {
        t = document.createElement('div');
        t.id = 'collectionToast';
        t.style.cssText = 'position:fixed;right:16px;bottom:16px;background:var(--primary-blue);color:var(--white);padding:12px 16px;font-size:.88rem;font-family:var(--font-secondary);letter-spacing:.5px;box-shadow:0 10px 24px rgba(7,32,63,0.2);transform:translateY(18px);opacity:0;pointer-events:none;transition:.25s ease;z-index:3000;';
        document.body.appendChild(t);
    }
    t.textContent = msg;
    t.style.opacity = '1';
    t.style.transform = 'translateY(0)';
    clearTimeout(t._timer);
    t._timer = setTimeout(() => { t.style.opacity = '0'; t.style.transform = 'translateY(18px)'; }, 3000);
}

// ── Add to cart ───────────────────────────────────────────────────────────
function addToCart(productId, btn) {
    @guest('frontend')
        window.location.href = '{{ route("frontend.login") }}';
        return;
    @endguest

    if (btn) { btn.textContent = '…'; btn.disabled = true; }

    fetch('{{ route("cart.store") }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ product_id: productId, quantity: 1 }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            showToast('Added to cart ✓');
            const cartEl = document.getElementById('cartCount');
            if (cartEl) cartEl.textContent = data.cart_count || '';
        } else {
            showToast(data.message || 'Something went wrong.');
        }
    })
    .catch(() => showToast('Something went wrong.'))
    .finally(() => { if (btn) { btn.textContent = 'Quick Add'; btn.disabled = false; } });
}

// ── Wishlist toggle ───────────────────────────────────────────────────────
function toggleWishlist(btn, productId) {
    @guest('frontend')
        window.location.href = '{{ route("frontend.login") }}';
        return;
    @endguest

    const icon = btn.querySelector('i');

    fetch('{{ route("wishlist.toggle") }}', {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({ product_id: productId }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            if (data.wishlisted) {
                icon.classList.replace('far', 'fas');
                icon.style.color      = 'var(--primary-blue)';
                btn.style.background  = 'var(--secondary-peach)';
                btn.style.borderColor = 'var(--secondary-peach)';
                showToast('Added to wishlist ♡');
            } else {
                icon.classList.replace('fas', 'far');
                icon.style.color      = '';
                btn.style.background  = '';
                btn.style.borderColor = '';
                showToast('Removed from wishlist');
            }
        }
    })
    .catch(() => showToast('Something went wrong.'));
}

document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    navbar.classList.add('Scrolled');
    new MutationObserver(() => {
        if (!navbar.classList.contains('Scrolled')) navbar.classList.add('Scrolled');
    }).observe(navbar, { attributes: true, attributeFilter: ['class'] });
});

document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    if (navbar) {
        navbar.classList.add("scrolled");
    }
});
</script>
<script>
  document.body.classList.add('no-navbar-scroll');
</script>
<script>
  document.body.classList.add('no-navbar-scroll');

  document.addEventListener('DOMContentLoaded', () => {
    const navLogo = document.getElementById('navLogo');
    if (navLogo) {
      navLogo.src = '{{ asset("public/assets/logo_new_1.png") }}';
      navLogo.setAttribute('data-src', '{{ asset("public/assets/logo_new_1.png") }}');
    }
  });
</script>
@endsection