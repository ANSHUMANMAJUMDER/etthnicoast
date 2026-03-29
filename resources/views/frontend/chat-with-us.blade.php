@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    img { display: block; max-width: 100%; }
    .container { max-width: var(--container); margin: 0 auto; padding: 0 clamp(1rem, 3vw, 3rem); }

    .page-hero { position: relative; height: 70vh; min-height: 420px; overflow: hidden; display: flex; align-items: flex-end; }
    .page-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
    .page-hero .overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(7,32,63,0.78) 0%, rgba(7,32,63,0.1) 60%); }
    .page-hero .hero-text { position: relative; z-index: 2; padding: 3rem clamp(1rem, 5vw, 5rem); }
    .page-hero .hero-text .eyebrow { display: inline-block; padding: 5px 12px; border: 1px solid rgba(255,255,255,0.35); font-size: .72rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(255,255,255,0.75); margin-bottom: 1rem; }
    .page-hero .hero-text h1 { font-family: var(--font-primary); color: #fff; font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 600; letter-spacing: 3px; text-transform: uppercase; margin-bottom: .75rem; line-height: 1.1; }
    .page-hero .hero-text p { color: rgba(255,255,255,0.7); font-size: .95rem; max-width: 480px; line-height: 1.7; }

    .channels-section { padding: 5rem 0; }
    .section-eyebrow { text-align: center; font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .section-title { text-align: center; font-family: var(--font-primary); color: var(--primary-blue); font-size: clamp(1.5rem, 3vw, 2.2rem); letter-spacing: 2px; text-transform: uppercase; margin-bottom: 3rem; font-weight: 500; }
    .channels-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; }
    .channel-card { padding: 2.5rem 2rem; border: 1px solid rgba(7,32,63,0.1); background: #fff; text-align: center; transition: .25s ease; cursor: pointer; }
    .channel-card:hover { box-shadow: 0 12px 32px rgba(7,32,63,0.1); transform: translateY(-5px); }
    .channel-card .ch-icon { width: 64px; height: 64px; background: rgba(7,32,63,0.06); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.25rem; transition: .25s ease; }
    .channel-card:hover .ch-icon { background: var(--primary-blue); }
    .channel-card .ch-icon i { font-size: 1.5rem; color: var(--primary-blue); transition: .25s ease; }
    .channel-card:hover .ch-icon i { color: #fff; }
    .channel-card h3 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1.05rem; font-weight: 600; letter-spacing: 1px; margin-bottom: .5rem; }
    .channel-card .ch-time { font-size: .75rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(2,0,13,0.45); margin-bottom: 1rem; }
    .channel-card p { font-size: .88rem; color: rgba(2,0,13,0.62); line-height: 1.7; margin-bottom: 1.5rem; }
    .ch-btn { display: inline-block; padding: .75rem 1.5rem; border: 1px solid var(--primary-blue); color: var(--primary-blue); font-size: .8rem; letter-spacing: 1.5px; text-transform: uppercase; font-weight: 700; transition: .25s ease; }
    .ch-btn:hover { background: var(--primary-blue); color: #fff; }

    .faq-section { padding: 5rem 0; background: rgba(235,222,212,0.3); }
    .faq-wrap { max-width: 720px; margin: 0 auto; }
    .faq-item { border-bottom: 1px solid rgba(7,32,63,0.1); }
    .faq-item:first-child { border-top: 1px solid rgba(7,32,63,0.1); }
    .faq-btn { width: 100%; padding: 1.25rem 0; background: transparent; border: none; cursor: pointer; display: flex; justify-content: space-between; align-items: center; gap: 1rem; text-align: left; }
    .faq-btn .q { font-size: .92rem; font-weight: 700; color: rgba(2,0,13,0.85); letter-spacing: .3px; }
    .faq-btn i { transition: transform .25s; color: var(--primary-blue); flex-shrink: 0; }
    .faq-item.open .faq-btn i { transform: rotate(180deg); }
    .faq-ans { display: none; padding: 0 0 1.25rem; font-size: .9rem; color: rgba(2,0,13,0.65); line-height: 1.7; }
    .faq-item.open .faq-ans { display: block; }

    .contact-section { padding: 5rem 0; }
    .contact-grid { display: grid; grid-template-columns: 1fr 1.4fr; gap: 4rem; align-items: flex-start; }
    .contact-info .eyebrow { font-size: .75rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); opacity: .6; margin-bottom: .75rem; }
    .contact-info h2 { font-family: var(--font-primary); color: var(--primary-blue); font-size: 1.8rem; font-weight: 600; letter-spacing: 1px; margin-bottom: 1rem; }
    .contact-info p { font-size: .9rem; color: rgba(2,0,13,0.62); line-height: 1.75; margin-bottom: 2rem; }
    .contact-detail { display: flex; gap: 1rem; align-items: flex-start; margin-bottom: 1.25rem; }
    .contact-detail i { color: var(--primary-blue); font-size: 1rem; margin-top: 3px; flex-shrink: 0; }
    .contact-detail .dt { font-size: .85rem; font-weight: 700; color: rgba(2,0,13,0.8); letter-spacing: .5px; margin-bottom: 2px; }
    .contact-detail .dv { font-size: .88rem; color: rgba(2,0,13,0.6); line-height: 1.5; }
    .contact-form { background: #fff; border: 1px solid rgba(7,32,63,0.1); padding: 2.5rem; }
    .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1rem; }
    .form-field { display: flex; flex-direction: column; gap: 6px; margin-bottom: 1rem; }
    .form-field.half { margin-bottom: 0; }
    .form-field label { font-size: .75rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(2,0,13,0.65); font-weight: 700; }
    .form-field input, .form-field select, .form-field textarea { border: 1px solid rgba(7,32,63,0.2); padding: 11px 13px; font-size: .9rem; outline: none; background: #fff; transition: border-color .2s; font-family: inherit; }
    .form-field input:focus, .form-field select:focus, .form-field textarea:focus { border-color: var(--primary-blue); }
    .form-field textarea { resize: vertical; min-height: 120px; line-height: 1.55; }
    .form-submit { width: 100%; padding: 1rem; background: var(--primary-blue); color: #fff; border: none; cursor: pointer; font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; font-weight: 700; transition: .25s ease; font-family: inherit; }
    .form-submit:hover { opacity: .9; }
    .form-error { display: none; padding: .75rem 1rem; background: rgba(231,76,60,0.08); border: 1px solid rgba(231,76,60,0.25); color: #c0392b; font-size: .88rem; margin-top: 1rem; }
    .form-error.show { display: block; }
    .form-success { display: none; padding: 1rem; background: rgba(39,174,96,0.1); border: 1px solid rgba(39,174,96,0.3); color: #27ae60; font-size: .9rem; text-align: center; margin-top: 1rem; }
    .form-success.show { display: block; }

    @media (max-width: 992px) {
        .channels-grid { grid-template-columns: 1fr; }
        .contact-grid { grid-template-columns: 1fr; gap: 2.5rem; }
        .form-row { grid-template-columns: 1fr; }
    }
</style>
@endpush

@php
    $sections    = collect($page->sections ?? []);
    $channels    = $sections->firstWhere('type', 'channels');
    $faq         = $sections->firstWhere('type', 'faq');
    $contactInfo = $sections->firstWhere('type', 'contact_info');
@endphp

<main style="padding-top: 80px;">

    {{-- ══ HERO ══ --}}
    <div class="page-hero">
        <img src="{{ $page->hero_image
                ? asset('public/storage/' . $page->hero_image)
                : asset('public/assets/chat-hero.jpg') }}"
             alt="{{ $page->hero_title ?? 'Chat With Us' }}">
        <div class="overlay"></div>
        <div class="hero-text">
            @if($page->hero_tag)
                <div class="eyebrow">{{ $page->hero_tag }}</div>
            @endif
            <h1>{{ $page->hero_title ?? 'Chat With Us' }}</h1>
            @if($page->hero_subtitle)
                <p>{{ $page->hero_subtitle }}</p>
            @endif
        </div>
    </div>

    {{-- ══ CHANNELS ══ --}}
    @if($channels && !empty($channels['items']))
    <div class="channels-section">
        <div class="container">
            @if(!empty($channels['eyebrow']))
                <div class="section-eyebrow">{{ $channels['eyebrow'] }}</div>
            @endif
            @if(!empty($channels['heading']))
                <h2 class="section-title">{{ $channels['heading'] }}</h2>
            @endif
            <div class="channels-grid">
                @foreach($channels['items'] as $channel)
                <div class="channel-card">
                    <div class="ch-icon">
                        <i class="{{ $channel['icon'] ?? 'fa-solid fa-comment' }}"></i>
                    </div>
                    <h3>{{ $channel['title'] ?? '' }}</h3>
                    @if(!empty($channel['hours']))
                        <div class="ch-time">{{ $channel['hours'] }}</div>
                    @endif
                    @if(!empty($channel['body']))
                        <p>{{ $channel['body'] }}</p>
                    @endif
                    @if(!empty($channel['btn_text']) && !empty($channel['btn_url']))
                        <a href="{{ $channel['btn_url'] }}" target="_blank" class="ch-btn">
                            {{ $channel['btn_text'] }}
                        </a>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ FAQ ══ --}}
    @if($faq && !empty($faq['items']))
    <div class="faq-section">
        <div class="container">
            @if(!empty($faq['eyebrow']))
                <div class="section-eyebrow">{{ $faq['eyebrow'] }}</div>
            @endif
            @if(!empty($faq['heading']))
                <h2 class="section-title">{{ $faq['heading'] }}</h2>
            @endif
            <div class="faq-wrap" id="faqWrap">
                @foreach($faq['items'] as $index => $item)
                <div class="faq-item {{ $index === 0 ? 'open' : '' }}">
                    <button class="faq-btn" type="button">
                        <span class="q">{{ $item['q'] ?? '' }}</span>
                        <i class="fa-solid fa-chevron-down"></i>
                    </button>
                    <div class="faq-ans">{{ $item['a'] ?? '' }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    {{-- ══ CONTACT FORM ══ --}}
    @if($contactInfo)
    <div class="contact-section">
        <div class="container">
            <div class="contact-grid">

                <div class="contact-info">
                    @if(!empty($contactInfo['eyebrow']))
                        <div class="eyebrow">{{ $contactInfo['eyebrow'] }}</div>
                    @endif
                    @if(!empty($contactInfo['heading']))
                        <h2>{{ $contactInfo['heading'] }}</h2>
                    @endif
                    @if(!empty($contactInfo['body']))
                        <p>{{ $contactInfo['body'] }}</p>
                    @endif
                    @if(!empty($contactInfo['email']))
                    <div class="contact-detail">
                        <i class="fa-solid fa-envelope"></i>
                        <div>
                            <div class="dt">Email</div>
                            <div class="dv">{{ $contactInfo['email'] }}</div>
                        </div>
                    </div>
                    @endif
                    @if(!empty($contactInfo['whatsapp']))
                    <div class="contact-detail">
                        <i class="fa-brands fa-whatsapp"></i>
                        <div>
                            <div class="dt">WhatsApp</div>
                            <div class="dv">
                                {{ $contactInfo['whatsapp'] }}
                                @if(!empty($contactInfo['hours']))
                                    <br>{{ $contactInfo['hours'] }}
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif
                    <div class="contact-detail">
                        <i class="fa-solid fa-clock"></i>
                        <div>
                            <div class="dt">Response Time</div>
                            <div class="dv">Within 24 hours on business days</div>
                        </div>
                    </div>
                </div>

                <div class="contact-form">
                    <div class="form-row">
                        <div class="form-field half">
                            <label for="ctName">Your Name</label>
                            <input id="ctName" type="text"
                                   placeholder="Full name" maxlength="60">
                        </div>
                        <div class="form-field half">
                            <label for="ctEmail">Email Address</label>
                            <input id="ctEmail" type="email"
                                   placeholder="you@email.com">
                        </div>
                    </div>
                    <div class="form-field">
                        <label for="ctSubject">Subject</label>
                        <select id="ctSubject">
                            <option value="">Select a topic…</option>
                            <option>Order / Tracking</option>
                            <option>Exchange / Return</option>
                            <option>Custom Order</option>
                            <option>Lifetime Plating</option>
                            <option>General Query</option>
                        </select>
                    </div>
                    <div class="form-field">
                        <label for="ctMessage">Your Message</label>
                        <textarea id="ctMessage"
                                  placeholder="Tell us what's on your mind…"
                                  maxlength="800"></textarea>
                    </div>
                    <button class="form-submit" id="ctSubmit" type="button">
                        Send Message
                    </button>
                    <div class="form-error" id="ctError">
                        Please fill in all fields before submitting.
                    </div>
                    <div class="form-success" id="ctSuccess">
                        ✓ Message received! We'll get back to you within 24 hours.
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif

</main>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const navbar = document.getElementById("navbar");
    if (navbar) navbar.classList.add("scrolled");

    // ── FAQ accordion ───────────────────────────────────
    document.querySelectorAll('#faqWrap .faq-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            const item   = btn.closest('.faq-item');
            const isOpen = item.classList.contains('open');
            document.querySelectorAll('#faqWrap .faq-item')
                    .forEach(i => i.classList.remove('open'));
            if (!isOpen) item.classList.add('open');
        });
    });

    // ── Contact form ────────────────────────────────────
    document.getElementById('ctSubmit')?.addEventListener('click', () => {
        const name    = document.getElementById('ctName').value.trim();
        const email   = document.getElementById('ctEmail').value.trim();
        const subject = document.getElementById('ctSubject').value;
        const message = document.getElementById('ctMessage').value.trim();
        const errEl   = document.getElementById('ctError');
        const sucEl   = document.getElementById('ctSuccess');
        const btn     = document.getElementById('ctSubmit');

        errEl.classList.remove('show');
        sucEl.classList.remove('show');

        if (!name || !email || !subject || !message) {
            errEl.textContent = 'Please fill in all fields before submitting.';
            errEl.classList.add('show');
            return;
        }

        btn.disabled    = true;
        btn.textContent = 'Sending…';

        fetch('{{ route("frontend.contact.store") }}', {
            method:  'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content ?? '',
                'Accept':       'application/json',
            },
            body: JSON.stringify({ name, email, subject, message }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                sucEl.textContent = '✓ ' + data.message;
                sucEl.classList.add('show');
                btn.textContent = 'Message Sent ✓';
                document.getElementById('ctName').value    = '';
                document.getElementById('ctEmail').value   = '';
                document.getElementById('ctSubject').value = '';
                document.getElementById('ctMessage').value = '';
            } else {
                const errors = data.errors
                    ? Object.values(data.errors).flat().join(' ')
                    : (data.message || 'Something went wrong.');
                errEl.textContent = errors;
                errEl.classList.add('show');
                btn.disabled    = false;
                btn.textContent = 'Send Message';
            }
        })
        .catch(() => {
            errEl.textContent = 'Network error. Please try again.';
            errEl.classList.add('show');
            btn.disabled    = false;
            btn.textContent = 'Send Message';
        });
    });

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