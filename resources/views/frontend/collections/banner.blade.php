@extends('frontend.layouts.master')

@section('title', $banner->title ?? $banner->banner_title ?? 'Collection')

@push('styles')
<style>
    :root {
        --ec-gold:    #b8975a;
        --ec-gold-lt: #d4b47a;
        --ec-dark:    #1a1a1a;
        --ec-mid:     #3d3d3d;
        --ec-cream:   #f9f6f1;
        --ec-white:   #ffffff;
        --ec-border:  #e2ddd6;
        --ec-badge:   #c0392b;
        --ec-font-display: 'Cormorant Garamond', Georgia, serif;
        --ec-font-body:    'Jost', 'Segoe UI', sans-serif;
        --ec-transition: 0.3s ease;
    }

    /* ─── Hero Banner ─── */
    .ec-banner-hero {
        position: relative; width: 100%;
        height: clamp(320px, 55vw, 620px);
        overflow: hidden; background: var(--ec-dark);
    }
    .ec-banner-hero__img {
        width: 100%; height: 100%; object-fit: cover;
        object-position: center; display: block; transition: transform 8s ease;
    }
    .ec-banner-hero:hover .ec-banner-hero__img { transform: scale(1.04); }
    .ec-banner-hero__overlay {
        position: absolute; inset: 0;
        background: linear-gradient(to right, rgba(10,10,10,0.65) 0%, rgba(10,10,10,0.35) 50%, rgba(10,10,10,0.10) 100%);
        display: flex; align-items: center;
    }
    .ec-banner-hero__content { padding: 0 6vw; max-width: 640px; }
    .ec-banner-hero__eyebrow {
        display: inline-block; font-family: var(--ec-font-body);
        font-size: 11px; font-weight: 500; letter-spacing: 0.22em; text-transform: uppercase;
        color: var(--ec-gold); border-bottom: 1px solid var(--ec-gold); padding-bottom: 4px; margin-bottom: 18px;
    }
    .ec-banner-hero__title {
        font-family: var(--ec-font-display); font-size: clamp(2rem, 5.5vw, 4rem);
        font-weight: 300; color: var(--ec-white); line-height: 1.1; margin: 0 0 18px; letter-spacing: 0.04em;
    }
    .ec-banner-hero__subtitle {
        font-family: var(--ec-font-body); font-size: clamp(0.85rem, 1.5vw, 1rem);
        font-weight: 300; color: rgba(255,255,255,0.82); line-height: 1.65; margin: 0 0 32px; max-width: 420px;
    }
    .ec-banner-hero__actions { display: flex; gap: 14px; flex-wrap: wrap; }
    .ec-btn-primary {
        display: inline-flex; align-items: center; gap: 8px; font-family: var(--ec-font-body);
        font-size: 11px; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--ec-dark); background: var(--ec-gold); border: 1px solid var(--ec-gold);
        padding: 13px 28px; text-decoration: none; transition: var(--ec-transition);
    }
    .ec-btn-primary:hover { background: var(--ec-gold-lt); border-color: var(--ec-gold-lt); color: var(--ec-dark); text-decoration: none; }
    .ec-btn-outline {
        display: inline-flex; align-items: center; font-family: var(--ec-font-body);
        font-size: 11px; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase;
        color: var(--ec-white); background: transparent; border: 1px solid rgba(255,255,255,0.55);
        padding: 13px 28px; text-decoration: none; transition: var(--ec-transition);
    }
    .ec-btn-outline:hover { border-color: var(--ec-white); background: rgba(255,255,255,0.08); color: var(--ec-white); text-decoration: none; }

    /* ─── Breadcrumb ─── */
    .ec-breadcrumb { background: var(--ec-cream); border-bottom: 1px solid var(--ec-border); padding: 12px 0; }
    .ec-breadcrumb__inner {
        max-width: 1400px; margin: 0 auto; padding: 0 24px;
        display: flex; align-items: center; gap: 8px;
        font-family: var(--ec-font-body); font-size: 12px; color: var(--ec-mid);
    }
    .ec-breadcrumb a { color: var(--ec-mid); text-decoration: none; transition: color var(--ec-transition); }
    .ec-breadcrumb a:hover { color: var(--ec-gold); }
    .ec-breadcrumb__sep { color: var(--ec-border); font-size: 14px; }
    .ec-breadcrumb__current { color: var(--ec-gold); font-weight: 500; }

    /* ─── Collection Description ─── */
    .ec-collection-desc { background: var(--ec-white); border-bottom: 1px solid var(--ec-border); padding: 40px 0 36px; text-align: center; }
    .ec-collection-desc__inner { max-width: 700px; margin: 0 auto; padding: 0 24px; }
    .ec-collection-desc__title {
        font-family: var(--ec-font-display); font-size: clamp(1.6rem, 3vw, 2.4rem);
        font-weight: 400; color: var(--ec-dark); letter-spacing: 0.06em; margin: 0 0 14px;
    }
    .ec-collection-desc__text { font-family: var(--ec-font-body); font-size: 0.92rem; font-weight: 300; color: var(--ec-mid); line-height: 1.75; margin: 0; }
    .ec-divider-gold { width: 48px; height: 1px; background: var(--ec-gold); margin: 16px auto; }

    /* ─── Toolbar ─── */
    .ec-toolbar { background: var(--ec-white); border-bottom: 1px solid var(--ec-border); position: sticky; top: 0; z-index: 50; }
    .ec-toolbar__inner {
        max-width: 1400px; margin: 0 auto; padding: 0 24px;
        display: flex; align-items: center; justify-content: space-between; height: 56px; gap: 16px;
    }
    .ec-toolbar__left { display: flex; align-items: center; gap: 12px; }
    .ec-toolbar__count { font-family: var(--ec-font-body); font-size: 12px; color: var(--ec-mid); }
    .ec-toolbar__count strong { color: var(--ec-dark); font-weight: 600; }
    .ec-filter-btn {
        display: flex; align-items: center; gap: 7px; font-family: var(--ec-font-body);
        font-size: 12px; font-weight: 500; letter-spacing: 0.1em; text-transform: uppercase;
        color: var(--ec-dark); background: none; border: 1px solid var(--ec-border);
        padding: 8px 16px; cursor: pointer; transition: var(--ec-transition);
    }
    .ec-filter-btn:hover { border-color: var(--ec-gold); color: var(--ec-gold); }
    .ec-toolbar__right { display: flex; align-items: center; gap: 10px; }
    .ec-sort-label { font-family: var(--ec-font-body); font-size: 12px; color: var(--ec-mid); white-space: nowrap; }
    .ec-sort-select {
        font-family: var(--ec-font-body); font-size: 12px; color: var(--ec-dark);
        border: 1px solid var(--ec-border); background: var(--ec-white);
        padding: 8px 32px 8px 12px; appearance: none; -webkit-appearance: none; cursor: pointer;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6' viewBox='0 0 10 6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%233d3d3d'/%3E%3C/svg%3E");
        background-repeat: no-repeat; background-position: right 10px center;
        outline: none; transition: border-color var(--ec-transition);
    }
    .ec-sort-select:focus { border-color: var(--ec-gold); }
    .ec-view-toggle { display: flex; gap: 2px; }
    .ec-view-btn {
        width: 34px; height: 34px; border: 1px solid var(--ec-border); background: none;
        cursor: pointer; display: flex; align-items: center; justify-content: center;
        color: var(--ec-mid); transition: var(--ec-transition);
    }
    .ec-view-btn.active, .ec-view-btn:hover { border-color: var(--ec-gold); color: var(--ec-gold); }

    /* ─── Layout ─── */
    .ec-collection-wrap { max-width: 1400px; margin: 0 auto; padding: 40px 24px 80px; display: flex; gap: 32px; align-items: flex-start; }

    /* ─── Sidebar ─── */
    .ec-sidebar { width: 240px; flex-shrink: 0; display: none; }
    .ec-sidebar.open { display: block; }
    .ec-filter-section { border-bottom: 1px solid var(--ec-border); padding: 20px 0; }
    .ec-filter-section:first-child { padding-top: 0; }
    .ec-filter-section__title {
        font-family: var(--ec-font-body); font-size: 11px; font-weight: 600;
        letter-spacing: 0.16em; text-transform: uppercase; color: var(--ec-dark);
        margin: 0 0 14px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;
    }
    .ec-filter-tags { display: flex; flex-wrap: wrap; gap: 8px; list-style: none; margin: 0; padding: 0; }
    .ec-filter-tag {
        display: inline-block; font-family: var(--ec-font-body); font-size: 11px; font-weight: 400;
        color: var(--ec-mid); border: 1px solid var(--ec-border); padding: 5px 12px;
        cursor: pointer; transition: var(--ec-transition); white-space: nowrap; text-decoration: none;
    }
    .ec-filter-tag:hover, .ec-filter-tag.active { border-color: var(--ec-gold); color: var(--ec-gold); background: rgba(184,151,90,0.06); text-decoration: none; }
    .ec-price-range { display: flex; align-items: center; gap: 8px; margin-top: 8px; }
    .ec-price-input {
        width: 75px; font-family: var(--ec-font-body); font-size: 12px;
        border: 1px solid var(--ec-border); padding: 6px 10px; color: var(--ec-dark);
        outline: none; transition: border-color var(--ec-transition);
    }
    .ec-price-input:focus { border-color: var(--ec-gold); }

    /* ─── Product Grid ─── */
    .ec-products { flex: 1; min-width: 0; }
    .ec-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2px; }
    .ec-grid.grid-2 { grid-template-columns: repeat(2, 1fr); }
    .ec-grid.grid-4 { grid-template-columns: repeat(4, 1fr); }

    /* ─── Product Card ─── */
    .ec-card { position: relative; background: var(--ec-white); display: flex; flex-direction: column; overflow: hidden; transition: box-shadow var(--ec-transition); }
    .ec-card:hover { box-shadow: 0 8px 32px rgba(0,0,0,0.09); }
    .ec-card__img-wrap { position: relative; aspect-ratio: 3/4; overflow: hidden; background: var(--ec-cream); }
    .ec-card__img { width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.6s ease; }
    .ec-card__img-wrap:hover .ec-card__img { transform: scale(1.06); }
    .ec-card__badges { position: absolute; top: 12px; left: 12px; display: flex; flex-direction: column; gap: 5px; z-index: 2; }
    .ec-badge { display: inline-block; font-family: var(--ec-font-body); font-size: 9px; font-weight: 700; letter-spacing: 0.12em; text-transform: uppercase; padding: 4px 8px; line-height: 1; }
    .ec-badge--sale { background: var(--ec-badge); color: #fff; }
    .ec-badge--new  { background: var(--ec-dark);  color: #fff; }
    .ec-card__wishlist {
        position: absolute; top: 10px; right: 10px; z-index: 2;
        width: 34px; height: 34px; background: rgba(255,255,255,0.9); border: none; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; cursor: pointer;
        opacity: 0; transition: opacity var(--ec-transition), transform var(--ec-transition);
    }
    .ec-card__img-wrap:hover .ec-card__wishlist { opacity: 1; }
    .ec-card__wishlist:hover { transform: scale(1.1); }
    .ec-card__wishlist svg { width: 16px; height: 16px; stroke: var(--ec-dark); fill: none; }
    .ec-card__wishlist.wishlisted svg { fill: var(--ec-badge); stroke: var(--ec-badge); }
    .ec-card__quick-add {
        position: absolute; bottom: 0; left: 0; right: 0;
        font-family: var(--ec-font-body); font-size: 10px; font-weight: 600;
        letter-spacing: 0.14em; text-transform: uppercase; color: var(--ec-white);
        background: var(--ec-dark); border: none; padding: 12px; cursor: pointer;
        transform: translateY(100%); transition: transform 0.3s ease; z-index: 2;
    }
    .ec-card__img-wrap:hover .ec-card__quick-add { transform: translateY(0); }
    .ec-card__quick-add:hover { background: var(--ec-gold); }
    .ec-card__body { padding: 14px 14px 18px; display: flex; flex-direction: column; flex: 1; }
    .ec-card__category { font-family: var(--ec-font-body); font-size: 9px; font-weight: 600; letter-spacing: 0.18em; text-transform: uppercase; color: var(--ec-gold); margin: 0 0 6px; }
    .ec-card__name {
        font-family: var(--ec-font-display); font-size: 1rem; font-weight: 400;
        color: var(--ec-dark); line-height: 1.3; margin: 0 0 12px;
        text-decoration: none; display: block; transition: color var(--ec-transition);
    }
    .ec-card__name:hover { color: var(--ec-gold); text-decoration: none; }
    .ec-card__price { display: flex; align-items: baseline; gap: 8px; margin-top: auto; flex-wrap: wrap; }
    .ec-price-current { font-family: var(--ec-font-body); font-size: 0.95rem; font-weight: 600; color: var(--ec-dark); }
    .ec-price-original { font-family: var(--ec-font-body); font-size: 0.82rem; color: #aaa; text-decoration: line-through; }
    .ec-price-pct { font-family: var(--ec-font-body); font-size: 10px; font-weight: 700; color: var(--ec-badge); }

    /* ─── Empty ─── */
    .ec-empty { grid-column: 1/-1; text-align: center; padding: 80px 20px; }
    .ec-empty__icon { font-size: 48px; margin-bottom: 16px; }
    .ec-empty__title { font-family: var(--ec-font-display); font-size: 1.8rem; color: var(--ec-dark); margin: 0 0 10px; }
    .ec-empty__text { font-family: var(--ec-font-body); font-size: 0.9rem; color: var(--ec-mid); margin: 0 0 24px; }

    /* ─── Responsive ─── */
    @media (max-width: 1024px) {
        .ec-sidebar { display: none !important; }
        .ec-grid { grid-template-columns: repeat(3, 1fr) !important; }
    }
    @media (max-width: 768px) {
        .ec-banner-hero { height: clamp(260px, 70vw, 420px); }
        .ec-banner-hero__overlay { background: linear-gradient(to bottom, rgba(10,10,10,0.3), rgba(10,10,10,0.65)); }
        .ec-grid { grid-template-columns: repeat(2, 1fr) !important; gap: 1px; }
        .ec-toolbar__inner { padding: 0 16px; }
        .ec-sort-label { display: none; }
        .ec-collection-wrap { padding: 24px 16px 60px; }
        .ec-view-toggle { display: none; }
    }
    @media (max-width: 480px) {
        .ec-banner-hero__content { padding: 0 20px; }
        .ec-btn-outline { display: none; }
    }
</style>
@endpush

@section('content')

{{-- ════════════════════════════════
     HERO BANNER
════════════════════════════════════ --}}
<section class="ec-banner-hero">
    @if($banner->banner_image)
        <img
            class="ec-banner-hero__img"
            src="{{ asset('storage/' . $banner->banner_image) }}"
            alt="{{ $banner->banner_title ?? $banner->title ?? 'Collection' }}"
            loading="eager"
        />
    @endif

    <div class="ec-banner-hero__overlay">
        <div class="ec-banner-hero__content">

            <span class="ec-banner-hero__eyebrow">
                {{ strtoupper(str_replace('_', ' ', $banner->type)) }}
            </span>

            <h1 class="ec-banner-hero__title">
                {{ $banner->banner_title ?? $banner->title ?? 'Collection' }}
            </h1>

            @if($banner->banner_subtitle ?? $banner->description ?? null)
                <p class="ec-banner-hero__subtitle">
                    {{ $banner->banner_subtitle ?? $banner->description }}
                </p>
            @endif

            <div class="ec-banner-hero__actions">
                @if($banner->button_text)
                    <a href="{{ $banner->banner_link ?? '#collection' }}" class="ec-btn-primary">
                        {{ $banner->button_text }}
                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none">
                            <path d="M1 6h10M7 2l4 4-4 4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </a>
                @endif
                @if($banner->button_text_2)
                    <a href="#" class="ec-btn-outline">{{ $banner->button_text_2 }}</a>
                @endif
            </div>

        </div>
    </div>
</section>

{{-- ════════════════════════════════
     BREADCRUMB
════════════════════════════════════ --}}
<nav class="ec-breadcrumb" aria-label="Breadcrumb">
    <div class="ec-breadcrumb__inner">
        <a href="{{ route('frontend.home') }}">Home</a>
        <span class="ec-breadcrumb__sep">›</span>
        <span class="ec-breadcrumb__current">
            {{ $banner->title ?? $banner->banner_title ?? ucwords(str_replace('_', ' ', $banner->type)) }}
        </span>
    </div>
</nav>

{{-- ════════════════════════════════
     COLLECTION DESCRIPTION
     Only shows for banners that have
     both title + description set (for_him, for_her, new_arrivals)
════════════════════════════════════ --}}
@if($banner->title && $banner->description)
<section class="ec-collection-desc">
    <div class="ec-collection-desc__inner">
        <h2 class="ec-collection-desc__title">{{ $banner->title }}</h2>
        <div class="ec-divider-gold"></div>
        <p class="ec-collection-desc__text">{{ $banner->description }}</p>
    </div>
</section>
@endif

{{-- ════════════════════════════════
     TOOLBAR
════════════════════════════════════ --}}
<div class="ec-toolbar">
    <div class="ec-toolbar__inner">

        <div class="ec-toolbar__left">
            <button class="ec-filter-btn" id="ec-filter-toggle" aria-expanded="false">
                <svg width="14" height="12" viewBox="0 0 14 12" fill="none">
                    <path d="M1 1h12M3.5 6h7M6 11h2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
                Filter
            </button>
            <span class="ec-toolbar__count">
                <strong>{{ count($products) }}</strong> products
            </span>
        </div>

        <div class="ec-toolbar__right">
            <span class="ec-sort-label">Sort by:</span>
            <select class="ec-sort-select" aria-label="Sort products">
                <option>Featured</option>
                <option>Newest</option>
                <option>Price: Low to High</option>
                <option>Price: High to Low</option>
                <option>Best Selling</option>
            </select>
            <div class="ec-view-toggle">
                <button class="ec-view-btn active" data-grid="3" title="3 columns">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <rect x="0" y="0" width="3" height="3" fill="currentColor"/>
                        <rect x="5.5" y="0" width="3" height="3" fill="currentColor"/>
                        <rect x="11" y="0" width="3" height="3" fill="currentColor"/>
                        <rect x="0" y="5.5" width="3" height="3" fill="currentColor"/>
                        <rect x="5.5" y="5.5" width="3" height="3" fill="currentColor"/>
                        <rect x="11" y="5.5" width="3" height="3" fill="currentColor"/>
                        <rect x="0" y="11" width="3" height="3" fill="currentColor"/>
                        <rect x="5.5" y="11" width="3" height="3" fill="currentColor"/>
                        <rect x="11" y="11" width="3" height="3" fill="currentColor"/>
                    </svg>
                </button>
                <button class="ec-view-btn" data-grid="4" title="4 columns">
                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none">
                        <rect x="0" y="0" width="2.5" height="3" fill="currentColor"/>
                        <rect x="3.8" y="0" width="2.5" height="3" fill="currentColor"/>
                        <rect x="7.6" y="0" width="2.5" height="3" fill="currentColor"/>
                        <rect x="11.5" y="0" width="2.5" height="3" fill="currentColor"/>
                        <rect x="0" y="5.5" width="2.5" height="3" fill="currentColor"/>
                        <rect x="3.8" y="5.5" width="2.5" height="3" fill="currentColor"/>
                        <rect x="7.6" y="5.5" width="2.5" height="3" fill="currentColor"/>
                        <rect x="11.5" y="5.5" width="2.5" height="3" fill="currentColor"/>
                        <rect x="0" y="11" width="2.5" height="3" fill="currentColor"/>
                        <rect x="3.8" y="11" width="2.5" height="3" fill="currentColor"/>
                        <rect x="7.6" y="11" width="2.5" height="3" fill="currentColor"/>
                        <rect x="11.5" y="11" width="2.5" height="3" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </div>

    </div>
</div>

{{-- ════════════════════════════════
     SIDEBAR + PRODUCT GRID
════════════════════════════════════ --}}
<div class="ec-collection-wrap" id="collection">

    {{-- ── Sidebar ── --}}
    <aside class="ec-sidebar" id="ec-sidebar">

        <div class="ec-filter-section">
            <div class="ec-filter-section__title">Category <span>+</span></div>
            <ul class="ec-filter-tags">
                <li><a class="ec-filter-tag active" href="#">All</a></li>
                {{-- TODO: replace with real categories from DB --}}
                {{-- @foreach($categories as $cat) --}}
                {{--     <li><a class="ec-filter-tag" href="#">{{ $cat->name }}</a></li> --}}
                {{-- @endforeach --}}
                <li><a class="ec-filter-tag" href="#">Earrings</a></li>
                <li><a class="ec-filter-tag" href="#">Pendants</a></li>
                <li><a class="ec-filter-tag" href="#">Bangles</a></li>
                <li><a class="ec-filter-tag" href="#">Rings</a></li>
                <li><a class="ec-filter-tag" href="#">Necklaces</a></li>
            </ul>
        </div>

        <div class="ec-filter-section">
            <div class="ec-filter-section__title">Price Range <span>+</span></div>
            <div class="ec-price-range">
                <input class="ec-price-input" type="number" placeholder="Min" min="0" />
                <span style="color:var(--ec-mid);font-size:12px;">–</span>
                <input class="ec-price-input" type="number" placeholder="Max" min="0" />
                <button class="ec-filter-tag" style="cursor:pointer;">Go</button>
            </div>
        </div>

        <div class="ec-filter-section">
            <div class="ec-filter-section__title">Availability <span>+</span></div>
            <ul class="ec-filter-tags">
                <li><a class="ec-filter-tag active" href="#">All</a></li>
                <li><a class="ec-filter-tag" href="#">In Stock</a></li>
            </ul>
        </div>

    </aside>

    {{-- ── Product Grid ── --}}
    <main class="ec-products" id="ec-products">
        <div class="ec-grid" id="ec-grid">

            @forelse($products as $product)
            <article class="ec-card">

                <div class="ec-card__img-wrap">

                    {{-- ─────────────────────────────────────────
                         IMAGE
                         Tries productImages relation first.
                         Falls back to placeholder.
                         Once you know your image column name,
                         update $image below.
                    ──────────────────────────────────────────── --}}
                    @php
                        $image = optional($product->productImages->first())->image_path;
                    @endphp
                    <img
                        class="ec-card__img"
                        src="{{ $image ? asset('storage/' . $image) : asset('images/placeholder.jpg') }}"
                        alt="{{ $product->base_name }}"
                        loading="lazy"
                    />

                    {{-- Badges --}}
                    <div class="ec-card__badges">
                        @if($product->created_at->diffInDays(now()) <= 30)
                            <span class="ec-badge ec-badge--new">New</span>
                        @endif
                        @if($product->discount_price && $product->discount_price < $product->base_price)
                            @php $pct = round((($product->base_price - $product->discount_price) / $product->base_price) * 100) @endphp
                            <span class="ec-badge ec-badge--sale">{{ $pct }}% OFF</span>
                        @endif
                    </div>

                    {{-- Wishlist button --}}
                    <button class="ec-card__wishlist js-wishlist-btn" data-product="{{ $product->id }}" aria-label="Add to wishlist">
                        <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z" stroke-width="1.5"/>
                        </svg>
                    </button>

                    {{-- Quick Add button --}}
                    <button class="ec-card__quick-add js-quick-add" data-product="{{ $product->id }}">
                        + Quick Add
                    </button>
                </div>

                <div class="ec-card__body">

                    {{-- Category --}}
                    @if($product->category)
                        <p class="ec-card__category">{{ $product->category->name }}</p>
                    @endif

                    {{-- Name — uses base_name from your products table --}}
                    <a class="ec-card__name" href="{{ route('frontend.product-details', $product->id) }}">
                        {{ $product->base_name }}
                    </a>

                    {{-- Price — uses base_price & discount_price from your products table --}}
                    <div class="ec-card__price">
                        @if($product->discount_price && $product->discount_price < $product->base_price)
                            <span class="ec-price-current">₹{{ number_format($product->discount_price, 2) }}</span>
                            <span class="ec-price-original">₹{{ number_format($product->base_price, 2) }}</span>
                            <span class="ec-price-pct">
                                {{ round((($product->base_price - $product->discount_price) / $product->base_price) * 100) }}% off
                            </span>
                        @else
                            <span class="ec-price-current">₹{{ number_format($product->base_price, 2) }}</span>
                        @endif
                    </div>

                </div>
            </article>

            @empty
            <div class="ec-empty">
                <div class="ec-empty__icon">✦</div>
                <h3 class="ec-empty__title">No products yet</h3>
                <p class="ec-empty__text">
                    We're curating something special.<br>Check back soon.
                </p>
                <a href="{{ route('frontend.home') }}" class="ec-btn-primary" style="display:inline-flex;">
                    Back to Home
                </a>
            </div>
            @endforelse

        </div>{{-- /.ec-grid --}}
    </main>

</div>{{-- /.ec-collection-wrap --}}

@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Filter sidebar toggle ──
    const filterBtn = document.getElementById('ec-filter-toggle');
    const sidebar   = document.getElementById('ec-sidebar');
    if (filterBtn && sidebar) {
        filterBtn.addEventListener('click', function () {
            const open = sidebar.classList.toggle('open');
            this.setAttribute('aria-expanded', open);
        });
    }

    // ── Grid column toggle ──
    const grid = document.getElementById('ec-grid');
    document.querySelectorAll('.ec-view-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.ec-view-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            const cols = this.dataset.grid;
            grid.className = cols === '3' ? 'ec-grid' : 'ec-grid grid-' + cols;
        });
    });

    // ── Wishlist toggle (UI only for now) ──
    document.querySelectorAll('.js-wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            this.classList.toggle('wishlisted');
            // TODO: wire to your wishlist route
        });
    });

    // ── Quick Add (UI feedback only for now) ──
    document.querySelectorAll('.js-quick-add').forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const original = this.textContent;
            this.textContent = '✓ Added!';
            this.style.background = 'var(--ec-gold)';
            setTimeout(() => {
                this.textContent = original;
                this.style.background = '';
            }, 1800);
            // TODO: wire to your cart route
        });
    });

});
</script>
@endpush