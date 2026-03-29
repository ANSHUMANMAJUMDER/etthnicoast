@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    #navbar { /* always scrolled handled in JS */ }
    a{ text-decoration:none; color:inherit; }
    button{ font-family: inherit; }
    img{ display:block; max-width:100%; }

    .container{ max-width: var(--container); margin: 0 auto; padding: 0 clamp(1rem, 3vw, 3rem); }

    .breadcrumb{ padding: 1.75rem 0 1rem; font-size: .85rem; color: var(--muted); }
    .breadcrumb a{ color: var(--muted); }
    .breadcrumb a:hover{ color: var(--primary-blue); }

    .product-wrap{ display:grid; grid-template-columns: 1.15fr 0.85fr; gap: 2.25rem; align-items:start; padding-bottom: 2.25rem; }

    /* GALLERY */
    .gallery{ display:grid; grid-template-columns: 92px 1fr; gap: 1.25rem; align-items:start; min-width: 0; }
    .thumbs{ display:flex; flex-direction:column; gap: 12px; position: sticky; top: 160px; height: max-content; }
    .thumb{ width: 92px; height: 92px; border: 1px solid var(--border); background:#f7f7f7; cursor:pointer; overflow:hidden; transition: .25s ease; position:relative; }
    .thumb img{ width:100%; height:100%; object-fit:cover; }
    .thumb.active{ border-color: var(--primary-blue); box-shadow: 0 0 0 2px rgba(7,32,63,0.15); }
    .main-media{ border: 1px solid var(--border); background:#f7f7f7; overflow:hidden; position: relative; aspect-ratio: 4/5; }
    .main-media .badge{ position:absolute; top:16px; left:16px; background: var(--primary-blue); color: var(--white); padding: 6px 12px; font-size:.7rem; letter-spacing:1px; text-transform:uppercase; z-index:2; }
    .main-media img{ width:100%; height: 100%; object-fit: cover; transition: transform .5s ease; }
    .main-media:hover img{ transform: scale(1.03); }

    /* INFO */
    .info{ position: sticky; top: 150px; height: max-content; border-left: 1px solid rgba(7,32,63,0.06); padding-left: 1.25rem; }
    .title{ font-family: var(--font-primary); font-size: 2rem; font-weight: 600; color: var(--primary-blue); letter-spacing: 1px; line-height: 1.15; margin-bottom: .75rem; }
    .meta-row{ display:flex; align-items:center; justify-content: space-between; gap: 1rem; margin-bottom: 1rem; }
    .rating{ display:flex; align-items:center; gap: 8px; font-size: .9rem; color: var(--muted); }
    .rating .stars{ color:#f39c12; }
    .pill{ display:inline-flex; align-items:center; gap: 8px; padding: 6px 10px; border: 1px solid var(--border); background: var(--white); font-size: .8rem; color: var(--primary-blue); letter-spacing: .5px; white-space: nowrap; }
    .pill strong{ color: var(--primary-blue); }
    .price-area{ display:flex; align-items:baseline; flex-wrap: wrap; gap: 10px; margin-bottom: 10px; }
    .price{ font-size: 1.6rem; font-weight: 800; color: var(--primary-blue); }
    .price.strikethrough{ text-decoration: line-through; color: rgba(2,0,13,0.45); font-size: 1.4rem; }
    .price.discounted{ color: #d32f2f; }
    .subtext{ font-size: .85rem; color: var(--muted); margin-bottom: 14px; }
    .offer-box{ border: 1px dashed rgba(7,32,63,0.25); padding: 12px; margin-bottom: 14px; background: linear-gradient(135deg,rgba(255,248,240,0.9),rgba(235,222,212,0.6)); border-radius: 8px; }
    .offer-box .row{ display:flex; justify-content: space-between; gap: 10px; flex-wrap: wrap; align-items:center; font-size: .85rem; color: rgba(2,0,13,0.72); }
    .coupon{ display:inline-flex; gap: 8px; align-items:center; background: var(--white); border: 1px solid var(--border); padding: 6px 10px; font-weight: 700; color: var(--primary-blue); letter-spacing: .8px; text-transform: uppercase; font-size: .78rem; cursor: pointer; transition: all 0.3s ease; }
    .coupon:hover{ background: var(--primary-blue); color: var(--white); }
    .coupon.applied{ background: #4caf50; color: var(--white); border-color: #4caf50; }

    .option-block{ padding: 14px 0; border-top: 1px solid rgba(7,32,63,0.08); }
    .opt-head{ display:flex; justify-content: space-between; align-items:center; gap: 1rem; margin-bottom: 10px; }
    .opt-head .label{ font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; color: rgba(2,0,13,0.75); font-weight: 700; }
    .opt-head .hint{ font-size: .8rem; color: rgba(2,0,13,0.55); }

    /* Finish chips */
    .chips{ display:flex; gap: 10px; flex-wrap: wrap; }
    .chip{ border: 1px solid rgba(7,32,63,0.22); background: var(--white); padding: 10px 12px; cursor:pointer; font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; transition: .25s ease; min-width: 98px; text-align:center; }
    .chip.active{ background: var(--secondary-grey); color: #f8e3d2; border-color: var(--secondary-grey); }
    .chip:hover:not(.active){ background: rgba(7,32,63,0.04); }

    /* Polish swatches */
    .swatches{ display:flex; gap: 10px; flex-wrap: wrap; align-items:center; }
    .swatch{ width: 28px; height: 28px; border-radius: 999px; border: 2px solid transparent; cursor:pointer; position: relative; transition: .2s ease; flex-shrink:0; }
    .swatch.active{ outline: 2px solid var(--primary-blue); outline-offset: 2px; }
    .swatch:hover:not(.active){ outline: 1px solid rgba(7,32,63,0.4); outline-offset: 2px; }
    .swatch-label{ font-size:.72rem; color: rgba(2,0,13,0.6); margin-top: 6px; text-align:center; letter-spacing:.5px; }

    /* Type chips */
    .size-grid{ display:flex; gap: 10px; flex-wrap: wrap; }
    .size{ min-width: 64px; padding: 10px 10px; border: 1px solid rgba(7,32,63,0.22); background: var(--white); cursor:pointer; font-size: .85rem; transition: .25s ease; text-align:center; }
    .size.active{ border-color: var(--primary-blue); box-shadow: 0 0 0 2px rgba(7,32,63,0.12); }

    .cta-row{ display:grid; grid-template-columns: 1fr 1fr 48px 48px; gap: 10px; margin-top: 12px; }
    .btn-primary{ padding: .95rem 1rem; border: 1px solid var(--primary-blue); background: var(--primary-blue); color: var(--white); cursor:pointer; font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; transition: .25s ease; }
    .btn-primary:hover{ filter: brightness(0.95); }
    .btn-primary.in-cart{ background: #c0392b; border-color: #c0392b; }
    .btn-secondary{ padding: .95rem 1rem; border: 1px solid var(--primary-blue); background: var(--white); color: var(--primary-blue); cursor:pointer; font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; transition: .25s ease; }
    .btn-secondary:hover{ background: var(--primary-blue); color: var(--white); }
    .icon-btn{ border: 1px solid rgba(7,32,63,0.22); background: var(--white); cursor:pointer; font-size: 1rem; transition: .25s ease; display:flex; align-items:center; justify-content:center; }
    .icon-btn:hover{ border-color: var(--primary-blue); color: var(--primary-blue); }


    .pin-row{ display:flex; gap: 10px; margin-top: 10px; align-items:center; }
    .pin-row input{ flex:1; padding: 10px 12px; border: 1px solid rgba(7,32,63,0.22); font-size: .85rem; outline:none; }
    .pin-row button{ padding: 10px 14px; border: 1px solid var(--primary-blue); background: var(--primary-blue); color: var(--white); cursor:pointer; font-size: .82rem; letter-spacing: 1px; text-transform: uppercase; }
    .pin-status{ margin-top: 8px; font-size: .82rem; color: rgba(2,0,13,0.7); }

    .usp-row{ display:grid; grid-template-columns: 1fr; gap: 10px; margin-top: 12px; }
    .usp{ border: 1px solid rgba(7,32,63,0.1); padding: 10px 12px; display:flex; gap: 10px; align-items:flex-start; background: rgba(235,222,212,0.18); font-size: .82rem; color: rgba(2,0,13,0.75); }
    .usp i{ color: var(--primary-blue); margin-top: 2px; }

    .accordion{ margin-top: 14px; border-top: 1px solid rgba(7,32,63,0.08); }
    .acc-item{ border-bottom: 1px solid rgba(7,32,63,0.08); }
    .acc-btn{ width:100%; padding: 14px 0; background: transparent; border:none; cursor:pointer; display:flex; justify-content: space-between; align-items:center; gap: 10px; text-align:left; }
    .acc-btn .t{ font-size: .9rem; letter-spacing: 1px; text-transform: uppercase; color: rgba(2,0,13,0.85); font-weight: 700; }
    .acc-btn i{ transition: transform .25s ease; color: var(--primary-blue); }
    .acc-item.active .acc-btn i{ transform: rotate(180deg); }
    .acc-body{ display:none; padding: 0 0 14px; color: rgba(2,0,13,0.72); font-size: .9rem; line-height: 1.6; }
    .acc-item.active .acc-body{ display:block; }

    /* Complete the look */
    .section{ padding: 2.25rem 0; }
    .section-title{ text-align:center; font-family: var(--font-primary); color: var(--primary-blue); font-size: 1.6rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.25rem; font-weight: 500; }
    .look-wrap{ background: rgba(235,222,212,0.6); border: 1px solid rgba(7,32,63,0.08); padding: 1.5rem; }
    .look-grid{ display:grid; grid-template-columns: 1fr auto 1fr auto 1fr; gap: 1.25rem; align-items:center; max-width: 1100px; margin: 0 auto; }
    .look-card{ border: 1px solid rgba(7,32,63,0.12); background: var(--white); overflow:hidden; }
    .look-img{ aspect-ratio: 4/5; background:#f7f7f7; }
    .look-img img{ width:100%; height:100%; object-fit:cover; }
    .look-bottom{ padding: 10px 12px; display:flex; justify-content: space-between; align-items:center; gap: 10px; font-size: .9rem; }
    .look-plus{ display:flex; justify-content:center; align-items:center; font-size: 1.25rem; color: var(--primary-blue); font-weight: 800; }
    .buy-all{ max-width: 1100px; margin: 1.25rem auto 0; display:flex; justify-content:center; gap: 12px; flex-wrap: wrap; align-items:center; }
    .buy-all .label{ font-size:.85rem; letter-spacing: 1px; text-transform: uppercase; color: rgba(2,0,13,0.75); font-weight: 700; }

    /* Similar */
    .similar-grid{ display:grid; grid-template-columns: repeat(5, minmax(0,1fr)); gap: 1.25rem; }
    .mini-card{ border: 1px solid rgba(7,32,63,0.1); background: var(--white); overflow:hidden; cursor:pointer; transition: .25s ease; }
    .mini-card:hover{ transform: translateY(-4px); box-shadow: var(--shadow); }
    .mini-img{ height: 220px; background:#f7f7f7; }
    .mini-img img{ width:100%; height:100%; object-fit:cover; }
    .mini-info{ padding: 10px 12px; display:flex; justify-content: space-between; gap: 10px; align-items:center; }
    .mini-name{ font-family: var(--font-primary); color: var(--primary-blue); font-size: 1rem; line-height: 1.15; }
    .mini-price{ font-weight: 800; color: var(--primary-blue); font-size: .95rem; white-space: nowrap; }

    /* Reviews */
    .reviews-wrap{ max-width: 1100px; margin: 0 auto; border-top: 1px solid rgba(7,32,63,0.08); padding-top: 1.75rem; }
    .review-head{ display:flex; justify-content: space-between; align-items:flex-start; gap: 1rem; flex-wrap: wrap; margin-bottom: 1.25rem; }
    .review-score{ display:flex; gap: 14px; align-items:center; }
    .score{ font-size: 2.1rem; font-weight: 900; color: var(--primary-blue); line-height: 1; }
    .score-meta{ color: rgba(2,0,13,0.7); font-size: .9rem; }
    .review-btn{ padding: .8rem 1rem; border: 1px solid var(--primary-blue); background: transparent; color: var(--primary-blue); cursor:pointer; letter-spacing:1px; text-transform: uppercase; font-size: .85rem; transition: .25s ease; }
    .review-btn:hover{ background: var(--primary-blue); color: var(--white); }
    .review-list{ display:grid; grid-template-columns: repeat(2, minmax(0,1fr)); gap: 1.25rem; }
    .review-card{ border: 1px solid rgba(7,32,63,0.1); padding: 14px; background: var(--white); }
    .review-top{ display:flex; justify-content: space-between; gap: 10px; margin-bottom: 10px; align-items:center; }
    .review-name{ font-weight: 800; color: rgba(2,0,13,0.8); font-size: .92rem; }
    .review-date{ font-size: .82rem; color: rgba(2,0,13,0.55); }
    .review-stars{ color:#f39c12; font-size: .9rem; margin-bottom: 8px; }
    .review-text{ color: rgba(2,0,13,0.72); font-size: .92rem; line-height: 1.55; }

    /* Rating icons */
    .rating-icons i{ color: #ddd; }
    .rating-icons i.active{ color: #f39c12; }
    .rating-icons span{ margin-left: 6px; font-size: 13px; }

    /* Modal */
    .modal{ position: fixed; inset: 0; display: none; align-items: center; justify-content: center; padding: 16px; z-index: 10000; }
    .modal.active{ display:flex; }
    .modal .backdrop{ position:absolute; inset:0; background: rgba(2,0,13,0.55); }
    .modal-card{ position: relative; width: min(720px, 100%); background: var(--white); border: 1px solid rgba(7,32,63,0.12); box-shadow: 0 20px 50px rgba(7,32,63,0.18); overflow: hidden; }
    .modal-head{ padding: 14px 16px; border-bottom: 1px solid rgba(7,32,63,0.08); display:flex; align-items:center; justify-content: space-between; gap: 10px; background: rgba(235,222,212,0.35); }
    .modal-title{ font-family: var(--font-primary); font-weight: 700; color: var(--primary-blue); letter-spacing: 1px; text-transform: uppercase; font-size: 1rem; }
    .modal-close{ width: 40px; height: 40px; border: 1px solid rgba(7,32,63,0.18); background: var(--white); cursor:pointer; display:flex; align-items:center; justify-content:center; transition: .2s ease; }
    .modal-close:hover{ border-color: var(--primary-blue); color: var(--primary-blue); }
    .modal-body{ padding: 16px; }
    .form-grid{ display:grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    .field{ display:flex; flex-direction:column; gap: 6px; }
    .field.full{ grid-column: 1 / -1; }
    .field label{ font-size: .82rem; letter-spacing: 1px; text-transform: uppercase; color: rgba(2,0,13,0.75); font-weight: 700; }
    .field input, .field textarea{ border: 1px solid rgba(7,32,63,0.22); padding: 10px 12px; font-size: .9rem; outline: none; background: var(--white); }
    .field textarea{ resize: vertical; min-height: 110px; line-height: 1.5; }
    .error-text{ font-size: .85rem; color: #e74c3c; display:none; }
    .error-text.show{ display:block; }
    .rating-picker{ display:flex; align-items:center; gap: 10px; flex-wrap: wrap; padding: 10px 0 0; }
    .rating-picker .label{ font-size: .82rem; letter-spacing: 1px; text-transform: uppercase; color: rgba(2,0,13,0.75); font-weight: 700; margin-right: 6px; }
    .stars-input{ display:flex; gap: 6px; align-items:center; user-select:none; }
    .star-btn{ width: 40px; height: 40px; border: 1px solid rgba(7,32,63,0.18); background: var(--white); cursor:pointer; display:flex; align-items:center; justify-content:center; transition: .2s ease; color: rgba(2,0,13,0.35); font-size: 1.05rem; }
    .star-btn:hover{ border-color: var(--primary-blue); }
    .star-btn.active{ color: #f39c12; border-color: rgba(243,156,18,0.45); box-shadow: 0 0 0 2px rgba(243,156,18,0.12); }
    .rating-value{ font-weight: 800; color: var(--primary-blue); font-size: .95rem; letter-spacing: .5px; }
    .modal-actions{ padding: 14px 16px; border-top: 1px solid rgba(7,32,63,0.08); display:flex; justify-content: flex-end; gap: 10px; background: rgba(235,222,212,0.15); flex-wrap: wrap; }
    .btn-ghost{ padding: .85rem 1rem; border: 1px solid rgba(7,32,63,0.22); background: var(--white); cursor:pointer; font-size: .85rem; letter-spacing: 1px; text-transform: uppercase; transition: .25s ease; color: rgba(2,0,13,0.8); }
    .btn-ghost:hover{ border-color: var(--primary-blue); color: var(--primary-blue); }

    .toast{ position: fixed; right: 16px; bottom: 16px; background: var(--primary-blue); color: var(--white); padding: 12px 14px; font-size: .9rem; letter-spacing: .5px; box-shadow: 0 12px 25px rgba(7,32,63,0.25); transform: translateY(18px); opacity: 0; pointer-events:none; transition: .25s ease; z-index: 3000; }
    .toast.show{ opacity: 1; transform: translateY(0); }

    .sticky-cta{ display:none; position: fixed; left:0; right:0; bottom:0; background: var(--white); border-top: 1px solid rgba(7,32,63,0.12); padding: 10px 12px; z-index: 1200; }
    .sticky-cta .row{ max-width: var(--container); margin: 0 auto; display:flex; gap: 10px; align-items:center; padding: 0 clamp(1rem, 3vw, 3rem); }
    .sticky-cta .mini{ flex:1; min-width:0; }
    .sticky-cta .mini .n{ font-family: var(--font-primary); color: var(--primary-blue); font-weight: 600; font-size: 1rem; white-space: nowrap; overflow:hidden; text-overflow: ellipsis; }
    .sticky-cta .mini .p{ font-weight: 900; color: var(--primary-blue); font-size: 1.05rem; }

    @media (max-width: 1200px){ .similar-grid{ grid-template-columns: repeat(4, minmax(0,1fr)); } }
    @media (max-width: 992px){
        .product-wrap{ grid-template-columns: 1fr; }
        .info{ position: static; border-left: none; padding-left: 0; }
        .thumbs{ position: static; flex-direction: row; overflow-x: auto; padding-bottom: 6px; }
        .gallery{ grid-template-columns: 1fr; }
        .thumb{ width: 84px; height: 84px; flex: 0 0 auto; }
        .similar-grid{ grid-template-columns: repeat(3, minmax(0,1fr)); }
        .review-list{ grid-template-columns: 1fr; }
        .sticky-cta{ display:block; }
        .form-grid{ grid-template-columns: 1fr; }
        .look-grid{ grid-template-columns: 1fr auto 1fr auto 1fr; gap: 0.75rem; }
    }
    @media (max-width: 768px){
        .look-grid{ grid-template-columns: 1fr; }
        .look-plus{ display:none; }
        .similar-grid{ grid-template-columns: repeat(2, minmax(0,1fr)); }
        .usp-row{ grid-template-columns: 1fr; }
    }
    @media (max-width: 480px){
        .title{ font-size: 1.6rem; }
        .similar-grid{ gap: .9rem; }
        .mini-img{ height: 180px; }
        .cta-row{ grid-template-columns: 1fr 1fr; }
        .cta-row .btn-primary, .cta-row .btn-secondary{ grid-column: 1 / -1; }
    }
</style>
@endpush

{{-- ══════════════════════════════════════════════
     Prepare data at top for use in JS below
══════════════════════════════════════════════ --}}
@php
    use App\Models\Wishlist;
    $reviews      = $product->reviews;
    $totalReviews = $reviews->count();
    $avgRating    = $totalReviews > 0 ? round($reviews->avg('rating'), 1) : 0;

    // Group variants by finish name for the Finish chips
    $finishes = $product->variants->pluck('finish')->unique()->filter()->values();

    // Polish types → swatches (polish has name + color_code)
    $polishes = $product->variants->pluck('polish')->unique('id')->filter()->values();

    // Main image fallback
    $mainImageUrl = $product->main_image
        ?? ($product->images->first() ? asset('public/storage/' . $product->images->first()->image) : 'https://via.placeholder.com/600x750?text=No+Image');
@endphp

<div class="overlay" id="overlay"></div>

<main class="container" style="padding-top: 150px">

    {{-- BREADCRUMB --}}
    <div class="breadcrumb">
        <a href="/">Home</a> /
        <a href="{{ route('collection.show') }}">Shop</a> /
        <strong>{{ $product->base_name }}</strong>
    </div>

    {{-- ══ TOP SECTION ══ --}}
    <section class="product-wrap">

        {{-- LEFT: Gallery --}}
        <div class="gallery">
            <div class="thumbs" id="thumbs">
                @foreach($product->images as $index => $image)
                    <div class="thumb {{ $index === 0 ? 'active' : '' }}"
                         data-src="{{ asset('public/storage/' . $image->image) }}">
                        <img src="{{ asset('public/storage/' . $image->image) }}"
                             alt="View {{ $index + 1 }}">
                    </div>
                @endforeach
            </div>

            <div class="main-media">
                @if($product->created_at->diffInDays(now()) <= 30)
                    <div class="badge">New</div>
                @endif
                <img id="mainImage" src="{{ $mainImageUrl }}" alt="{{ $product->base_name }}" />
            </div>
        </div>

        {{-- RIGHT: Info --}}
        <aside class="info">
            <h1 class="title">{{ $product->base_name }}</h1>

            <div class="meta-row">
                <div class="rating">
                    <div class="rating-icons">
                        @for($i = 1; $i <= 5; $i++)
                            <i class="fa fa-star {{ $i <= round($avgRating) ? 'active' : '' }}"></i>
                        @endfor
                        <span>{{ $avgRating > 0 ? $avgRating : 'No ratings' }}</span>
                    </div>
                    <span>({{ $totalReviews }} {{ Str::plural('review', $totalReviews) }})</span>
                </div>
                <div class="pill"><i class="fa-solid fa-truck"></i> <strong>Free Shipping</strong></div>
            </div>

            {{-- Price --}}
            <div class="price-area">
                <div class="price" id="productPrice">₹{{ number_format($product->base_price) }}</div>
                <div class="price discounted" id="discountedPrice" style="display:none;"></div>
                @if(isset($product->compare_price) && $product->compare_price > $product->base_price)
                    @php $disc = round((($product->compare_price - $product->base_price) / $product->compare_price) * 100); @endphp
                    <span class="discount">{{ $disc }}% OFF</span>
                @endif
            </div>
            <div class="subtext">Inclusive of all taxes</div>

            {{-- Coupon --}}
            <div class="offer-box">
                <div class="row">
                    <div><strong>Flat 10% Off</strong> + prepaid discount</div>
                    <button class="coupon" id="couponBtn" type="button">
                        <i class="fa-solid fa-tag"></i> ETTH10
                    </button>
                </div>
            </div>

            {{-- ── FINISH (from variants) ── --}}
            @if($finishes->count())
            <div class="option-block">
                <div class="opt-head">
                    <div class="label">Finish</div>
                    <div class="hint" id="finishHint">Select a finish</div>
                </div>
                <div class="chips" id="metalChips">
                    @foreach($finishes as $index => $finish)
                        <button class="chip {{ $index === 0 ? 'active' : '' }}"
                                type="button"
                                data-finish="{{ $finish }}">
                            {{ $finish }}
                        </button>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- ── AVAILABLE IN — Polish swatches (color_code from polish model) ── --}}
            @if($polishes->count())
            <div class="option-block">
                <div class="opt-head">
                    <div class="label">Available In</div>
                    <div class="hint" id="polishHint">-</div>
                </div>
                <div class="swatches" id="swatches">
                    @foreach($polishes as $index => $polish)
                        <div class="swatch {{ $index === 0 ? 'active' : '' }}"
                             data-polish-id="{{ $polish->id }}"
                             data-polish-name="{{ $polish->name }}"
                             style="background: {{ $polish->color_code ?? '#ccc' }};"
                             title="{{ $polish->name }}">
                        </div>
                    @endforeach
                </div>
                <div class="swatch-label" id="polishName">
                    {{ $polishes->first()?->name ?? '' }}
                </div>
            </div>
            @endif

            {{-- ── SELECT TYPE (Single / Pair) ── --}}
            <div class="option-block">
                <div class="opt-head">
                    <div class="label">Select Type</div>
                </div>
                <div class="chips" id="typeChips">
                    <button class="chip active" type="button" data-type="single">Single</button>
                    <button class="chip" type="button" data-type="pair">Pair</button>
                </div>
            </div>

            {{-- ── SIZE ── --}}
            <div class="option-block">
                <div class="opt-head">
                    <div class="label">Size</div>
                </div>
                <div class="size-grid" id="sizes">
                    @php $sizes = ['6','7','8','9','Free']; @endphp
                    @foreach($sizes as $index => $sz)
                        <button class="size {{ $index === 0 ? 'active' : '' }}"
                                type="button" data-size="{{ $sz }}">
                            {{ $sz }}
                        </button>
                    @endforeach
                </div>
            </div>

            {{-- ── CTAs ── --}}
            <div class="cta-row">
                <button class="btn-primary"
                        id="addToCartBtn"
                        data-add-url="{{ route('cart.store') }}"
                        data-remove-url="{{ route('cart.destroy') }}"
                        data-product-id="{{ $product->id }}">
                    Add to Cart
                </button>

                <button class="btn-secondary" id="buyNowBtn"
                        data-product-id="{{ $product->id }}"
                        data-url="{{ route('order.razorpay.create') }}">
                    Buy Now
                </button>

                <button class="icon-btn" id="wishBtn"
                        data-product-id="{{ $product->id }}"
                        data-url="{{ route('wishlist.toggle') }}"
                        aria-label="Wishlist">
                    <i class="fa-regular fa-heart" id="wishIcon"></i>
                </button>

                <button class="icon-btn" id="shareBtn" aria-label="Share">
                    <i class="fa-solid fa-share-nodes"></i>
                </button>
            </div>

            {{-- ── DELIVERY CHECK ── --}}
            <div class="option-block" style="padding-top:12px;">
                <div class="opt-head" style="margin-bottom:8px;">
                    <div class="label">Estimated Delivery</div>
                </div>
                <div class="pin-row">
                    <input id="pincode" type="text" inputmode="numeric"
                           placeholder="Enter 6-digit pincode" maxlength="6" />
                    <button id="checkPin">Check</button>
                </div>
                <div class="pin-status" id="pinStatus">Enter pincode to check delivery estimate.</div>

                <div class="usp-row">
                    <div class="usp"><i class="fa-solid fa-rotate-left"></i> 30 days easy exchange</div>
                    <div class="usp"><i class="fa-solid fa-spray-can-sparkles"></i> Free lifetime plating</div>
                    <div class="usp"><i class="fa-solid fa-clock"></i> 9 to 5 customer support</div>
                </div>
            </div>

            {{-- ── ACCORDIONS ── --}}
            <div class="accordion" id="accordion">
                <div class="acc-item active">
                    <button class="acc-btn" type="button">
                        <span class="t">Description</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="acc-body">
                        {{ $product->description ?? 'A timeless piece crafted for everyday elegance.' }}
                    </div>
                </div>

                <div class="acc-item">
                    <button class="acc-btn" type="button">
                        <span class="t">Specification</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="acc-body">
                        <ul style="padding-left:18px; line-height:1.8;">
                            @if($product->material)   <li>Material: {{ $product->material }}</li> @endif
                            @if($product->weight)     <li>Weight: {{ $product->weight }}g</li> @endif
                            @if($product->stone)      <li>Stone: {{ $product->stone->name }}</li> @endif
                            @if($product->polish)     <li>Polish: {{ $product->polish->name }}</li> @endif
                            @if($product->product_code) <li>SKU: {{ $product->product_code }}</li> @endif
                        </ul>
                    </div>
                </div>

                <div class="acc-item">
                    <button class="acc-btn" type="button">
                        <span class="t">More Info</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="acc-body">
                        Keep away from perfume and water for long-lasting shine.
                        Store in a dry pouch after use. Exchange available within 30 days.
                    </div>
                </div>
            </div>

        </aside>
    </section>

    {{-- ══ COMPLETE THE LOOK ══ --}}
    @if($product->completeLookProducts->isNotEmpty())
    <section class="section">
        <h2 class="section-title">Complete the look</h2>
        <div class="look-wrap">
            <div class="look-grid">
                @foreach($product->completeLookProducts as $index => $lookProduct)
                    @if($index > 0)<div class="look-plus">+</div>@endif
                    <a href="{{ route('frontend.product-details', $lookProduct->id) }}" class="look-card">
                        <div class="look-img">
                            @php $img = $lookProduct->images->first(); @endphp
                            <img src="{{ $img ? asset('public/storage/' . $img->image) : 'https://via.placeholder.com/400x500?text=No+Image' }}"
                                 alt="{{ $lookProduct->base_name }}">
                        </div>
                        <div class="look-bottom">
                            <span>{{ $lookProduct->base_name }}</span>
                            <strong>₹{{ number_format($lookProduct->base_price) }}</strong>
                        </div>
                    </a>
                @endforeach
            </div>
            @php $totalCost = $product->completeLookProducts->sum('base_price'); @endphp
            <div class="buy-all">
                <span class="label">Buy all {{ $product->completeLookProducts->count() }}:</span>
                <strong style="color:var(--primary-blue); font-size:1.15rem;">
                    ₹{{ number_format($totalCost) }}
                </strong>
                <button class="btn-primary" type="button"
                        id="buySetBtn"
                        data-ids="{{ $product->completeLookProducts->pluck('id')->implode(',') }}"
                        style="padding:.85rem 1.1rem;">
                    Add Set to Cart
                </button>
            </div>
        </div>
    </section>
    @endif

    {{-- ══ SIMILAR ITEMS ══ --}}
    @if($product->similarProducts->isNotEmpty())
    <section class="section" style="padding-top: 0;">
        <h2 class="section-title">Similar items</h2>
        <div class="similar-grid">
            @foreach($product->similarProducts as $similar)
                <a href="{{ route('frontend.product-details', $similar->id) }}" class="mini-card">
                    <div class="mini-img">
                        @php $img = $similar->images->first(); @endphp
                        <img src="{{ $img ? asset('public/storage/' . $img->image) : 'https://via.placeholder.com/400x400?text=No+Image' }}"
                             alt="{{ $similar->base_name }}">
                    </div>
                    <div class="mini-info">
                        <div class="mini-name">{{ $similar->base_name }}</div>
                        <div class="mini-price">₹{{ number_format($similar->base_price) }}</div>
                    </div>
                </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══ REVIEWS ══ --}}
    <section class="section" style="padding-top: 0;">
        <h2 class="section-title">Customer reviews</h2>
        <div class="reviews-wrap">
            <div class="review-head">
                <div class="review-score">
                    <div class="score">{{ $avgRating ?: '–' }}</div>
                    <div class="score-meta">
                        <div class="rating-icons" style="color:#f39c12; font-size:1rem; margin-bottom:6px;">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fa fa-star {{ $i <= round($avgRating) ? 'active' : '' }}"></i>
                            @endfor
                        </div>
                        Based on <strong>{{ $totalReviews }}</strong> {{ Str::plural('review', $totalReviews) }}
                    </div>
                </div>
                <button class="review-btn" id="openReviewModalBtn" type="button">Write a review</button>
            </div>

            <div class="review-list" id="reviewList">
                @forelse($reviews as $review)
                    <div class="review-card">
                        <div class="review-top">
                            <div class="review-name">{{ $review->name }}</div>
                            <div class="review-date">{{ $review->created_at->format('d M Y') }}</div>
                        </div>
                        @if($review->title)
                            <div style="font-size:.9rem; font-weight:600; margin-bottom:4px;">{{ $review->title }}</div>
                        @endif
                        <div class="review-stars">
                            <div class="rating-icons">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fa fa-star {{ $i <= $review->rating ? 'active' : '' }}"></i>
                                @endfor
                            </div>
                        </div>
                        <div class="review-text">{{ $review->message }}</div>
                    </div>
                @empty
                    <div style="padding: 2rem 0; color: #888; text-align:center; grid-column:1/-1;">
                        No reviews yet. Be the first to write one!
                    </div>
                @endforelse
            </div>
        </div>
    </section>

</main>

{{-- ══ STICKY CTA (mobile) ══ --}}
<div class="sticky-cta" id="stickyCta">
    <div class="row">
        <div class="mini">
            <div class="n">{{ $product->base_name }}</div>
            <div class="p">₹{{ number_format($product->base_price) }}</div>
        </div>
        <button class="btn-primary" id="stickyAddBtn" style="padding:.85rem 1rem;">Add to Cart</button>
    </div>
</div>

{{-- ══ REVIEW MODAL ══ --}}
<div class="modal" id="reviewModal" aria-hidden="true">
    <div class="backdrop" id="reviewBackdrop"></div>
    <div class="modal-card" role="dialog" aria-modal="true">
        <div class="modal-head">
            <div class="modal-title">Write a review</div>
            <button class="modal-close" id="closeReviewModalBtn" type="button"><i class="fa-solid fa-xmark"></i></button>
        </div>
        <div class="modal-body">
            <input type="hidden" id="reviewProductId" value="{{ $product->id }}">
            <div class="rating-picker">
                <div class="label">Your rating</div>
                <div class="stars-input" id="starsInput">
                    @for($i = 1; $i <= 5; $i++)
                        <button class="star-btn" type="button" data-value="{{ $i }}">
                            <i class="fa-solid fa-star"></i>
                        </button>
                    @endfor
                </div>
                <div class="rating-value" id="ratingValue">0/5</div>
            </div>
            <div class="error-text" id="reviewError" style="margin-top:10px;">Please fill all fields and select a rating.</div>
            <div class="form-grid" style="margin-top: 12px;">
                <div class="field">
                    <label for="reviewName">Name</label>
                    <input id="reviewName" type="text" placeholder="Your name" maxlength="40" />
                </div>
                <div class="field">
                    <label for="reviewTitle">Title (optional)</label>
                    <input id="reviewTitle" type="text" placeholder="Short headline" maxlength="60" />
                </div>
                <div class="field full">
                    <label for="reviewMessage">Review</label>
                    <textarea id="reviewMessage" placeholder="Share your experience…" maxlength="600"></textarea>
                </div>
            </div>
        </div>
        <div class="modal-actions">
            <button class="btn-ghost" id="cancelReviewBtn" type="button">Cancel</button>
            <button class="btn-primary" id="submitReviewBtn" type="button"
                    data-url="{{ route('reviews.store') }}">
                Submit Review
            </button>
        </div>
    </div>
</div>

<div class="toast" id="toast"></div>

@push('scripts')
<script>
// ── Globals ───────────────────────────────────────────────────────────────
const toast    = document.getElementById('toast');
const overlay  = document.getElementById('overlay');
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';

function showToast(msg, duration = 3000) {
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), duration);
}
function openOverlay()  { overlay?.classList.add('active');    document.body.style.overflow = 'hidden'; }
function closeOverlay() { overlay?.classList.remove('active'); document.body.style.overflow = ''; }

// ── Navbar always scrolled ────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    navbar.classList.add('Scrolled');
    new MutationObserver(() => {
        if (!navbar.classList.contains('Scrolled')) navbar.classList.add('Scrolled');
    }).observe(navbar, { attributes: true, attributeFilter: ['class'] });
});

// ── Gallery thumbs ────────────────────────────────────────────────────────
document.querySelectorAll('.thumb').forEach(t => {
    t.addEventListener('click', () => {
        document.querySelectorAll('.thumb').forEach(x => x.classList.remove('active'));
        t.classList.add('active');
        document.getElementById('mainImage').src = t.dataset.src;
    });
});

// ── Finish chips ──────────────────────────────────────────────────────────
const finishHint = document.getElementById('finishHint');
document.querySelectorAll('#metalChips .chip').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#metalChips .chip').forEach(x => x.classList.remove('active'));
        btn.classList.add('active');
        if (finishHint) finishHint.textContent = btn.dataset.finish;
    });
});
// Set initial hint
const firstFinish = document.querySelector('#metalChips .chip.active');
if (firstFinish && finishHint) finishHint.textContent = firstFinish.dataset.finish;

// ── Polish swatches ───────────────────────────────────────────────────────
const polishNameEl = document.getElementById('polishName');
const polishHint   = document.getElementById('polishHint');

document.querySelectorAll('#swatches .swatch').forEach(s => {
    s.addEventListener('click', () => {
        document.querySelectorAll('#swatches .swatch').forEach(x => x.classList.remove('active'));
        s.classList.add('active');
        const name = s.dataset.polishName;
        if (polishNameEl) polishNameEl.textContent = name;
        if (polishHint)   polishHint.textContent   = name;
    });
});

// ── Type chips ────────────────────────────────────────────────────────────
document.querySelectorAll('#typeChips .chip').forEach(btn => {
    btn.addEventListener('click', () => {
        document.querySelectorAll('#typeChips .chip').forEach(x => x.classList.remove('active'));
        btn.classList.add('active');
    });
});

// ── Size buttons ──────────────────────────────────────────────────────────
document.querySelectorAll('#sizes .size').forEach(sz => {
    sz.addEventListener('click', () => {
        document.querySelectorAll('#sizes .size').forEach(x => x.classList.remove('active'));
        sz.classList.add('active');
    });
});

// ── Accordion ─────────────────────────────────────────────────────────────
document.querySelectorAll('#accordion .acc-item').forEach(item => {
    item.querySelector('.acc-btn').addEventListener('click', () => {
        document.querySelectorAll('#accordion .acc-item').forEach(i => {
            if (i !== item) i.classList.remove('active');
        });
        item.classList.toggle('active');
    });
});

// ── Coupon ────────────────────────────────────────────────────────────────
const couponBtn      = document.getElementById('couponBtn');
const productPriceEl = document.getElementById('productPrice');
const discountedEl   = document.getElementById('discountedPrice');
const basePrice      = {{ $product->base_price }};
let couponApplied    = false;

couponBtn?.addEventListener('click', () => {
    if (!couponApplied) {
        const newPrice = Math.round(basePrice * 0.9);
        productPriceEl.classList.add('strikethrough');
        discountedEl.textContent  = '₹' + newPrice.toLocaleString('en-IN');
        discountedEl.style.display = 'block';
        couponBtn.classList.add('applied');
        couponBtn.innerHTML = '<i class="fa-solid fa-check"></i> APPLIED';
        couponApplied = true;
        showToast('Coupon applied! 10% off ✓');
    } else {
        productPriceEl.classList.remove('strikethrough');
        discountedEl.style.display = 'none';
        couponBtn.classList.remove('applied');
        couponBtn.innerHTML = '<i class="fa-solid fa-tag"></i> ETTH10';
        couponApplied = false;
        showToast('Coupon removed');
    }
});

// ── Add to Cart ───────────────────────────────────────────────────────────
(function () {
    const btn = document.getElementById('addToCartBtn');
    if (!btn) return;
    let inCart = false;

    @auth('frontend')
    const alreadyInCart = {{ $product->carts->where('user_id', auth('frontend')->id())->count() > 0 ? 'true' : 'false' }};
    if (alreadyInCart) {
        inCart = true;
        btn.textContent = 'Remove from Cart';
        btn.classList.add('in-cart');
    }
    @endauth

    function getSelectedVariantId() {
        const activeFinish = document.querySelector('#metalChips .chip.active')?.dataset.finish;
        const activePolish = document.querySelector('#swatches .swatch.active')?.dataset.polishId;
        // return the variant id that matches selected finish+polish if needed
        // for now pass null — wire to your variant model as needed
        return null;
    }

    btn.addEventListener('click', () => inCart ? removeFromCart() : addToCart());

    function addToCart() {
        setLoading(true);
        fetch(btn.dataset.addUrl, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: btn.dataset.productId, variant_id: getSelectedVariantId(), quantity: 1 }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success) {
                inCart = true;
                btn.textContent = 'Remove from Cart';
                btn.classList.add('in-cart');
                updateCartCount(data.cart_count);
                showToast('Added to cart ✓');
            } else { showToast(data.message || 'Something went wrong.'); }
        })
        .catch(() => showToast('Something went wrong.'))
        .finally(() => setLoading(false));
    }

    function removeFromCart() {
        setLoading(true);
        fetch(btn.dataset.removeUrl, {
            method: 'DELETE',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: btn.dataset.productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success) {
                inCart = false;
                btn.textContent = 'Add to Cart';
                btn.classList.remove('in-cart');
                updateCartCount(data.cart_count);
                showToast('Removed from cart ✓');
            }
        })
        .catch(() => showToast('Something went wrong.'))
        .finally(() => setLoading(false));
    }

    function setLoading(state) {
        btn.disabled    = state;
        btn.textContent = state ? 'Please wait…' : (inCart ? 'Remove from Cart' : 'Add to Cart');
    }

    function updateCartCount(count) {
        const el = document.getElementById('cartCount');
        if (el) el.textContent = count;
    }

    // Sticky CTA mirrors the main button
    document.getElementById('stickyAddBtn')?.addEventListener('click', () => btn.click());
})();


// ── Wishlist ──────────────────────────────────────────────────────────────
(function () {
    const btn  = document.getElementById('wishBtn');
    const icon = document.getElementById('wishIcon');
    if (!btn) return;

    // Pre-fill state from server
    @auth('frontend')
    const alreadyWishlisted = {{ Wishlist::where('user_id', auth('frontend')->id())->where('product_id', $product->id)->exists() ? 'true' : 'false' }};
    if (alreadyWishlisted) {
        icon.className = 'fa-solid fa-heart';
        btn.style.color = '#e74c3c';
    }
    @endauth

    btn.addEventListener('click', function () {
        @guest('frontend')
        window.location.href = '{{ route("frontend.login") }}';
        return;
        @endguest

        fetch(btn.dataset.url, {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body   : JSON.stringify({ product_id: btn.dataset.productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success) {
                if (data.wishlisted) {
                    icon.className  = 'fa-solid fa-heart';
                    btn.style.color = '#e74c3c';
                    showToast('Added to wishlist ♡');
                } else {
                    icon.className  = 'fa-regular fa-heart';
                    btn.style.color = '';
                    showToast('Removed from wishlist');
                }
                // Update nav count if present
                const navEl = document.getElementById('wishlistCount');
                if (navEl) navEl.textContent = data.count;
            }
        })
        .catch(() => showToast('Something went wrong.'));
    });
})();

// ── Share ─────────────────────────────────────────────────────────────────
document.getElementById('shareBtn')?.addEventListener('click', () => {
    if (navigator.share) {
        navigator.share({ title: '{{ addslashes($product->base_name) }}', url: window.location.href });
    } else {
        navigator.clipboard?.writeText(window.location.href);
        showToast('Link copied to clipboard ✓');
    }
});

// ── Buy Now (Razorpay) ────────────────────────────────────────────────────
document.getElementById('buyNowBtn')?.addEventListener('click', function () {
    const btn = this;
    btn.disabled    = true;
    btn.textContent = 'Please wait…';

    fetch(btn.dataset.url, {
        method: 'POST',
        credentials: 'same-origin',
        headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
        body: JSON.stringify({
            product_id: btn.dataset.productId,
            variant_id: document.querySelector('#metalChips .chip.active')?.dataset.finish ?? null,
            quantity: 1,
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (!data.success) { showToast('Failed to initiate payment.'); return; }
        const options = {
            key: data.key, amount: data.amount, currency: data.currency,
            name: 'Ethnicoast', description: data.product_name,
            order_id: data.razorpay_order_id,
            prefill: {
                name:  '{{ addslashes(auth("frontend")->user()?->name ?? "") }}',
                email: '{{ addslashes(auth("frontend")->user()?->email ?? "") }}',
            },
            theme: { color: '#07203F' },
            handler: function (response) {
                fetch('{{ route("order.verify") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify({ ...response, product_id: data.product_id, quantity: data.quantity }),
                })
                .then(r => r.json())
                .then(res => showToast(res.success ? 'Order placed ✓' : (res.message || 'Payment failed.')));
            },
            modal: { ondismiss: () => { btn.disabled = false; btn.textContent = 'Buy Now'; } }
        };
        new Razorpay(options).open();
    })
    .catch(() => showToast('Something went wrong.'))
    .finally(() => { btn.disabled = false; btn.textContent = 'Buy Now'; });
});

// ── Buy Set (Complete the Look) ───────────────────────────────────────────
document.getElementById('buySetBtn')?.addEventListener('click', function () {
    const ids = this.dataset.ids.split(',');
    Promise.all(ids.map(id =>
        fetch('{{ route("cart.store") }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: id, quantity: 1 }),
        }).then(r => r.json())
    ))
    .then(results => {
        const anyRedirect = results.find(r => r.redirect);
        if (anyRedirect) { window.location.href = anyRedirect.redirect; return; }
        showToast('All items added to cart ✓');
        const last = results[results.length - 1];
        const el   = document.getElementById('cartCount');
        if (el && last?.cart_count) el.textContent = last.cart_count;
    })
    .catch(() => showToast('Something went wrong.'));
});

// ── Pincode check ─────────────────────────────────────────────────────────
document.getElementById('checkPin')?.addEventListener('click', () => {
    const pin    = document.getElementById('pincode').value.trim();
    const status = document.getElementById('pinStatus');
    if (pin.length !== 6 || isNaN(pin)) {
        status.textContent = 'Please enter a valid 6-digit pincode.';
        return;
    }
    status.textContent = 'Checking…';
    // Simulated — wire to a real delivery API if needed
    setTimeout(() => {
        status.textContent = `Estimated delivery to ${pin}: 3–5 business days. ✓`;
    }, 700);
});

// ── Review Modal ──────────────────────────────────────────────────────────
const reviewModal = document.getElementById('reviewModal');
let selectedRating = 0;

function openReviewModal()  { reviewModal.classList.add('active');    openOverlay(); }
function closeReviewModal() {
    reviewModal.classList.remove('active');
    closeOverlay();
    selectedRating = 0;
    document.getElementById('ratingValue').textContent = '0/5';
    document.getElementById('reviewError').classList.remove('show');
    document.querySelectorAll('.star-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('reviewName').value    = '';
    document.getElementById('reviewTitle').value   = '';
    document.getElementById('reviewMessage').value = '';
}

document.getElementById('openReviewModalBtn')?.addEventListener('click', openReviewModal);
document.getElementById('closeReviewModalBtn')?.addEventListener('click', closeReviewModal);
document.getElementById('cancelReviewBtn')?.addEventListener('click', closeReviewModal);
document.getElementById('reviewBackdrop')?.addEventListener('click', closeReviewModal);

document.querySelectorAll('.star-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        selectedRating = parseInt(btn.dataset.value);
        document.getElementById('ratingValue').textContent = `${selectedRating}/5`;
        document.querySelectorAll('.star-btn').forEach(b =>
            b.classList.toggle('active', parseInt(b.dataset.value) <= selectedRating)
        );
    });
});

document.getElementById('submitReviewBtn')?.addEventListener('click', function () {
    const name    = document.getElementById('reviewName').value.trim();
    const title   = document.getElementById('reviewTitle').value.trim();
    const message = document.getElementById('reviewMessage').value.trim();
    const errEl   = document.getElementById('reviewError');

    if (!name || !message || selectedRating === 0) {
        errEl.classList.add('show'); return;
    }
    errEl.classList.remove('show');
    this.disabled    = true;
    this.textContent = 'Submitting…';

    fetch(this.dataset.url, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
        body: JSON.stringify({
            product_id: document.getElementById('reviewProductId').value,
            name, title, message, rating: selectedRating,
        }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            closeReviewModal();
            showToast('Review submitted ✓');
        } else {
            const errors = data.errors
                ? Object.values(data.errors).flat().join(' ')
                : (data.message || 'Something went wrong.');
            errEl.textContent = errors;
            errEl.classList.add('show');
        }
    })
    .catch(() => { errEl.textContent = 'Network error.'; errEl.classList.add('show'); })
    .finally(() => { this.disabled = false; this.textContent = 'Submit Review'; });
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

  document.addEventListener('DOMContentLoaded', () => {
    const navLogo = document.getElementById('navLogo');
    if (navLogo) {
      navLogo.src = '{{ asset("public/assets/logo_new_1.png") }}';
      navLogo.setAttribute('data-src', '{{ asset("public/assets/logo_new_1.png") }}');
    }
  });
</script>
@endpush

@endsection