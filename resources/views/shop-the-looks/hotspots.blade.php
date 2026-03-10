@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Manage Hotspots</h4>
                <h6>
                    <a href="{{ route('shop-the-looks.index') }}" class="text-muted">Shop The Look</a>
                    &rsaquo; {{ $shopTheLook->title ?? 'Untitled' }}
                </h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('shop-the-looks.index') }}" class="btn btn-secondary">
                    &larr; Back to List
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">

            {{-- ── Left: Visual Hotspot Placer ─────────────────────────── --}}
            <div class="col-lg-7">
                <div class="card h-100">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h6 class="mb-0 fw-semibold">Click on the image to place a hotspot</h6>
                        <span class="badge bg-info text-white" id="placingBadge" style="display:none !important;">Placing...</span>
                    </div>
                    <div class="card-body">

                        @if($shopTheLook->image)
                            {{-- Hotspot Image Canvas --}}
                            <div id="hotspotCanvas" style="position:relative; display:inline-block; width:100%; cursor:crosshair; user-select:none;">
                                <img src="{{ asset('public/storage/' . $shopTheLook->image) }}"
                                     id="lookImage"
                                     alt="Look Image"
                                     style="width:100%; display:block; border-radius:10px; border:2px solid #dee2e6;">

                                {{-- Render existing hotspots as pins --}}
                                @foreach($hotspots as $hs)
                                    <div class="hotspot-pin {{ $hs->is_active ? 'pin-active' : 'pin-inactive' }}"
                                         style="position:absolute; left:{{ $hs->x_coordinate }}%; top:{{ $hs->y_coordinate }}%; transform:translate(-50%,-50%); cursor:pointer; z-index:10;"
                                         title="{{ $hs->product->base_name ?? 'Product' }} ({{ $hs->x_coordinate }}%, {{ $hs->y_coordinate }}%)"
                                         data-id="{{ $hs->id }}"
                                         onclick="selectHotspot({{ $hs->id }}, {{ $hs->x_coordinate }}, {{ $hs->y_coordinate }}, {{ $hs->product_id }}, {{ $hs->is_active ? 1 : 0 }})">
                                        <div style="
                                            width:32px; height:32px; border-radius:50%;
                                            background: {{ $hs->is_active ? '#1a2b4a' : '#adb5bd' }};
                                            border: 3px solid white;
                                            box-shadow: 0 2px 8px rgba(0,0,0,0.4);
                                            display:flex; align-items:center; justify-content:center;
                                            color:white; font-size:16px; font-weight:bold; line-height:1;
                                        ">+</div>
                                        {{-- Ripple --}}
                                        <div style="
                                            position:absolute; top:50%; left:50%;
                                            transform:translate(-50%,-50%);
                                            width:32px; height:32px; border-radius:50%;
                                            border: 2px solid {{ $hs->is_active ? '#1a2b4a' : '#adb5bd' }};
                                            animation: ripple 1.8s infinite;
                                            pointer-events:none;
                                        "></div>
                                    </div>
                                @endforeach

                                {{-- Temporary new pin (hidden until click) --}}
                                <div id="newPin" style="display:none; position:absolute; transform:translate(-50%,-50%); z-index:20; pointer-events:none;">
                                    <div style="
                                        width:32px; height:32px; border-radius:50%;
                                        background:#e74c3c; border:3px solid white;
                                        box-shadow:0 2px 8px rgba(0,0,0,0.5);
                                        display:flex; align-items:center; justify-content:center;
                                        color:white; font-size:16px; font-weight:bold;
                                    ">+</div>
                                </div>
                            </div>

                            <p class="text-muted mt-2 mb-0" style="font-size:12px;">
                                <strong>Tip:</strong> Click anywhere on the image to set hotspot coordinates. A form will appear on the right — select the product and save.
                            </p>
                        @else
                            <div class="text-center py-5 text-muted">
                                <p>No image uploaded for this look.</p>
                                <a href="{{ route('shop-the-looks.index') }}" class="btn btn-sm btn-outline-secondary">Go back and upload an image</a>
                            </div>
                        @endif

                    </div>
                </div>
            </div>

            {{-- ── Right: Add/Edit Hotspot Form + Table ────────────────── --}}
            <div class="col-lg-5">

                {{-- Add / Edit Form --}}
                <div class="card mb-4">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold" id="formTitle">Add Hotspot</h6>
                    </div>
                    <div class="card-body">

                        <form id="hotspotForm"
                              action="{{ route('shop-the-looks.hotspots.store', $shopTheLook->id) }}"
                              method="POST">
                            @csrf
                            <span id="methodField"></span>

                            <div class="form-group mb-3">
                                <label class="form-label">Product *</label>
                                <select name="product_id" id="hs_product_id" class="form-select @error('product_id') is-invalid @enderror">
                                    <option value="">— Click image first, then select product —</option>
                                    @foreach($products as $product)
                                        <option value="{{ $product->id }}">{{ $product->base_name }}</option>
                                    @endforeach
                                </select>
                                @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label class="form-label">X Coordinate <small class="text-muted">(%)</small></label>
                                    <input type="number" step="0.01" min="0" max="100"
                                           name="x_coordinate" id="hs_x"
                                           class="form-control @error('x_coordinate') is-invalid @enderror"
                                           placeholder="0–100" readonly
                                           style="background:#f8f9fa;">
                                    @error('x_coordinate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-6">
                                    <label class="form-label">Y Coordinate <small class="text-muted">(%)</small></label>
                                    <input type="number" step="0.01" min="0" max="100"
                                           name="y_coordinate" id="hs_y"
                                           class="form-control @error('y_coordinate') is-invalid @enderror"
                                           placeholder="0–100" readonly
                                           style="background:#f8f9fa;">
                                    @error('y_coordinate') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" name="is_active" id="hs_active" checked>
                                <label class="form-check-label" for="hs_active">Active</label>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" id="hs_submit_btn" class="btn btn-submit flex-grow-1" disabled>
                                    Save Hotspot
                                </button>
                                <button type="button" class="btn btn-light" onclick="resetHotspotForm()">Reset</button>
                            </div>

                        </form>

                    </div>
                </div>

                {{-- Existing Hotspots Table --}}
                <div class="card">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">Existing Hotspots ({{ $hotspots->count() }})</h6>
                    </div>
                    <div class="card-body p-0">
                        @if($hotspots->count())
                            <div class="table-responsive">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>X / Y</th>
                                            <th>Status</th>
                                            <th class="text-end">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($hotspots as $i => $hs)
                                            <tr id="hsRow_{{ $hs->id }}">
                                                <td>{{ $i + 1 }}</td>
                                                <td style="max-width:120px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                                                    {{ $hs->product->base_name ?? '—' }}
                                                </td>
                                                <td>
                                                    <span class="text-muted" style="font-size:12px;">
                                                        {{ number_format($hs->x_coordinate, 1) }}%,
                                                        {{ number_format($hs->y_coordinate, 1) }}%
                                                    </span>
                                                </td>
                                                <td>
                                                    <form action="{{ route('shop-the-looks.hotspots.toggleStatus', [$shopTheLook->id, $hs->id]) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('PATCH')
                                                        @if($hs->is_active)
                                                            <button type="submit" class="btn btn-xs btn-success" style="font-size:11px; padding:2px 6px;">Active</button>
                                                        @else
                                                            <button type="submit" class="btn btn-xs btn-danger" style="font-size:11px; padding:2px 6px;">Inactive</button>
                                                        @endif
                                                    </form>
                                                </td>
                                                <td class="text-end">
                                                    {{-- Edit --}}
                                                    <a href="javascript:void(0);"
                                                       class="me-2 hsEditBtn"
                                                       data-id="{{ $hs->id }}"
                                                       data-update-url="{{ route('shop-the-looks.hotspots.update', [$shopTheLook->id, $hs->id]) }}"
                                                       data-product-id="{{ $hs->product_id }}"
                                                       data-x="{{ $hs->x_coordinate }}"
                                                       data-y="{{ $hs->y_coordinate }}"
                                                       data-active="{{ $hs->is_active ? 1 : 0 }}">
                                                        <img src="{{ asset('public/assets/img/icons/edit.svg') }}" style="width:16px;">
                                                    </a>

                                                    {{-- Delete --}}
                                                    <a href="javascript:void(0);"
                                                       class="hsDeleteBtn"
                                                       data-delete-url="{{ route('shop-the-looks.hotspots.destroy', [$shopTheLook->id, $hs->id]) }}"
                                                       data-bs-toggle="modal"
                                                       data-bs-target="#deleteHotspotModal">
                                                        <img src="{{ asset('public/assets/img/icons/delete.svg') }}" style="width:16px;">
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <p class="mb-0">No hotspots yet. Click the image to add one.</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- DELETE HOTSPOT MODAL --}}
<div class="modal fade" id="deleteHotspotModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Hotspot</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this hotspot?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteHotspotForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<style>
@keyframes ripple {
    0%   { transform: translate(-50%,-50%) scale(1);   opacity: 0.8; }
    100% { transform: translate(-50%,-50%) scale(2.2); opacity: 0; }
}
</style>
<script>
const storeUrl  = "{{ route('shop-the-looks.hotspots.store', $shopTheLook->id) }}";
let editingId   = null;

// ── Click image to set coordinates ─────────────────────────────────────────
const canvas    = document.getElementById('hotspotCanvas');
const newPin    = document.getElementById('newPin');
const submitBtn = document.getElementById('hs_submit_btn');

if (canvas) {
    canvas.addEventListener('click', function (e) {
        // Ignore if clicked on an existing pin
        if (e.target.closest('.hotspot-pin')) return;

        const rect = canvas.getBoundingClientRect();
        const x    = ((e.clientX - rect.left) / rect.width  * 100).toFixed(2);
        const y    = ((e.clientY - rect.top)  / rect.height * 100).toFixed(2);

        document.getElementById('hs_x').value = x;
        document.getElementById('hs_y').value = y;

        // Show new pin at click position
        newPin.style.left    = x + '%';
        newPin.style.top     = y + '%';
        newPin.style.display = 'block';

        // Enable submit
        submitBtn.disabled = false;

        // If not in edit mode, keep form in add mode
        if (!editingId) {
            document.getElementById('formTitle').textContent = 'Add Hotspot';
        }
    });
}

// ── Select existing hotspot to edit ────────────────────────────────────────
function selectHotspot(id, x, y, productId, isActive) {
    editingId = id;
    document.getElementById('formTitle').textContent = 'Edit Hotspot #' + id;

    // Set form to PUT
    const methodField = document.getElementById('methodField');
    methodField.innerHTML = '<input type="hidden" name="_method" value="PUT">';
    document.getElementById('hotspotForm').action = getUpdateUrl(id);

    document.getElementById('hs_x').value           = x;
    document.getElementById('hs_y').value           = y;
    document.getElementById('hs_product_id').value  = productId;
    document.getElementById('hs_active').checked    = (isActive === 1);

    // Move new pin to this hotspot's position
    newPin.style.left    = x + '%';
    newPin.style.top     = y + '%';
    newPin.style.display = 'block';

    submitBtn.disabled   = false;
    submitBtn.textContent = 'Update Hotspot';
}

// From table edit buttons
document.querySelectorAll('.hsEditBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        selectHotspot(
            this.dataset.id,
            parseFloat(this.dataset.x),
            parseFloat(this.dataset.y),
            this.dataset.productId,
            parseInt(this.dataset.active)
        );
        // Also re-click via form action
        document.getElementById('hotspotForm').action = this.dataset.updateUrl;
        document.getElementById('methodField').innerHTML = '<input type="hidden" name="_method" value="PUT">';
    });
});

function getUpdateUrl(id) {
    // Build from existing edit buttons
    const btn = document.querySelector('.hsEditBtn[data-id="' + id + '"]');
    return btn ? btn.dataset.updateUrl : storeUrl;
}

// ── Reset form ──────────────────────────────────────────────────────────────
function resetHotspotForm() {
    editingId = null;
    document.getElementById('formTitle').textContent      = 'Add Hotspot';
    document.getElementById('hotspotForm').action         = storeUrl;
    document.getElementById('methodField').innerHTML      = '';
    document.getElementById('hs_product_id').value        = '';
    document.getElementById('hs_x').value                 = '';
    document.getElementById('hs_y').value                 = '';
    document.getElementById('hs_active').checked          = true;
    newPin.style.display                                   = 'none';
    submitBtn.disabled                                     = true;
    submitBtn.textContent                                  = 'Save Hotspot';
}

// ── Delete hotspot modal ────────────────────────────────────────────────────
document.querySelectorAll('.hsDeleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteHotspotForm').action = this.dataset.deleteUrl;
    });
});
</script>
@endsection