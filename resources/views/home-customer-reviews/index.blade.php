@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-title">
                <h4>Customer Reviews</h4>
                <h6>Manage Home Page Customer Reviews</h6>
            </div>
            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addReviewModal">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Review
                </a>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('home-customer-reviews.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text"
                                   name="q"
                                   value="{{ $q ?? '' }}"
                                   class="form-control"
                                   placeholder="Search name or review...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('home-customer-reviews.index') }}" class="btn btn-light w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Table --}}
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Customer Name</th>
                                <th>Rating</th>
                             
                                <th>Review</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($reviews->count())
                                @foreach($reviews as $row)
                                    <tr>
                                        <td>{{ ($reviews->currentPage()-1) * $reviews->perPage() + $loop->iteration }}</td>

                                        <td>{{ $row->customer_name }}</td>

                                        <td>
                                            {{-- Numeric rating badge --}}
                                            <span class="badge bg-warning text-dark">
                                                {{ $row->rating }} / 5
                                            </span>
                                        </td>

                                        

                                        <td style="max-width:280px;">
                                            <span class="text-truncate d-block" title="{{ $row->review }}">
                                                {{ Str::limit($row->review, 60) }}
                                            </span>
                                        </td>

                                        <td>
                                            <form action="{{ route('home-customer-reviews.toggleStatus', $row->id) }}"
                                                  method="POST" class="d-inline">
                                                @csrf
                                                @method('PATCH')
                                                @if($row->is_active)
                                                    <button type="submit" class="btn btn-sm btn-success">Active</button>
                                                @else
                                                    <button type="submit" class="btn btn-sm btn-danger">Inactive</button>
                                                @endif
                                            </form>
                                        </td>

                                        <td class="text-end">
                                            {{-- Edit --}}
                                            <a href="javascript:void(0);"
                                               class="me-3 editBtn"
                                               data-update-url="{{ route('home-customer-reviews.update', $row->id) }}"
                                               data-customer-name="{{ $row->customer_name }}"
                                             
                                               data-rating="{{ $row->rating }}"
                                               data-review="{{ $row->review }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editReviewModal">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('home-customer-reviews.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteReviewModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center">No Reviews Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $reviews->links() }}
                </div>
            </div>
        </div>

    </div>
</div>


{{-- ══════════════════════════════════════════════
     ADD MODAL
══════════════════════════════════════════════ --}}
<div class="modal fade" id="addReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Customer Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('home-customer-reviews.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach($errors->all() as $err)
                                    <li>{{ $err }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    {{-- Customer Name --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text"
                               name="customer_name"
                               value="{{ old('customer_name') }}"
                               class="form-control @error('customer_name') is-invalid @enderror"
                               placeholder="e.g. Anjali Patel">
                        @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Rating (numeric 1–5) --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Rating (1–5) <span class="text-danger">*</span></label>
                        <select name="rating"
                                id="add_rating"
                                class="form-select @error('rating') is-invalid @enderror">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" {{ old('rating', 5) == $i ? 'selected' : '' }}>
                                    {{ $i }} Star{{ $i > 1 ? 's' : '' }}
                                </option>
                            @endfor
                        </select>
                        @error('rating')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

            
                    {{-- Review Text --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Review Text</label>
                        <textarea name="review"
                                  rows="4"
                                  class="form-control @error('review') is-invalid @enderror"
                                  placeholder="Write the customer review here...">{{ old('review') }}</textarea>
                        @error('review')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="add_active"
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="add_active">Active</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-submit">Save</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════
     EDIT MODAL
══════════════════════════════════════════════ --}}
<div class="modal fade" id="editReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Customer Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- Customer Name --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Customer Name <span class="text-danger">*</span></label>
                        <input type="text"
                               id="edit_customer_name"
                               name="customer_name"
                               class="form-control"
                               placeholder="e.g. Anjali Patel">
                    </div>

                    {{-- Rating --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Rating (1–5) <span class="text-danger">*</span></label>
                        <select name="rating"
                                id="edit_rating"
                                class="form-select"
                                onchange="syncStars(this.value, 'edit_stars')">
                            @for($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} Star{{ $i > 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>

                  

                    {{-- Review Text --}}
                    <div class="form-group mb-3">
                        <label class="form-label">Review Text</label>
                        <textarea name="review"
                                  id="edit_review"
                                  rows="4"
                                  class="form-control"
                                  placeholder="Write the customer review here..."></textarea>
                    </div>

                    {{-- Status --}}
                    <div class="form-group">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox"
                                   name="is_active" id="edit_active">
                            <label class="form-check-label" for="edit_active">Active</label>
                        </div>
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-submit">Update</button>
                    <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>

        </div>
    </div>
</div>


{{-- ══════════════════════════════════════════════
     DELETE MODAL
══════════════════════════════════════════════ --}}
<div class="modal fade" id="deleteReviewModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Review</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this review?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteForm" method="POST">
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
<script>
/* ── Star string helper ───────────────────────────────────────── */
const starMap = { 1: '★☆☆☆☆', 2: '★★☆☆☆', 3: '★★★☆☆', 4: '★★★★☆', 5: '★★★★★' };

function syncStars(ratingValue, targetInputId) {
    const input = document.getElementById(targetInputId);
    if (input) input.value = starMap[ratingValue] || '★★★★★';
}

/* ── Edit modal – populate all fields ────────────────────────── */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        const rating = parseInt(this.dataset.rating) || 5;

        document.getElementById('editForm').action          = this.dataset.updateUrl;
        document.getElementById('edit_customer_name').value = this.dataset.customerName  || '';
        document.getElementById('edit_rating').value        = rating;

        document.getElementById('edit_review').value        = this.dataset.review        || '';
        document.getElementById('edit_active').checked      = (this.dataset.active === '1');
    });
});

/* ── Delete modal – set form action ──────────────────────────── */
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteForm').action = this.dataset.deleteUrl;
    });
});

/* ── Auto-open ADD modal on validation error ─────────────────── */
@if($errors->any())
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('addReviewModal')).show();
});
@endif
</script>
@endsection