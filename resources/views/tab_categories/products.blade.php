@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Assign Products</h4>
                <h6>
                    <a href="{{ route('tab-categories.index') }}" class="text-muted">Tab Categories</a>
                    &rsaquo; {{ $tabCategory->name }}
                </h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('tab-categories.index') }}" class="btn btn-secondary">
                    &larr; Back to Categories
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row">

            {{-- ══════════════════════════════════════════════
                 LEFT — All Products (searchable checkbox list)
            ══════════════════════════════════════════════ --}}
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">All Active Products</h5>
                        <span class="badge bg-secondary" id="selectedCount">0 selected</span>
                    </div>
                    <div class="card-body">

                        <form action="{{ route('tab-categories.products.sync', $tabCategory->id) }}" method="POST" id="syncForm">
                            @csrf

                            {{-- Search bar --}}
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fas fa-search"></i></span>
                                <input type="text" id="productSearch" class="form-control" placeholder="Search products by name or code...">
                            </div>

                            {{-- Select / Deselect all --}}
                            <div class="d-flex gap-2 mb-3">
                                <button type="button" class="btn btn-sm btn-outline-primary" id="selectAllVisible">Select All Visible</button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" id="deselectAll">Deselect All</button>
                            </div>

                            {{-- Product list --}}
                            <div style="max-height: 480px; overflow-y: auto;" id="productListContainer">
                                <div class="list-group" id="productList">
                                    @foreach($allProducts as $product)
                                        @php
                                            $thumb = $product->images->first()?->image ?? null;
                                            $checked = in_array($product->id, $assignedIds);
                                        @endphp
                                        <label class="list-group-item list-group-item-action d-flex align-items-center gap-3 product-item py-2"
                                               data-name="{{ strtolower($product->base_name) }}"
                                               data-code="{{ strtolower($product->product_code) }}">

                                            <input type="checkbox"
                                                   name="product_ids[]"
                                                   value="{{ $product->id }}"
                                                   class="form-check-input product-checkbox flex-shrink-0"
                                                   style="width:18px;height:18px;"
                                                   {{ $checked ? 'checked' : '' }}>

                                            {{-- Thumbnail --}}
                                            <div class="flex-shrink-0">
                                                @if($thumb)
                                                    <img src="{{ asset('public/storage/' . $thumb) }}"
                                                         alt="{{ $product->base_name }}"
                                                         style="width:44px;height:44px;object-fit:cover;border-radius:6px;">
                                                @else
                                                    <div style="width:44px;height:44px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </div>

                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate">{{ $product->base_name }}</div>
                                                <small class="text-muted">
                                                    Code: {{ $product->product_code }}
                                                    &nbsp;·&nbsp;
                                                    ₹{{ number_format($product->base_price, 2) }}
                                                </small>
                                            </div>

                                            @if($checked)
                                                <span class="badge bg-success flex-shrink-0 already-badge">Assigned</span>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>

                                <div id="noResults" class="text-center text-muted py-4" style="display:none;">
                                    No products match your search.
                                </div>
                            </div>

                            <div class="mt-3 d-flex gap-2">
                                <button type="submit" class="btn btn-submit">
                                    <i class="fas fa-save me-1"></i> Save Assignments
                                </button>
                                <a href="{{ route('tab-categories.index') }}" class="btn btn-cancel">Cancel</a>
                            </div>

                        </form>
                    </div>
                </div>
            </div>

            {{-- ══════════════════════════════════════════════
                 RIGHT — Currently assigned products
            ══════════════════════════════════════════════ --}}
            <div class="col-lg-5">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5 class="mb-0">Currently Assigned</h5>
                        <span class="badge bg-primary">{{ $assignedProducts->count() }}</span>
                    </div>
                    <div class="card-body p-0">
                        @if($assignedProducts->count())
                            <div style="max-height: 560px; overflow-y: auto;">
                                <ul class="list-group list-group-flush">
                                    @foreach($assignedProducts as $product)
                                        @php $thumb = $product->images->first()?->image ?? null; @endphp
                                        <li class="list-group-item d-flex align-items-center gap-3 py-2" id="assigned_{{ $product->id }}">

                                            @if($thumb)
                                                <img src="{{ asset('public/storage/' . $thumb) }}"
                                                     alt="{{ $product->base_name }}"
                                                     style="width:40px;height:40px;object-fit:cover;border-radius:6px;flex-shrink:0;">
                                            @else
                                                <div style="width:40px;height:40px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                                    <i class="fas fa-image text-muted small"></i>
                                                </div>
                                            @endif

                                            <div class="flex-grow-1 min-w-0">
                                                <div class="fw-semibold text-truncate small">{{ $product->base_name }}</div>
                                                <div class="text-muted" style="font-size:11px;">{{ $product->product_code }}</div>
                                            </div>

                                            {{-- Quick remove --}}
                                            <form action="{{ route('tab-categories.products.remove', [$tabCategory->id, $product->id]) }}"
                                                  method="POST" class="flex-shrink-0">
                                                @csrf @method('DELETE')
                                                <button type="submit"
                                                        class="btn btn-sm btn-outline-danger py-0 px-1"
                                                        title="Remove"
                                                        onclick="return confirm('Remove this product?')">
                                                    &times;
                                                </button>
                                            </form>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <div class="text-center text-muted py-5">
                                <i class="fas fa-box-open fa-2x mb-2 d-block"></i>
                                No products assigned yet.
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>{{-- /row --}}
    </div>
</div>
@endsection

@section('script')
<script>
(function () {
    // ── Live search ───────────────────────────────────────────────
    const searchInput   = document.getElementById('productSearch');
    const items         = document.querySelectorAll('.product-item');
    const noResults     = document.getElementById('noResults');

    searchInput.addEventListener('input', function () {
        const q = this.value.toLowerCase().trim();
        let visible = 0;

        items.forEach(item => {
            const match = !q || item.dataset.name.includes(q) || item.dataset.code.includes(q);
            item.style.display = match ? '' : 'none';
            if (match) visible++;
        });

        noResults.style.display = (visible === 0) ? '' : 'none';
        updateCount();
    });

    // ── Selected count ────────────────────────────────────────────
    function updateCount() {
        const n = document.querySelectorAll('.product-checkbox:checked').length;
        document.getElementById('selectedCount').textContent = n + ' selected';
    }

    document.querySelectorAll('.product-checkbox').forEach(cb => {
        cb.addEventListener('change', updateCount);
    });

    updateCount(); // init

    // ── Select all visible ────────────────────────────────────────
    document.getElementById('selectAllVisible').addEventListener('click', function () {
        items.forEach(item => {
            if (item.style.display !== 'none') {
                item.querySelector('.product-checkbox').checked = true;
            }
        });
        updateCount();
    });

    // ── Deselect all ──────────────────────────────────────────────
    document.getElementById('deselectAll').addEventListener('click', function () {
        document.querySelectorAll('.product-checkbox').forEach(cb => cb.checked = false);
        updateCount();
    });
})();
</script>
@endsection