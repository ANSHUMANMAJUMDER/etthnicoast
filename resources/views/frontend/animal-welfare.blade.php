@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    img { display: block; max-width: 100%; }
    .container { max-width: var(--container); margin: 0 auto; padding: 0 clamp(1rem, 3vw, 3rem); }

    .aw-hero { position: relative; height: 70vh; min-height: 420px; overflow: hidden; display: flex; align-items: flex-end; }
    .aw-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .aw-hero .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(7,32,63,0.78) 0%, rgba(7,32,63,0.08) 60%); }
    .aw-hero .hero-text { position: relative; z-index: 2; padding: 3rem clamp(1rem, 5vw, 5rem); }
    .aw-hero .tag { display: inline-block; padding: 5px 12px; border: 1px solid rgba(255,255,255,0.35); font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 1rem; }
    .aw-hero h1 { font-family: var(--font-primary); color: #fff; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 600; letter-spacing: 3px; text-transform: uppercase; margin-bottom: .75rem; line-height: 1.1; }
    .aw-hero p { color: rgba(255,255,255,0.7); font-size: .95rem; max-width: 520px; line-height: 1.7; }

    .statement-section { padding: 5rem 0; text-align: center; max-width: 760px; margin: 0 auto; }
    .section-eyebrow { font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .section-title { font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.5rem; font-weight: 500; }
    .statement-section p { font-size: 1rem; color: rgba(2,0,13,0.65); line-height: 1.85; margin-bottom: 1rem; }
    .statement-section .big-quote { font-family: var(--font-primary); font-size: clamp(1.2rem, 2.5vw, 1.7rem); color: var(--primary-blue); font-style: italic; letter-spacing: 1px; line-height: 1.4; padding: 2rem 0; border-top: 1px solid rgba(7,32,63,0.1); border-bottom: 1px solid rgba(7,32,63,0.1); margin: 2rem 0; }

    .commitments-section { padding: 3rem 0 5rem; }
    .commitments-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .commit-card { display: grid; grid-template-columns: 80px 1fr; gap: 1.5rem; border: 1px solid rgba(7,32,63,0.1); padding: 1.75rem; background: #fff; align-items: flex-start; transition: .25s ease; }
    .commit-card:hover { box-shadow: 0 10px 28px rgba(7,32,63,0.08); transform: translateY(-3px); }
    .commit-num { font-family: var(--font-primary); font-size: 2.5rem; font-weight: 700; color: rgba(7,32,63,0.08); line-height: 1; padding-top: 4px; }
    .commit-text h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1rem; font-weight: 600; letter-spacing: .5px; margin-bottom: .6rem; }
    .commit-text p { font-size: .88rem; color: rgba(2,0,13,0.62); line-height: 1.75; }

    .feature-split { background: rgba(235,222,212,0.5); padding: 5rem 0; }
    .feature-split .text-side { max-width: 760px; margin: 0 auto; }
    .feature-split .text-side .eyebrow { font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .feature-split .text-side h2 { font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.4rem, 2.5vw, 2rem); font-weight: 600; letter-spacing: 1px; margin-bottom: 1.25rem; line-height: 1.2; }
    .feature-split .text-side p { font-size: .9rem; color: rgba(2,0,13,0.65); line-height: 1.8; margin-bottom: 1rem; max-width: 640px; }

    .badge-strip { background: var(--primary-blue); padding: 3rem 0; }
    .badge-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
    .badge-item i { font-size: 1.75rem; color: rgba(255,255,255,0.8); margin-bottom: .75rem; display: block; }
    .badge-item .b-title { font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.55); margin-bottom: .4rem; }
    .badge-item .b-val { font-family: var(--font-primary); color: #fff; font-size: 1rem; font-weight: 600; letter-spacing: .5px; }

    .cert-section { padding: 5rem 0; background: rgba(235,222,212,0.3); }
    .cert-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; max-width: 900px; margin: 0 auto; }
    .cert-card { background: #fff; border: 1px solid rgba(7,32,63,0.1); padding: 2rem 1.5rem; text-align: center; }
    .cert-card i { font-size: 2rem; color: var(--primary-blue); margin-bottom: 1rem; display: block; }
    .cert-card h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: .92rem; font-weight: 600; letter-spacing: 1px; margin-bottom: .5rem; text-transform: uppercase; }
    .cert-card p { font-size: .82rem; color: rgba(2,0,13,0.58); line-height: 1.65; }

    .cta-banner { padding: 4rem 0; text-align: center; border-top: 1px solid rgba(7,32,63,0.08); }
    .cta-banner h2 { font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.4rem, 3vw, 2rem); letter-spacing: 2px; margin-bottom: 1rem; font-weight: 500; }
    .cta-banner p { color: rgba(2,0,13,0.6); font-size: .95rem; margin-bottom: 2rem; }
    .btn-filled { display: inline-block; padding: .95rem 2rem; background: var(--primary-blue); color: #fff; font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; transition: .25s ease; margin: 0 .5rem; }
    .btn-filled:hover { opacity: .9; }

    @media (max-width: 992px) {
        .commitments-grid { grid-template-columns: 1fr; }
        .badge-grid { grid-template-columns: repeat(2, 1fr); }
        .cert-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (max-width: 600px) {
        .badge-grid { grid-template-columns: repeat(2, 1fr); }
        .cert-grid { grid-template-columns: 1fr; }
        .statement-section { padding: 3rem 1rem; }
    }
</style>
@endpush

@php
    $sections       = collect($page->sections ?? []);
    $statement      = $sections->firstWhere('type', 'statement');
    $commitments    = $sections->firstWhere('type', 'commitments');
    $featureSplit   = $sections->firstWhere('type', 'feature_split');
    $certifications = $sections->firstWhere('type', 'certifications');
@endphp

<main style="padding-top: 80px;">

    {{-- ══ HERO ══ --}}
    <div class="aw-hero">
        <img src="{{ $page->hero_image
                ? asset('storage/' . $page->hero_image)
                : asset('public/assets/animal-welfare-hero.jpg') }}"
             alt="{{ $page->hero_title ?? 'Animal Welfare' }}">
        <div class="overlay"></div>
        <div class="hero-text">
            @if($page->hero_tag)
                <div class="tag">{{ $page->hero_tag }}</div>
            @endif
            <h1>{{ $page->hero_title ?? 'Animal Welfare' }}</h1>
            @if($page->hero_subtitle)
                <p>{{ $page->hero_subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- ══ STATEMENT ══ --}}
    @if($statement)
    <div class="container">
        <div class="statement-section">
            @if(!empty($statement['eyebrow']))
                <div class="section-eyebrow">{{ $statement['eyebrow'] }}</div>
            @endif
            @if(!empty($statement['heading']))
                <h2 class="section-title">{{ $statement['heading'] }}</h2>
            @endif
            @foreach(explode("\n\n", $statement['body'] ?? '') as $para)
                @if(trim($para))
                    <p>{{ trim($para) }}</p>
                @endif
            @endforeach
            @if(!empty($statement['big_quote']))
                <div class="big-quote">{{ $statement['big_quote'] }}</div>
            @endif
            @if(!empty($statement['body2']))
                @foreach(explode("\n\n", $statement['body2']) as $para)
                    @if(trim($para))
                        <p>{{ trim($para) }}</p>
                    @endif
                @endforeach
            @endif
        </div>
    </div>
    @endif

    {{-- ══ COMMITMENTS ══ --}}
    @if($commitments && !empty($commitments['items']))
    <div class="commitments-section">
        <div class="container">
            @if(!empty($commitments['eyebrow']))
                <div class="section-eyebrow" style="text-align:center;">
                    {{ $commitments['eyebrow'] }}
                </div>
            @endif
            @if(!empty($commitments['heading']))
                <h2 class="section-title" style="text-align:center;">
                    {{ $commitments['heading'] }}
                </h2>
            @endif
            <div class="commitments-grid">
                @foreach($commitments['items'] as $item)
                <div class="commit-card">
                    <div class="commit-num">{{ $item['num'] ?? '' }}</div>
                    <div class="commit-text">
                        <h3>{{ $item['title'] ?? '' }}</h3>
                        <p>{{ $item['body'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ FEATURE SPLIT (text only, no image) ══ --}}
    @if($featureSplit)
    <div class="feature-split">
        <div class="container">
            <div class="text-side">
                @if(!empty($featureSplit['eyebrow']))
                    <div class="eyebrow">{{ $featureSplit['eyebrow'] }}</div>
                @endif
                @if(!empty($featureSplit['heading']))
                    <h2>{{ $featureSplit['heading'] }}</h2>
                @endif
                @foreach(explode("\n\n", $featureSplit['body'] ?? '') as $para)
                    @if(trim($para))
                        <p>{{ trim($para) }}</p>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ BADGE STRIP ══ --}}
    @if($page->stats && count($page->stats))
    <div class="badge-strip">
        <div class="container">
            <div class="badge-grid">
                @foreach($page->stats as $badge)
                <div class="badge-item">
                    @if(!empty($badge['icon']))
                        <i class="{{ $badge['icon'] }}"></i>
                    @endif
                    <div class="b-title">{{ $badge['label'] ?? '' }}</div>
                    <div class="b-val">{{ $badge['value'] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ CERTIFICATIONS ══ --}}
    @if($certifications && !empty($certifications['items']))
    <div class="cert-section">
        <div class="container">
            @if(!empty($certifications['eyebrow']))
                <div class="section-eyebrow" style="text-align:center;">
                    {{ $certifications['eyebrow'] }}
                </div>
            @endif
            @if(!empty($certifications['heading']))
                <h2 class="section-title" style="text-align:center;">
                    {{ $certifications['heading'] }}
                </h2>
            @endif
            <div class="cert-grid">
                @foreach($certifications['items'] as $cert)
                <div class="cert-card">
                    @if(!empty($cert['icon']))
                        <i class="{{ $cert['icon'] }}"></i>
                    @endif
                    <h3>{{ $cert['title'] ?? '' }}</h3>
                    <p>{{ $cert['body'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ CTA ══ --}}
    @if($page->cta_title)
    <div class="cta-banner">
        <div class="container">
            <h2>{{ $page->cta_title }}</h2>
            @if($page->cta_subtitle)
                <p>{{ $page->cta_subtitle }}</p>
            @endif
            @if($page->cta_button_text)
                <a href="{{ $page->cta_button_url ?? route('collection.show') }}"
                   class="btn-filled">
                    {{ $page->cta_button_text }}
                </a>
            @endif
        </div>
    </div>
    @endif

</main>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const navbar = document.getElementById("navbar");
    if (navbar) navbar.classList.add("scrolled");
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