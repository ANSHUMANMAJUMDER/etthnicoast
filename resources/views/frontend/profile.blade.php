@extends('frontend.layouts.master')
@section('contents')
@push('styles')
<style>
    a { text-decoration: none; color: inherit; }
    button { font-family: inherit; }

    .profile-wrap {
        max-width: 1100px;
        margin: 0 auto;
        padding: 2rem clamp(1rem, 3vw, 3rem) 5rem;
    }

    .profile-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
        border-bottom: 1px solid rgba(7,32,63,0.08);
    }
    .profile-header h1 {
        font-family: var(--font-primary);
        font-size: 1.8rem;
        font-weight: 400;
        letter-spacing: 3px;
        color: var(--primary-blue);
        text-transform: uppercase;
    }
    .logout-btn {
        font-family: var(--font-secondary);
        font-size: .72rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(2,0,13,0.45);
        border: 1px solid rgba(7,32,63,0.15);
        padding: 8px 16px;
        background: none;
        cursor: pointer;
        transition: .2s;
        text-decoration: none;
        display: inline-block;
    }
    .logout-btn:hover { border-color: #e74c3c; color: #e74c3c; }

    .profile-layout {
        display: grid;
        grid-template-columns: 280px 1fr;
        gap: 2rem;
        align-items: start;
    }

    /* ── User card ── */
    .user-card {
        border: 1px solid rgba(7,32,63,0.08);
        background: var(--white);
        overflow: hidden;
        position: sticky;
        top: 160px;
    }
    .user-card-top {
        background: var(--primary-blue);
        padding: 2rem 1.5rem;
        text-align: center;
    }
    .user-avatar {
        width: 72px; height: 72px;
        background: var(--secondary-peach);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 1rem;
        font-family: var(--font-primary);
        font-size: 1.8rem;
        color: var(--primary-blue);
        font-weight: 600;
        text-transform: uppercase;
    }
    .user-name  { font-family: var(--font-primary); font-size: 1.1rem; font-weight: 400; color: var(--white); letter-spacing: 1px; margin-bottom: 4px; }
    .user-email { font-family: var(--font-secondary); font-size: .72rem; letter-spacing: 1px; color: rgba(255,255,255,0.6); }
    .user-card-body { padding: 1.25rem 1.5rem; }
    .info-row { display: flex; flex-direction: column; gap: 3px; margin-bottom: 1rem; padding-bottom: 1rem; border-bottom: 1px solid rgba(7,32,63,0.06); }
    .info-row:last-child { border-bottom: none; margin-bottom: 0; padding-bottom: 0; }
    .info-label { font-family: var(--font-secondary); font-size: .62rem; letter-spacing: 2px; text-transform: uppercase; color: rgba(2,0,13,0.35); }
    .info-value { font-family: var(--font-secondary); font-size: .85rem; color: var(--primary-blue); font-weight: 500; }

    .stats-row { display: grid; grid-template-columns: repeat(3, 1fr); border-top: 1px solid rgba(7,32,63,0.08); }
    .stat-box { padding: .85rem .5rem; text-align: center; border-right: 1px solid rgba(7,32,63,0.08); }
    .stat-box:last-child { border-right: none; }
    .stat-num { font-family: var(--font-primary); font-size: 1.3rem; font-weight: 600; color: var(--primary-blue); }
    .stat-lbl { font-family: var(--font-secondary); font-size: .58rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(2,0,13,0.4); margin-top: 2px; }

    /* ── Sidebar nav links ── */
    .profile-nav { border-top: 1px solid rgba(7,32,63,0.08); }
    .profile-nav-btn {
        display: flex;
        align-items: center;
        gap: 10px;
        width: 100%;
        padding: 13px 1.5rem;
        background: none;
        border: none;
        border-bottom: 1px solid rgba(7,32,63,0.06);
        font-family: var(--font-secondary);
        font-size: .75rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        color: rgba(2,0,13,0.55);
        cursor: pointer;
        transition: .2s;
        text-align: left;
    }
    .profile-nav-btn:last-child { border-bottom: none; }
    .profile-nav-btn i { width: 16px; color: rgba(7,32,63,0.3); font-size: .8rem; }
    .profile-nav-btn:hover { background: rgba(7,32,63,0.03); color: var(--primary-blue); }
    .profile-nav-btn:hover i { color: var(--primary-blue); }
    .profile-nav-btn.active { background: rgba(7,32,63,0.04); color: var(--primary-blue); font-weight: 700; }
    .profile-nav-btn.active i { color: var(--primary-blue); }
    .nav-count {
        margin-left: auto;
        background: var(--primary-blue);
        color: var(--white);
        font-size: .58rem;
        padding: 2px 7px;
        border-radius: 10px;
        letter-spacing: 0;
    }

    /* ── Tabs (right content) ── */
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    .section-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 1.25rem;
    }
    .section-head h2 {
        font-family: var(--font-secondary);
        font-size: .68rem;
        letter-spacing: 3px;
        text-transform: uppercase;
        color: var(--primary-blue);
        font-weight: 700;
    }
    .section-badge {
        font-family: var(--font-secondary);
        font-size: .65rem;
        letter-spacing: 1.5px;
        color: rgba(2,0,13,0.4);
        text-transform: uppercase;
    }

    /* ── Order cards ── */
    .order-card { border: 1px solid rgba(7,32,63,0.08); background: var(--white); margin-bottom: 1rem; overflow: hidden; }
    .order-card-head {
        display: flex; align-items: center; justify-content: space-between;
        padding: 14px 18px;
        background: rgba(7,32,63,0.02);
        border-bottom: 1px solid rgba(7,32,63,0.06);
        flex-wrap: wrap; gap: 10px;
        cursor: pointer; user-select: none;
    }
    .order-meta { display: flex; gap: 1.5rem; flex-wrap: wrap; align-items: center; }
    .order-meta-item { display: flex; flex-direction: column; gap: 2px; }
    .oml { font-family: var(--font-secondary); font-size: .6rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(2,0,13,0.35); }
    .omv { font-family: var(--font-secondary); font-size: .82rem; color: var(--primary-blue); font-weight: 600; }
    .order-status { font-family: var(--font-secondary); font-size: .65rem; letter-spacing: 1.5px; text-transform: uppercase; padding: 5px 12px; font-weight: 700; display: flex; align-items: center; gap: 5px; }
    .status-confirmed { background: #e8f5e9; color: #2e7d32; }
    .status-paid      { background: #e8f5e9; color: #2e7d32; }
    .status-pending   { background: #fff8e1; color: #f57f17; }
    .status-shipped   { background: #e3f2fd; color: #1565c0; }
    .status-delivered { background: #e8f5e9; color: #1b5e20; }
    .status-cancelled { background: #fce4ec; color: #b71c1c; }
    .order-chevron { font-size: .75rem; color: rgba(2,0,13,0.3); transition: transform .25s; }
    .order-card.open .order-chevron { transform: rotate(180deg); }
    .order-items-body { display: none; padding: 0 18px 16px; }
    .order-card.open .order-items-body { display: block; }
    .order-item-row { display: grid; grid-template-columns: 56px 1fr auto; gap: 1rem; align-items: center; padding: 12px 0; border-bottom: 1px solid rgba(7,32,63,0.05); }
    .order-item-row:last-child { border-bottom: none; }
    .oi-img { width: 56px; height: 68px; background: #f7f7f7; overflow: hidden; flex-shrink: 0; }
    .oi-img img { width: 100%; height: 100%; object-fit: cover; }
    .oi-name { font-family: var(--font-primary); font-size: .95rem; color: var(--primary-blue); margin-bottom: 3px; line-height: 1.3; }
    .oi-sub  { font-family: var(--font-secondary); font-size: .7rem; color: rgba(2,0,13,0.4); letter-spacing: .5px; }
    .oi-price { font-family: var(--font-primary); font-size: .95rem; font-weight: 700; color: var(--primary-blue); white-space: nowrap; }
    .order-total-row { display: flex; justify-content: flex-end; align-items: center; gap: 1.5rem; padding-top: 12px; margin-top: 4px; border-top: 1px solid rgba(7,32,63,0.06); font-family: var(--font-secondary); font-size: .82rem; color: rgba(2,0,13,0.6); }
    .order-total-row strong { font-family: var(--font-primary); font-size: 1rem; color: var(--primary-blue); font-weight: 700; }

    /* ── Wishlist grid ── */
    .wishlist-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
        gap: 16px;
    }
    .wish-card {
        border: 1px solid rgba(7,32,63,0.08);
        background: var(--white);
        overflow: hidden;
        transition: transform .3s, box-shadow .3s;
        position: relative;
    }
    .wish-card:hover { transform: translateY(-4px); box-shadow: 0 10px 28px rgba(2,0,13,0.08); }
    .wish-img { aspect-ratio: 3/4; background: #f7f7f7; overflow: hidden; }
    .wish-img img { width: 100%; height: 100%; object-fit: cover; transition: transform .5s; }
    .wish-card:hover .wish-img img { transform: scale(1.05); }
    .wish-remove {
        position: absolute;
        top: 8px; right: 8px;
        width: 28px; height: 28px;
        background: var(--white);
        border: 1px solid rgba(7,32,63,0.12);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        font-size: .72rem;
        color: rgba(2,0,13,0.4);
        transition: .2s;
        z-index: 2;
    }
    .wish-remove:hover { background: #e74c3c; color: var(--white); border-color: #e74c3c; }
    .wish-body { padding: 12px 14px 14px; border-top: 1px solid rgba(7,32,63,0.06); }
    .wish-name { font-family: var(--font-primary); font-size: .95rem; color: var(--primary-blue); margin-bottom: 3px; line-height: 1.3; }
    .wish-code { font-family: var(--font-secondary); font-size: .65rem; letter-spacing: 1.5px; text-transform: uppercase; color: rgba(2,0,13,0.3); margin-bottom: 10px; }
    .wish-price { font-family: var(--font-primary); font-size: 1rem; font-weight: 700; color: var(--primary-blue); margin-bottom: 10px; }
    .wish-actions { display: flex; gap: 6px; }
    .btn-move-cart {
        flex: 1;
        padding: 8px;
        background: var(--primary-blue);
        color: var(--white);
        border: none;
        font-family: var(--font-secondary);
        font-size: .65rem;
        letter-spacing: 1.5px;
        text-transform: uppercase;
        cursor: pointer;
        transition: .2s;
    }
    .btn-move-cart:hover { filter: brightness(.9); }
    .btn-view-product {
        padding: 8px 10px;
        background: var(--white);
        color: var(--primary-blue);
        border: 1px solid rgba(7,32,63,0.18);
        font-size: .8rem;
        cursor: pointer;
        transition: .2s;
        display: flex; align-items: center;
        text-decoration: none;
    }
    .btn-view-product:hover { background: rgba(7,32,63,0.04); }

    /* Empty states */
    .panel-empty {
        text-align: center;
        padding: 4rem 1rem;
        color: rgba(2,0,13,0.35);
        border: 1px solid rgba(7,32,63,0.07);
        background: var(--white);
    }
    .panel-empty i { font-size: 2.5rem; display: block; margin-bottom: 1rem; color: rgba(7,32,63,0.12); }
    .panel-empty p { font-family: var(--font-secondary); font-size: .8rem; letter-spacing: 2px; text-transform: uppercase; margin-bottom: 1.25rem; }
    .btn-shop {
        display: inline-block; padding: 10px 28px;
        background: var(--primary-blue); color: var(--white);
        font-family: var(--font-secondary); font-size: .75rem;
        letter-spacing: 2px; text-transform: uppercase;
    }
    .btn-shop:hover { filter: brightness(.92); }

    .toast { position: fixed; right: 16px; bottom: 16px; background: var(--primary-blue); color: var(--white); padding: 12px 16px; font-size: .88rem; box-shadow: 0 10px 24px rgba(7,32,63,0.2); transform: translateY(18px); opacity: 0; pointer-events: none; transition: .25s ease; z-index: 3000; }
    .toast.show { opacity: 1; transform: translateY(0); }

    @media (max-width: 900px) { .profile-layout { grid-template-columns: 1fr; } .user-card { position: static; } }
    @media (max-width: 560px) {
        .wishlist-grid { grid-template-columns: repeat(2, 1fr); }
        .order-item-row { grid-template-columns: 48px 1fr; }
        .oi-price { grid-column: 2; }
    }
</style>
@endpush

<div style="padding-top: 155px;">
<div class="profile-wrap">

    {{-- Header --}}
    <div class="profile-header">
        <h1>My Account</h1>
        <a href="#" class="logout-btn"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket"></i> Sign Out
        </a>
        <form id="logout-form" action="{{ route('frontend.logout') }}" method="POST" style="display:none;">
            @csrf
        </form>
    </div>

    <div class="profile-layout">

        {{-- ── LEFT: User card + nav ── --}}
        <div class="user-card">
            <div class="user-card-top">
                <div class="user-avatar">
                    {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
                </div>
                <div class="user-name">{{ $user->name ?? 'Customer' }}</div>
                <div class="user-email">{{ $user->email }}</div>
            </div>

            <div class="user-card-body">
                @if($user->name)
                <div class="info-row">
                    <span class="info-label">Full Name</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                @if($user->phone ?? $user->mobile ?? null)
                <div class="info-row">
                    <span class="info-label">Phone</span>
                    <span class="info-value">{{ $user->phone ?? $user->mobile }}</span>
                </div>
                @endif
                <div class="info-row">
                    <span class="info-label">Member Since</span>
                    <span class="info-value">{{ $user->created_at->format('M Y') }}</span>
                </div>
            </div>

            {{-- Stats --}}
            <div class="stats-row">
                <div class="stat-box">
                    <div class="stat-num">{{ $orders->count() }}</div>
                    <div class="stat-lbl">Orders</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num">{{ $wishlistItems->count() }}</div>
                    <div class="stat-lbl">Wishlist</div>
                </div>
                <div class="stat-box">
                    <div class="stat-num">₹{{ number_format($orders->sum('total_amount'), 0) }}</div>
                    <div class="stat-lbl">Spent</div>
                </div>
            </div>

            {{-- Tab nav --}}
            <div class="profile-nav">
                <button class="profile-nav-btn active" onclick="switchTab('orders', this)">
                    <i class="fa-solid fa-box"></i>
                    Order History
                    <span class="nav-count">{{ $orders->count() }}</span>
                </button>
                <button class="profile-nav-btn" onclick="switchTab('wishlist', this)">
                    <i class="fa-regular fa-heart"></i>
                    My Wishlist
                    <span class="nav-count">{{ $wishlistItems->count() }}</span>
                </button>
            </div>
        </div>

        {{-- ── RIGHT: Tab panels ── --}}
        <div>

            {{-- ══ ORDERS TAB ══ --}}
            <div id="tab-orders" class="tab-panel active">
                <div class="section-head">
                    <h2>Order History</h2>
                    <span class="section-badge">{{ $orders->count() }} {{ Str::plural('order', $orders->count()) }}</span>
                </div>

                @forelse($orders as $order)
                    @php $statusClass = 'status-' . strtolower($order->status); @endphp

                    <div class="order-card" id="order-card-{{ $order->id }}">
                        <div class="order-card-head" onclick="toggleOrder({{ $order->id }})">
                            <div class="order-meta">
                                <div class="order-meta-item">
                                    <span class="oml">Order ID</span>
                                    <span class="omv">{{ $order->order_code }}</span>
                                </div>
                                <div class="order-meta-item">
                                    <span class="oml">Date</span>
                                    <span class="omv">{{ $order->created_at->format('d M Y') }}</span>
                                </div>
                                <div class="order-meta-item">
                                    <span class="oml">Items</span>
                                    <span class="omv">{{ $order->items->count() }}</span>
                                </div>
                                @if($order->invoice)
                                <div class="order-meta-item">
                                    <span class="oml">Invoice</span>
                                    <span class="omv">{{ $order->invoice->invoice_number }}</span>
                                </div>
                                @endif
                            </div>
                            <div style="display:flex;align-items:center;gap:10px;">
                                <span class="order-status {{ $statusClass }}">
                                    <i class="fa-solid fa-circle" style="font-size:.45rem;"></i>
                                    {{ ucfirst($order->status) }}
                                </span>
                                <i class="fa-solid fa-chevron-down order-chevron"></i>
                            </div>
                        </div>

                        <div class="order-items-body">
                            @foreach($order->items as $item)
                                @php
                                    $product  = $item->product;
                                    $thumb    = $product?->images->first()?->image ?? null;
                                    $thumbUrl = $thumb ? asset('public/storage/'.$thumb) : 'https://via.placeholder.com/112x136?text=No+Image';
                                @endphp
                                <div class="order-item-row">
                                    <a href="{{ route('frontend.product-details', $product->id) }}">
                                        <div class="oi-img"><img src="{{ $thumbUrl }}" alt="{{ $product?->base_name }}" loading="lazy"></div>
                                    </a>
                                    <div>
                                        <div class="oi-name">{{ $product?->base_name ?? 'Product' }}</div>
                                        <div class="oi-sub">
                                            Qty: {{ $item->quantity }}
                                            @if($item->variant) · {{ $item->variant->finish }} @endif
                                            · ₹{{ number_format($item->price) }} each
                                        </div>
                                    </div>
                                    <div class="oi-price">₹{{ number_format($item->total_price) }}</div>
                                </div>
                            @endforeach
                            <div class="order-total-row">
                                <span>Order Total</span>
                                <strong>₹{{ number_format($order->total_amount) }}</strong>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="panel-empty">
                        <i class="fa-solid fa-box-open"></i>
                        <p>No orders yet</p>
                        <a href="{{ route('collection.show') }}" class="btn-shop">Start Shopping</a>
                    </div>
                @endforelse
            </div>

            {{-- ══ WISHLIST TAB ══ --}}
            <div id="tab-wishlist" class="tab-panel">
                <div class="section-head">
                    <h2>My Wishlist</h2>
                    <span class="section-badge" id="wishlistCount">{{ $wishlistItems->count() }} {{ Str::plural('item', $wishlistItems->count()) }}</span>
                </div>

                @if($wishlistItems->count())
                    <div class="wishlist-grid" id="wishlistGrid">
                        @foreach($wishlistItems as $item)
                            @php
                                $product  = $item->product;
                                $thumb    = $product?->images->first()?->image ?? null;
                                $thumbUrl = $thumb ? asset('public/storage/'.$thumb) : 'https://via.placeholder.com/400x500?text=No+Image';
                            @endphp

                            <div class="wish-card" id="wish-card-{{ $product->id }}">
                                <button class="wish-remove"
                                        data-product-id="{{ $product->id }}"
                                        data-url="{{ route('wishlist.remove') }}"
                                        title="Remove">
                                    <i class="fa-solid fa-xmark"></i>
                                </button>

                                <a href="{{ route('frontend.product-details', $product->id) }}">
                                    <div class="wish-img">
                                        <img src="{{ $thumbUrl }}" alt="{{ $product->base_name }}" loading="lazy">
                                    </div>
                                </a>

                                <div class="wish-body">
                                    <div class="wish-name">{{ $product->base_name }}</div>
                                    <div class="wish-code">{{ $product->product_code }}</div>
                                    <div class="wish-price">₹{{ number_format($product->base_price) }}</div>
                                    <div class="wish-actions">
                                        <button class="btn-move-cart"
                                                data-product-id="{{ $product->id }}"
                                                data-url="{{ route('wishlist.moveToCart') }}">
                                            Move to Cart
                                        </button>
                                        <a href="{{ route('frontend.product-details', $product->id) }}"
                                           class="btn-view-product">
                                            <i class="fa-solid fa-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="panel-empty" id="wishlistEmpty">
                        <i class="fa-regular fa-heart"></i>
                        <p>Your wishlist is empty</p>
                        <a href="{{ route('collection.show') }}" class="btn-shop">Browse Collections</a>
                    </div>
                @endif
            </div>

        </div>
    </div>
</div>
</div>

<div class="toast" id="toast"></div>

@push('scripts')
<script>
const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ?? '';
const toast = document.getElementById('toast');

function showToast(msg) {
    toast.textContent = msg;
    toast.classList.add('show');
    setTimeout(() => toast.classList.remove('show'), 3000);
}

// ── Tab switching ─────────────────────────────────────────────────────────
function switchTab(tab, btn) {
    document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.profile-nav-btn').forEach(b => b.classList.remove('active'));
    document.getElementById('tab-' + tab).classList.add('active');
    btn.classList.add('active');
}

// ── Order accordion ───────────────────────────────────────────────────────
function toggleOrder(id) {
    const card = document.getElementById('order-card-' + id);
    card.classList.toggle('open');
}

// ── Wishlist: Remove ──────────────────────────────────────────────────────
document.querySelectorAll('.wish-remove').forEach(btn => {
    btn.addEventListener('click', function () {
        const productId = this.dataset.productId;
        const card      = document.getElementById('wish-card-' + productId);

        fetch(this.dataset.url, {
            method: 'DELETE',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                card?.remove();
                showToast('Removed from wishlist');
                updateWishlistBadges(data.count);
                if (!document.querySelector('.wish-card')) showWishlistEmpty();
            }
        })
        .catch(() => showToast('Something went wrong.'));
    });
});

// ── Wishlist: Move to cart ────────────────────────────────────────────────
document.querySelectorAll('.btn-move-cart').forEach(btn => {
    btn.addEventListener('click', function () {
        const productId = this.dataset.productId;
        const card      = document.getElementById('wish-card-' + productId);
        const orig      = this.textContent;
        this.textContent = 'Moving…';
        this.disabled    = true;

        fetch(this.dataset.url, {
            method: 'POST',
            credentials: 'same-origin',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': csrfToken, 'Accept': 'application/json' },
            body: JSON.stringify({ product_id: productId }),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                card?.remove();
                showToast('Moved to cart ✓');
                updateWishlistBadges(data.count);
                // Update nav cart count
                const cartEl = document.getElementById('cartCount');
                if (cartEl && data.cart_count) cartEl.textContent = data.cart_count;
                if (!document.querySelector('.wish-card')) showWishlistEmpty();
            } else {
                this.textContent = orig;
                this.disabled    = false;
            }
        })
        .catch(() => { showToast('Something went wrong.'); this.textContent = orig; this.disabled = false; });
    });
});

// ── Helpers ───────────────────────────────────────────────────────────────
function updateWishlistBadges(count) {
    // Section badge (top of wishlist tab)
    const sectionBadge = document.getElementById('wishlistCount');
    if (sectionBadge) sectionBadge.textContent = count + ' ' + (count == 1 ? 'item' : 'items');

    // Sidebar nav count pill
    document.querySelectorAll('.profile-nav-btn').forEach(btn => {
        if (btn.textContent.includes('Wishlist')) {
            const pill = btn.querySelector('.nav-count');
            if (pill) pill.textContent = count;
        }
    });

    // Stats box
    const statBoxes = document.querySelectorAll('.stat-box');
    statBoxes.forEach(box => {
        if (box.querySelector('.stat-lbl')?.textContent.trim() === 'Wishlist') {
            const num = box.querySelector('.stat-num');
            if (num) num.textContent = count;
        }
    });
}

function showWishlistEmpty() {
    document.getElementById('wishlistGrid')?.remove();
    const tab = document.getElementById('tab-wishlist');
    if (tab && !tab.querySelector('.panel-empty')) {
        tab.insertAdjacentHTML('beforeend', `
            <div class="panel-empty">
                <i class="fa-regular fa-heart"></i>
                <p>Your wishlist is empty</p>
                <a href="{{ route('collection.show') }}" class="btn-shop">Browse Collections</a>
            </div>
        `);
    }
}

// ── Init ──────────────────────────────────────────────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    // Auto-open first order
    const first = document.querySelector('.order-card');
    if (first) first.classList.add('open');

    // Check URL hash to open wishlist tab directly
    if (window.location.hash === '#wishlist') {
        switchTab('wishlist', document.querySelectorAll('.profile-nav-btn')[1]);
    }

    // Navbar
    const navbar = document.getElementById('navbar');
    if (!navbar) return;
    navbar.classList.add('Scrolled');
    new MutationObserver(() => {
        if (!navbar.classList.contains('Scrolled')) navbar.classList.add('Scrolled');
    }).observe(navbar, { attributes: true, attributeFilter: ['class'] });
});
</script>
@endpush
@endsection 