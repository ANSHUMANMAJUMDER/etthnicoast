@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    img { display: block; max-width: 100%; }
    .container { max-width: var(--container); margin: 0 auto; padding: 0 clamp(1rem, 3vw, 3rem); }

    {{-- HERO with image --}}
    .page-hero { position: relative; height: 70vh; min-height: 420px; overflow: hidden; display: flex; align-items: flex-end; }
    .page-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .page-hero .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(7,32,63,0.78) 0%, rgba(7,32,63,0.1) 60%); }
    .page-hero .hero-text { position: relative; z-index: 2; padding: 3rem clamp(1rem, 5vw, 5rem); }
    .page-hero .hero-text .eyebrow { display: inline-block; padding: 5px 12px; border: 1px solid rgba(255,255,255,0.35); font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 1rem; }
    .page-hero .hero-text h1 { font-family: var(--font-primary); color: #fff; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 600; letter-spacing: 3px; text-transform: uppercase; margin-bottom: .75rem; line-height: 1.1; }
    .page-hero .hero-text p { color: rgba(255,255,255,0.7); font-size: .95rem; max-width: 520px; line-height: 1.7; }

    .pillars-section { padding: 5rem 0; }
    .section-eyebrow { text-align: center; font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .section-title { text-align: center; font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 3rem; font-weight: 500; }

    .pillars-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0; border: 1px solid rgba(7,32,63,0.1); }
    .pillar { padding: 2.5rem 2rem; border-right: 1px solid rgba(7,32,63,0.1); transition: .25s ease; position: relative; overflow: hidden; }
    .pillar:last-child { border-right: none; }
    .pillar::after { content: ''; position: absolute; bottom: 0; left: 0; right: 0; height: 2px; background: var(--primary-blue); transform: scaleX(0); transition: transform .3s ease; transform-origin: left; }
    .pillar:hover::after { transform: scaleX(1); }
    .pillar:hover { background: rgba(235,222,212,0.2); }
    .pillar .num { font-family: var(--font-primary); font-size: 3rem; font-weight: 700; color: rgba(7,32,63,0.08); line-height: 1; margin-bottom: 1rem; }
    .pillar i { font-size: 1.4rem; color: var(--primary-blue); margin-bottom: 1rem; display: block; }
    .pillar h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1.05rem; font-weight: 600; letter-spacing: 1px; margin-bottom: .75rem; }
    .pillar p { font-size: .88rem; color: rgba(2,0,13,0.62); line-height: 1.75; }

    .compare-section { padding: 5rem 0; background: rgba(235,222,212,0.3); }
    .compare-table { width: 100%; border-collapse: collapse; max-width: 860px; margin: 0 auto; background: #fff; border: 1px solid rgba(7,32,63,0.1); }
    .compare-table th { padding: 1rem 1.5rem; text-align: left; font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(2,0,13,0.55); border-bottom: 1px solid rgba(7,32,63,0.1); background: rgba(235,222,212,0.4); font-weight: 700; }
    .compare-table th:nth-child(2) { background: var(--primary-blue); color: rgba(255,255,255,0.8); text-align: center; }
    .compare-table th:nth-child(3) { text-align: center; }
    .compare-table td { padding: 1rem 1.5rem; font-size: .9rem; color: rgba(2,0,13,0.72); border-bottom: 1px solid rgba(7,32,63,0.06); }
    .compare-table tr:last-child td { border-bottom: none; }
    .compare-table td:nth-child(2) { text-align: center; background: rgba(7,32,63,0.03); }
    .compare-table td:nth-child(3) { text-align: center; }
    .yes { color: #27ae60; font-size: 1.1rem; }
    .no  { color: #e74c3c; font-size: 1.1rem; }

    .promise-section { padding: 5rem 0; }
    .promise-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; }
    .promise-card { display: grid; grid-template-columns: 56px 1fr; gap: 1.25rem; align-items: flex-start; padding: 1.75rem; border: 1px solid rgba(7,32,63,0.1); background: #fff; transition: .25s ease; }
    .promise-card:hover { box-shadow: 0 10px 28px rgba(7,32,63,0.08); transform: translateY(-3px); }
    .promise-icon { width: 56px; height: 56px; background: rgba(7,32,63,0.06); display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .promise-icon i { font-size: 1.3rem; color: var(--primary-blue); }
    .promise-text h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1rem; font-weight: 600; letter-spacing: .5px; margin-bottom: .5rem; }
    .promise-text p { font-size: .88rem; color: rgba(2,0,13,0.62); line-height: 1.7; }

    .testimonials-section { padding: 5rem 0; background: var(--primary-blue); }
    .testimonials-section .section-title { color: #fff; }
    .testimonials-section .section-eyebrow { color: rgba(255,255,255,0.5); opacity: 1; }
    .testi-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; }
    .testi-card { background: rgba(255,255,255,0.06); border: 1px solid rgba(255,255,255,0.12); padding: 1.75rem; }
    .testi-stars { color: #f39c12; font-size: .9rem; margin-bottom: 1rem; }
    .testi-quote { font-size: .92rem; color: rgba(255,255,255,0.8); line-height: 1.75; margin-bottom: 1.25rem; font-style: italic; }
    .testi-author { font-size: .78rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(255,255,255,0.45); }

    .cta-banner { background: rgba(235,222,212,0.5); padding: 4rem 0; text-align: center; border-top: 1px solid rgba(7,32,63,0.08); }
    .cta-banner h2 { font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; margin-bottom: 1rem; font-weight: 500; }
    .cta-banner p { color: rgba(2,0,13,0.62); font-size: .95rem; margin-bottom: 2rem; }
    .btn-primary-solid { display: inline-block; padding: .95rem 2rem; background: var(--primary-blue); color: #fff; font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; transition: .25s ease; }
    .btn-primary-solid:hover { opacity: .9; }

    @media (max-width: 992px) {
        .pillars-grid { grid-template-columns: 1fr; }
        .pillar { border-right: none; border-bottom: 1px solid rgba(7,32,63,0.1); }
        .testi-grid { grid-template-columns: 1fr; }
        .promise-grid { grid-template-columns: 1fr; }
    }
    @media (max-width: 600px) {
        .compare-table th, .compare-table td { padding: .75rem 1rem; font-size: .82rem; }
    }
</style>
@endpush

@php
    $sections     = collect($page->sections ?? []);
    $pillars      = $sections->firstWhere('type', 'pillars');
    $compare      = $sections->firstWhere('type', 'compare');
    $promises     = $sections->firstWhere('type', 'promises');
    $testimonials = $sections->firstWhere('type', 'testimonials');
@endphp

<main style="padding-top: 80px;">

    {{-- ══ HERO ══ --}}
    <div class="page-hero">
        <img src="{{ $page->hero_image
                ? asset('public/storage/' . $page->hero_image)
                : asset('public/assets/why-us-hero.jpg') }}"
             alt="{{ $page->hero_title ?? 'Why Choose Us' }}">
        <div class="overlay"></div>
        <div class="hero-text">
            @if($page->hero_tag)
                <div class="eyebrow">{{ $page->hero_tag }}</div>
            @endif
            <h1>{{ $page->hero_title ?? 'Why Choose Us' }}</h1>
            @if($page->hero_subtitle)
                <p>{{ $page->hero_subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- ══ PILLARS ══ --}}
    @if($pillars && !empty($pillars['items']))
    <div class="pillars-section">
        <div class="container">
            @if(!empty($pillars['eyebrow']))
                <div class="section-eyebrow">{{ $pillars['eyebrow'] }}</div>
            @endif
            @if(!empty($pillars['heading']))
                <h2 class="section-title">{{ $pillars['heading'] }}</h2>
            @endif
            <div class="pillars-grid">
                @foreach($pillars['items'] as $pillar)
                <div class="pillar">
                    @if(!empty($pillar['num']))
                        <div class="num">{{ $pillar['num'] }}</div>
                    @endif
                    @if(!empty($pillar['icon']))
                        <i class="{{ $pillar['icon'] }}"></i>
                    @endif
                    <h3>{{ $pillar['title'] ?? '' }}</h3>
                    <p>{{ $pillar['body'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ COMPARE ══ --}}
    @if($compare && !empty($compare['items']))
    <div class="compare-section">
        <div class="container">
            @if(!empty($compare['eyebrow']))
                <div class="section-eyebrow">{{ $compare['eyebrow'] }}</div>
            @endif
            @if(!empty($compare['heading']))
                <h2 class="section-title">{{ $compare['heading'] }}</h2>
            @endif
            <table class="compare-table">
                <thead>
                    <tr>
                        <th>Feature</th>
                        <th>Ethnicoast</th>
                        <th>Others</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($compare['items'] as $row)
                    <tr>
                        <td>{{ $row['feature'] ?? '' }}</td>
                        <td>
                            @if($row['us'] === true)
                                <span class="yes">✓</span>
                            @elseif($row['us'] === false)
                                <span class="no">✗</span>
                            @else
                                {{ $row['us'] }}
                            @endif
                        </td>
                        <td>
                            @if($row['them'] === true)
                                <span class="yes">✓</span>
                            @elseif($row['them'] === false)
                                <span class="no">✗</span>
                            @else
                                {{ $row['them'] }}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    {{-- ══ PROMISES ══ --}}
    @if($promises && !empty($promises['items']))
    <div class="promise-section">
        <div class="container">
            @if(!empty($promises['eyebrow']))
                <div class="section-eyebrow">{{ $promises['eyebrow'] }}</div>
            @endif
            @if(!empty($promises['heading']))
                <h2 class="section-title">{{ $promises['heading'] }}</h2>
            @endif
            <div class="promise-grid">
                @foreach($promises['items'] as $promise)
                <div class="promise-card">
                    <div class="promise-icon">
                        <i class="{{ $promise['icon'] ?? 'fa-solid fa-check' }}"></i>
                    </div>
                    <div class="promise-text">
                        <h3>{{ $promise['title'] ?? '' }}</h3>
                        <p>{{ $promise['body'] ?? '' }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ TESTIMONIALS ══ --}}
    @if($testimonials && !empty($testimonials['items']))
    <div class="testimonials-section">
        <div class="container">
            @if(!empty($testimonials['eyebrow']))
                <div class="section-eyebrow">{{ $testimonials['eyebrow'] }}</div>
            @endif
            @if(!empty($testimonials['heading']))
                <h2 class="section-title">{{ $testimonials['heading'] }}</h2>
            @endif
            <div class="testi-grid">
                @foreach($testimonials['items'] as $testi)
                <div class="testi-card">
                    <div class="testi-stars">
                        @for($i = 1; $i <= ($testi['stars'] ?? 5); $i++)★@endfor
                    </div>
                    <div class="testi-quote">"{{ $testi['quote'] ?? '' }}"</div>
                    <div class="testi-author">— {{ $testi['author'] ?? '' }}</div>
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
                   class="btn-primary-solid">
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