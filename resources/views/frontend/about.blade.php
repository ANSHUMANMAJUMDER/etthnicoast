@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    img { display: block; max-width: 100%; }
    .container { max-width: var(--container); margin: 0 auto; padding: 0 clamp(1rem, 3vw, 3rem); }

    .about-hero { position: relative; height: 70vh; min-height: 420px; overflow: hidden; display: flex; align-items: flex-end; }
    .about-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .about-hero .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(7,32,63,0.72) 0%, rgba(7,32,63,0.1) 60%); }
    .about-hero .hero-text { position: relative; z-index: 2; padding: 3rem clamp(1rem, 5vw, 5rem); }
    .about-hero h1 { font-family: var(--font-primary); color: #fff; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 600; letter-spacing: 3px; text-transform: uppercase; margin-bottom: .5rem; }
    .about-hero p { color: rgba(255,255,255,0.75); font-size: 1rem; letter-spacing: 1px; max-width: 480px; }

    .about-intro { padding: 5rem 0 3rem; }
    .about-intro .eyebrow { font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: 1rem; }
    .about-intro h2 { font-family: var(--font-primary); font-size: clamp(1.6rem, 3vw, 2.5rem); font-weight: 600; color: var(--primary-blue); line-height: 1.2; letter-spacing: 1.5px; margin-bottom: 1.5rem; }
    .about-intro p { color: rgba(2,0,13,0.65); line-height: 1.85; font-size: .95rem; margin-bottom: 1rem; max-width: 680px; }

    .stats-strip { background: var(--primary-blue); padding: 3rem 0; }
    .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 2rem; text-align: center; }
    .stat .num { font-family: var(--font-primary); font-size: clamp(2rem, 4vw, 3rem); font-weight: 700; color: #fff; letter-spacing: 2px; line-height: 1; margin-bottom: .5rem; }
    .stat .lbl { font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.55); }

    .story-section { padding: 5rem 0; }
    .section-eyebrow { text-align: center; font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .section-title { text-align: center; font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 3.5rem; font-weight: 500; }

    .timeline { position: relative; max-width: 780px; margin: 0 auto; }
    .timeline::before { content: ''; position: absolute; left: 50%; top: 0; bottom: 0; width: 1px; background: rgba(7,32,63,0.12); transform: translateX(-50%); }
    .tl-item { display: grid; grid-template-columns: 1fr 48px 1fr; gap: 1.5rem; align-items: center; margin-bottom: 3rem; }
    .tl-item:last-child { margin-bottom: 0; }
    .tl-text { padding: 1.5rem; border: 1px solid rgba(7,32,63,0.1); background: rgba(235,222,212,0.18); }
    .tl-text.right { text-align: right; }
    .tl-year { font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .5rem; }
    .tl-text h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1.05rem; font-weight: 600; margin-bottom: .5rem; letter-spacing: .5px; }
    .tl-text p { font-size: .88rem; color: rgba(2,0,13,0.65); line-height: 1.7; }
    .tl-dot { width: 14px; height: 14px; border-radius: 50%; background: var(--primary-blue); margin: 0 auto; position: relative; z-index: 1; }
    .tl-empty { }

    .team-section { padding: 5rem 0; background: rgba(235,222,212,0.3); }
    .team-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; max-width: 900px; margin: 0 auto; }
    .team-card { text-align: center; }
    .team-card .avatar { width: 100%; aspect-ratio: 1; overflow: hidden; margin-bottom: 1rem; background: rgba(7,32,63,0.06); display: flex; align-items: center; justify-content: center; }
    .team-card .avatar i { font-size: 3rem; color: rgba(7,32,63,0.2); }
    .team-card .name { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1rem; font-weight: 600; letter-spacing: 1px; margin-bottom: .25rem; }
    .team-card .role { font-size: .78rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(2,0,13,0.5); }

    .values-section { padding: 5rem 0; }
    .values-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .value-card { padding: 2rem 1.5rem; border: 1px solid rgba(7,32,63,0.1); background: #fff; text-align: center; transition: .25s ease; }
    .value-card:hover { box-shadow: 0 12px 32px rgba(7,32,63,0.08); transform: translateY(-4px); }
    .value-card i { font-size: 1.6rem; color: var(--primary-blue); margin-bottom: 1rem; display: block; }
    .value-card h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1rem; font-weight: 600; letter-spacing: 1px; margin-bottom: .75rem; }
    .value-card p { font-size: .88rem; color: rgba(2,0,13,0.6); line-height: 1.7; }

    .cta-banner { background: var(--primary-blue); padding: 4rem 0; text-align: center; }
    .cta-banner h2 { font-family: var(--font-primary); color: #fff; font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; margin-bottom: 1rem; font-weight: 500; }
    .cta-banner p { color: rgba(255,255,255,0.65); font-size: .95rem; margin-bottom: 2rem; letter-spacing: .5px; }
    .btn-white { display: inline-block; padding: .95rem 2rem; background: #fff; color: var(--primary-blue); font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; transition: .25s ease; }
    .btn-white:hover { opacity: .9; }

    @media (max-width: 992px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); }
        .values-grid { grid-template-columns: repeat(2, 1fr); }
        .team-grid { grid-template-columns: repeat(2, 1fr); }
        .timeline::before { left: 24px; }
        .tl-item { grid-template-columns: 48px 1fr; }
        .tl-text.right { text-align: left; grid-column: 2; grid-row: 1; }
        .tl-empty { display: none; }
    }
    @media (max-width: 600px) {
        .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 1.5rem; }
        .values-grid { grid-template-columns: 1fr; }
        .team-grid { grid-template-columns: 1fr 1fr; }
    }
</style>
@endpush

@php
    $sections = collect($page->sections ?? []);
    $intro    = $sections->firstWhere('type', 'intro');
    $timeline = $sections->firstWhere('type', 'timeline');
    $team     = $sections->firstWhere('type', 'team');
    $values   = $sections->firstWhere('type', 'values');
@endphp

<main style="padding-top: 80px;">

    {{-- ══ HERO ══ --}}
    <div class="about-hero">
        <img src="{{ $page->hero_image
                ? asset('public/storage/' . $page->hero_image)
                : asset('public/assets/about-hero.jpg') }}"
             alt="{{ $page->hero_title ?? 'About Us' }}">
        <div class="overlay"></div>
        <div class="hero-text">
            <h1>{{ $page->hero_title ?? 'Our Story' }}</h1>
            @if($page->hero_subtitle)
                <p>{{ $page->hero_subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- ══ INTRO (text only, no image) ══ --}}
    @if($intro)
    <div class="container">
        <div class="about-intro">
            @if(!empty($intro['eyebrow']))
                <div class="eyebrow">{{ $intro['eyebrow'] }}</div>
            @endif
            @if(!empty($intro['heading']))
                <h2>{{ $intro['heading'] }}</h2>
            @endif
            @foreach(explode("\n\n", $intro['body'] ?? '') as $para)
                @if(trim($para))
                    <p>{{ trim($para) }}</p>
                @endif
            @endforeach
        </div>
    </div>
    @endif

    {{-- ══ STATS ══ --}}
    @if($page->stats && count($page->stats))
    <div class="stats-strip">
        <div class="container">
            <div class="stats-grid">
                @foreach($page->stats as $stat)
                <div class="stat">
                    <div class="num">{{ $stat['num'] ?? '' }}</div>
                    <div class="lbl">{{ $stat['label'] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ TIMELINE ══ --}}
    @if($timeline && !empty($timeline['items']))
    <div class="story-section">
        <div class="container">
            @if(!empty($timeline['eyebrow']))
                <div class="section-eyebrow">{{ $timeline['eyebrow'] }}</div>
            @endif
            @if(!empty($timeline['heading']))
                <h2 class="section-title">{{ $timeline['heading'] }}</h2>
            @endif
            <div class="timeline">
                @foreach($timeline['items'] as $index => $item)
                <div class="tl-item">
                    @if($index % 2 === 0)
                        <div class="tl-text right">
                            @if(!empty($item['year']))
                                <div class="tl-year">{{ $item['year'] }}</div>
                            @endif
                            <h3>{{ $item['title'] ?? '' }}</h3>
                            <p>{{ $item['body'] ?? '' }}</p>
                        </div>
                        <div class="tl-dot"></div>
                        <div class="tl-empty"></div>
                    @else
                        <div class="tl-empty"></div>
                        <div class="tl-dot"></div>
                        <div class="tl-text">
                            @if(!empty($item['year']))
                                <div class="tl-year">{{ $item['year'] }}</div>
                            @endif
                            <h3>{{ $item['title'] ?? '' }}</h3>
                            <p>{{ $item['body'] ?? '' }}</p>
                        </div>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ TEAM (no avatar images — icon placeholder only) ══ --}}
    @if($team && !empty($team['items']))
    <div class="team-section">
        <div class="container">
            @if(!empty($team['eyebrow']))
                <div class="section-eyebrow">{{ $team['eyebrow'] }}</div>
            @endif
            @if(!empty($team['heading']))
                <h2 class="section-title">{{ $team['heading'] }}</h2>
            @endif
            <div class="team-grid">
                @foreach($team['items'] as $member)
                <div class="team-card">
                    <div class="avatar">
                        <i class="fa-solid fa-user"></i>
                    </div>
                    <div class="name">{{ $member['name'] ?? '' }}</div>
                    <div class="role">{{ $member['role'] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ VALUES ══ --}}
    @if($values && !empty($values['items']))
    <div class="values-section">
        <div class="container">
            @if(!empty($values['eyebrow']))
                <div class="section-eyebrow">{{ $values['eyebrow'] }}</div>
            @endif
            @if(!empty($values['heading']))
                <h2 class="section-title">{{ $values['heading'] }}</h2>
            @endif
            <div class="values-grid">
                @foreach($values['items'] as $val)
                <div class="value-card">
                    @if(!empty($val['icon']))
                        <i class="{{ $val['icon'] }}"></i>
                    @endif
                    <h3>{{ $val['title'] ?? '' }}</h3>
                    <p>{{ $val['body'] ?? '' }}</p>
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
                   class="btn-white">
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