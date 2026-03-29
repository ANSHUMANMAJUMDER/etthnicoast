@extends('frontend.layouts.master')
@section('body-class', 'no-navbar-scroll')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    button { font-family: inherit; }

    .cart-wrap { max-width: 1200px; margin: 0 auto; padding: 2rem clamp(1rem, 3vw, 3rem) 5rem; }
    .cart-header { display: flex; align-items: center; justify-content: space-between; padding-bottom: 1rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(7,32,63,0.08); }
    .cart-header h1 { font-family: var(--font-primary); font-size: 1.8rem; font-weight: 400; letter-spacing: 3px; color: var(--primary-blue); text-transform: uppercase; }
    .cart-count-badge { font-family: var(--font-secondary); font-size: .75rem; letter-spacing: 2px; color: rgba(2,0,13,0.45); text-transform: uppercase; }

    .cart-layout { display: grid; grid-template-columns: 1fr 360px; gap: 2rem; align-items: start; }
    .cart-items { display: flex; flex-direction: column; }

    .cart-item { display: grid; grid-template-columns: 110px 1fr auto; gap: 1.25rem; align-items: center; padding: 18px 0; border-bottom: 1px solid rgba(7,32,63,0.07); }
    .cart-item:first-child { border-top: 1px solid rgba(7,32,63,0.07); }
    .cart-img { width: 110px; height: 130px; background: #f7f7f7; overflow: hidden; flex-shrink: 0; }
    .cart-img img { width: 100%; height: 100%; object-fit: cover; }

    .cart-info { min-width: 0; }
    .cart-category { font-family: var(--font-secondary); font-size: .65rem; letter-spacing: 2.5px; text-transform: uppercase; color: rgba(7,32,63,0.4); margin-bottom: 4px; }
    .cart-name { font-family: var(--font-primary); font-size: 1.1rem; color: var(--primary-blue); margin-bottom: 4px; line-height: 1.3; }
    .cart-code { font-family: var(--font-secondary); font-size: .7rem; letter-spacing: 1.5px; color: rgba(2,0,13,0.35); text-transform: uppercase; margin-bottom: 10px; }
    .cart-variant { font-family: var(--font-secondary); font-size: .75rem; color: rgba(2,0,13,0.5); margin-bottom: 10px; }

    .qty-row { display: flex; align-items: center; border: 1px solid rgba(7,32,63,0.18); width: fit-content; }
    .qty-btn { width: 32px; height: 32px; background: var(--white); border: none; cursor: pointer; font-size: 1rem; color: var(--primary-blue); display: flex; align-items: center; justify-content: center; transition: background .2s; }
    .qty-btn:hover { background: rgba(7,32,63,0.05); }
    .qty-input { width: 40px; height: 32px; border: none; border-left: 1px solid rgba(7,32,63,0.18); border-right: 1px solid rgba(7,32,63,0.18); text-align: center; font-size: .9rem; color: var(--primary-blue); font-weight: 700; outline: none; background: var(--white); }

    .cart-right { display: flex; flex-direction: column; align-items: flex-end; gap: 10px; min-width: 90px; }
    .cart-item-price { font-family: var(--font-primary); font-size: 1.1rem; font-weight: 700; color: var(--primary-blue); }
    .cart-unit-price { font-family: var(--font-secondary); font-size: .72rem; color: rgba(2,0,13,0.4); letter-spacing: .5px; }
    .cart-remove { background: none; border: none; cursor: pointer; color: rgba(2,0,13,0.35); font-size: .8rem; display: flex; align-items: center; gap: 5px; padding: 4px 0; transition: color .2s; font-family: var(--font-secondary); letter-spacing: 1px; text-transform: uppercase; }
    .cart-remove:hover { color: #e74c3c; }

    .cart-summary { background: var(--white); border: 1px solid rgba(7,32,63,0.08); padding: 1.5rem; position: sticky; top: 160px; }
    .summary-title { font-family: var(--font-secondary); font-size: .7rem; letter-spacing: 3px; text-transform: uppercase; color: var(--primary-blue); font-weight: 700; margin-bottom: 1.25rem; padding-bottom: .75rem; border-bottom: 1px solid rgba(7,32,63,0.08); }
    .summary-row { display: flex; justify-content: space-between; align-items: center; font-family: var(--font-secondary); font-size: .85rem; color: rgba(2,0,13,0.7); margin-bottom: .75rem; }
    .summary-row.total { font-size: 1rem; font-weight: 800; color: var(--primary-blue); padding-top: .75rem; margin-top: .5rem; border-top: 1px solid rgba(7,32,63,0.08); margin-bottom: 1.25rem; }
    .free { color: #27ae60; font-weight: 700; }

    .coupon-row { display: flex; gap: 8px; margin-bottom: 1.25rem; }
    .coupon-input { flex: 1; padding: 10px 12px; border: 1px solid rgba(7,32,63,0.2); font-size: .82rem; outline: none; font-family: var(--font-secondary); letter-spacing: 1px; text-transform: uppercase; }
    .coupon-apply { padding: 10px 14px; background: var(--primary-blue); color: var(--white); border: none; cursor: pointer; font-family: var(--font-secondary); font-size: .75rem; letter-spacing: 1.5px; text-transform: uppercase; }
    .coupon-apply:hover { filter: brightness(.9); }

    .btn-checkout { width: 100%; padding: 1rem; background: var(--primary-blue); color: var(--white); border: none; cursor: pointer; font-family: var(--font-secondary); font-size: .82rem; letter-spacing: 2px; text-transform: uppercase; transition: .25s; margin-bottom: .75rem; }
    .btn-checkout:hover { filter: brightness(.92); }
    .btn-continue { display: block; text-align: center; width: 100%; padding: .85rem; border: 1px solid rgba(7,32,63,0.2); background: var(--white); color: var(--primary-blue); font-family: var(--font-secondary); font-size: .78rem; letter-spacing: 1.5px; text-transform: uppercase; }
    .btn-continue:hover { background: rgba(7,32,63,0.04); }

    .cart-empty { text-align: center; padding: 5rem 1rem; color: rgba(2,0,13,0.4); }
    .cart-empty i { font-size: 3rem; display: block; margin-bottom: 1rem; color: rgba(7,32,63,0.12); }
    .cart-empty p { font-family: var(--font-secondary); font-size: .85rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.5rem; }

    .cart-usp { display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem; margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid rgba(7,32,63,0.06); }
    .usp-item { text-align: center; font-family: var(--font-secondary); font-size: .72rem; letter-spacing: 1px; color: rgba(2,0,13,0.55); text-transform: uppercase; }
    .usp-item i { display: block; font-size: 1.2rem; color: var(--primary-blue); margin-bottom: 6px; }

    .toast { position: fixed; right: 16px; bottom: 16px; background: var(--primary-blue); color: var(--white); padding: 12px 16px; font-size: .88rem; box-shadow: 0 10px 24px rgba(7,32,63,0.2); transform: translateY(18px); opacity: 0; pointer-events: none; transition: .25s ease; z-index: 3000; }
    .toast.show { opacity: 1; transform: translateY(0); }

    @media (max-width: 900px) { .cart-layout { grid-template-columns: 1fr; } .cart-summary { position: static; } }
    @media (max-width: 560px) {
        .cart-item { grid-template-columns: 90px 1fr; }
        .cart-right { flex-direction: row; align-items: center; grid-column: 1 / -1; justify-content: space-between; }
        .cart-img { width: 90px; height: 110px; }
        .cart-usp { grid-template-columns: 1fr; }
    }
</style>
@endpush

<div style="padding-top: 155px;">
<div class="cart-wrap">

    <div class="cart-header">
        <h1>My Cart</h1>
        <span class="cart-count-badge" id="cartItemCount">
            {{ $items->count() }} {{ Str::plural('item', $items->count()) }}
        </span>
    </div>

    @if($items->count())

    <div class="cart-layout">

        {{-- ── Items ── --}}
        <div class="cart-items" id="cartItemsContainer">
            @foreach($items as $item)
                @php
                    $product  = $item->product;
                    $thumb    = $product?->images->first()?->image ?? null;
                    $thumbUrl = $thumb
                        ? asset('public/storage/' . $thumb)
                        : 'https://via.placeholder.com/220x260?text=No+Image';
                @endphp

                <div class="cart-item" id="cart-row-{{ $item->id }}">

                    <a href="{{ route('frontend.product-details', $product->id) }}">
                        <div class="cart-img">
                            <img src="{{ $thumbUrl }}"
                                 alt="{{ $product->base_name }}" loading="lazy">
                        </div>
                    </a>

                    <div class="cart-info">
                        <div class="cart-category">
                            {{ $product->pearlType?->name ?? 'Jewellery' }}
                        </div>
                        <a href="{{ route('frontend.product-details', $product->id) }}">
                            <div class="cart-name">{{ $product->base_name }}</div>
                        </a>
                        <div class="cart-code">SKU: {{ $product->product_code }}</div>

                        @if($item->variant)
                            <div class="cart-variant">
                                Finish: {{ $item->variant->finish }}
                            </div>
                        @endif

                        <div class="qty-row">
                            <button class="qty-btn qty-minus"
                                    data-item-id="{{ $item->id }}"
                                    data-url="{{ route('cart.updateQuantity') }}">−</button>
                            <input  class="qty-input"
                                    type="number"
                                    value="{{ $item->quantity }}"
                                    min="1" max="99"
                                    id="qty-{{ $item->id }}"
                                    readonly>
                            <button class="qty-btn qty-plus"
                                    data-item-id="{{ $item->id }}"
                                    data-url="{{ route('cart.updateQuantity') }}">+</button>
                        </div>
                    </div>

                    <div class="cart-right">
                        <div>
                            <div class="cart-item-price" id="subtotal-{{ $item->id }}">
                                ₹{{ number_format($item->total_price) }}
                            </div>
                            <div class="cart-unit-price">
                                ₹{{ number_format($item->price) }} each
                            </div>
                        </div>
                        <button class="cart-remove"
                                data-item-id="{{ $item->id }}"
                                data-product-id="{{ $product->id }}"
                                data-url="{{ route('cart.destroy') }}">
                            <i class="fa-solid fa-trash-can"></i> Remove
                        </button>
                    </div>

                </div>
            @endforeach
        </div>

        {{-- ── Summary ── --}}
        <div class="cart-summary">
            <div class="summary-title">Order Summary</div>

            <div class="summary-row">
                <span>Subtotal</span>
                <span id="summarySubtotal">₹{{ number_format($subtotal) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping</span>
                <span id="summaryShipping">
                    @if($shipping == 0)
                        <span class="free">Free</span>
                    @else
                        ₹{{ number_format($shipping) }}
                    @endif
                </span>
            </div>
            @if($subtotal > 0 && $subtotal < 999)
                <div style="font-size:.75rem; color:rgba(2,0,13,0.45); margin-bottom:.75rem; font-family:var(--font-secondary);">
                    Add ₹{{ number_format(999 - $subtotal) }} more for free shipping
                </div>
            @endif

            <div class="summary-row total">
                <span>Total</span>
                <span id="summaryTotal">₹{{ number_format($total) }}</span>
            </div>

            <div class="coupon-row">
                <input class="coupon-input" type="text"
                       id="couponCode" placeholder="COUPON CODE">
                <button class="coupon-apply" id="couponApplyBtn">Apply</button>
            </div>

            <button class="btn-checkout" id="checkoutBtn">
                Proceed to Checkout
            </button>
            <a href="{{ route('collection.show') }}" class="btn-continue">
                Continue Shopping
            </a>

            <div class="cart-usp">
                <div class="usp-item">
                    <i class="fa-solid fa-rotate-left"></i>30 Day Returns
                </div>
                <div class="usp-item">
                    <i class="fa-solid fa-truck"></i>Free over ₹999
                </div>
                <div class="usp-item">
                    <i class="fa-solid fa-lock"></i>Secure Checkout
                </div>
            </div>
        </div>

    </div>

    @else
        <div class="cart-empty">
            <i class="fa-solid fa-cart-shopping"></i>
            <p>Your cart is empty</p>
            <a href="{{ route('collection.show') }}"
               style="display:inline-block; padding:12px 32px; background:var(--primary-blue); color:var(--white); font-family:var(--font-secondary); font-size:.78rem; letter-spacing:2px; text-transform:uppercase;">
                Browse Collections
            </a>
        </div>
    @endif

</div>
</div>

<div class="toast" id="toast"></div>

@push('scripts')
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    // ── Navbar ────────────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    if (navbar) navbar.classList.add('scrolled');

    // ── Logo ──────────────────────────────────────────────────
    const navLogo = document.getElementById('navLogo');
    if (navLogo) {
        navLogo.src = '{{ asset("public/assets/logo_new_1.png") }}';
        navLogo.setAttribute('data-src', '{{ asset("public/assets/logo_new_1.png") }}');
    }

});

// ── Globals ───────────────────────────────────────────────────────────────
document.body.classList.add('no-navbar-scroll');

const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const toast     = document.getElementById('toast');

function showToast(msg) {
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}
function formatINR(n) {
    const num = parseFloat(String(n).replace(/,/g, ''));
    if (isNaN(num)) return '₹0';
    return '₹' + num.toLocaleString('en-IN', {
        minimumFractionDigits: 0,
        maximumFractionDigits: 2,
    });
}
function updateNavCount(count) {
    const el = document.getElementById('cartCount');
    if (el) el.textContent = count || '';
}
function updateSummary(data) {
    const sub   = document.getElementById('summarySubtotal');
    const ship  = document.getElementById('summaryShipping');
    const total = document.getElementById('summaryTotal');
    const badge = document.getElementById('cartItemCount');

    if (sub)   sub.textContent   = formatINR(data.cart_total);
    if (total) total.textContent = formatINR(data.grand_total);
    if (ship)  ship.innerHTML    = data.shipping == 0
        ? '<span class="free">Free</span>'
        : formatINR(data.shipping);
    if (badge) {
        const c = data.cart_count;
        badge.textContent = c + ' ' + (c == 1 ? 'item' : 'items');
    }
    updateNavCount(data.cart_count);
}

// ── Quantity +/- ──────────────────────────────────────────────────────────
function updateQty(itemId, newQty, url) {
    fetch(url, {
        method:  'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept':       'application/json',
        },
        body: JSON.stringify({ cart_item_id: itemId, quantity: newQty }),
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (data.success) {
            document.getElementById('qty-' + itemId).value            = newQty;
            document.getElementById('subtotal-' + itemId).textContent = formatINR(data.item_subtotal);
            updateSummary(data);
        }
    })
    .catch(() => showToast('Something went wrong.'));
}

document.querySelectorAll('.qty-minus').forEach(btn => {
    btn.addEventListener('click', function () {
        const id  = this.dataset.itemId;
        const qty = parseInt(document.getElementById('qty-' + id).value);
        if (qty <= 1) return;
        updateQty(id, qty - 1, this.dataset.url);
    });
});
document.querySelectorAll('.qty-plus').forEach(btn => {
    btn.addEventListener('click', function () {
        const id  = this.dataset.itemId;
        const qty = parseInt(document.getElementById('qty-' + id).value);
        if (qty >= 99) return;
        updateQty(id, qty + 1, this.dataset.url);
    });
});

// ── Remove ────────────────────────────────────────────────────────────────
document.querySelectorAll('.cart-remove').forEach(btn => {
    btn.addEventListener('click', function () {
        const itemId    = this.dataset.itemId;
        const productId = this.dataset.productId;
        const row       = document.getElementById('cart-row-' + itemId);

        fetch(this.dataset.url, {
            method:  'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept':       'application/json',
            },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.redirect) { window.location.href = data.redirect; return; }
            if (data.success) {
                row?.remove();
                updateNavCount(data.cart_count);
                updateSummary(data);
                showToast('Item removed ✓');
                if (!document.querySelector('.cart-item')) window.location.reload();
            }
        })
        .catch(() => showToast('Something went wrong.'));
    });
});

// ── Coupon ────────────────────────────────────────────────────────────────
document.getElementById('couponApplyBtn')?.addEventListener('click', function () {
    const code = document.getElementById('couponCode').value.trim().toUpperCase();
    if (!code) { showToast('Enter a coupon code'); return; }
    showToast(code === 'ETTH10' ? 'Coupon applied! 10% off ✓' : 'Invalid coupon code');
});

// ── Checkout → Razorpay ───────────────────────────────────────────────────
document.getElementById('checkoutBtn')?.addEventListener('click', function () {
    const btn = this;
    btn.disabled    = true;
    btn.textContent = 'Please wait…';

    fetch('{{ route("order.cart.razorpay.create") }}', {
        method:  'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept':       'application/json',
        },
        body: JSON.stringify({}),
    })
    .then(r => r.json())
    .then(data => {
        if (data.redirect) { window.location.href = data.redirect; return; }
        if (!data.success) {
            showToast(data.message || 'Failed to initiate payment.');
            btn.disabled    = false;
            btn.textContent = 'Proceed to Checkout';
            return;
        }

        const options = {
            key         : data.key,
            amount      : data.amount,
            currency    : data.currency,
            name        : 'Etthnicoast',
            description : data.product_name,
            order_id    : data.razorpay_order_id,
            prefill: {
                name  : '{{ addslashes(auth("frontend")->user()?->name ?? "") }}',
                email : '{{ addslashes(auth("frontend")->user()?->email ?? "") }}',
            },
            theme: { color: '#07203F' },

            handler: function (response) {
                fetch('{{ route("order.cart.verify") }}', {
                    method:  'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept':       'application/json',
                    },
                    body: JSON.stringify({
                        razorpay_order_id   : response.razorpay_order_id,
                        razorpay_payment_id : response.razorpay_payment_id,
                        razorpay_signature  : response.razorpay_signature,
                    }),
                })
                .then(r => r.json())
                .then(res => {
                    if (res.success) {
                        window.location.href = res.redirect;
                    } else {
                        showToast(res.message || 'Payment verification failed.');
                        btn.disabled    = false;
                        btn.textContent = 'Proceed to Checkout';
                    }
                })
                .catch(() => {
                    showToast('Something went wrong.');
                    btn.disabled    = false;
                    btn.textContent = 'Proceed to Checkout';
                });
            },

            modal: {
                ondismiss: function () {
                    btn.disabled    = false;
                    btn.textContent = 'Proceed to Checkout';
                }
            }
        };

        new Razorpay(options).open();
    })
    .catch(() => {
        showToast('Something went wrong.');
        btn.disabled    = false;
        btn.textContent = 'Proceed to Checkout';
    });
});
</script>
@endpush

@endsection