@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Jewellery In Motion</h4>
                <h6>Manage Jewellery In Motion Videos</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addJewelleryInMotionModal">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Video
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('jewellery-in-motions.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search by product name...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('jewellery-in-motions.index') }}" class="btn btn-light w-100">Reset</a>
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
                                <th>Video Preview</th>
                                <th>Product</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($jewelleryInMotions->count())
                                @foreach($jewelleryInMotions as $row)
                                    <tr>
                                        <td>{{ ($jewelleryInMotions->currentPage()-1) * $jewelleryInMotions->perPage() + $loop->iteration }}</td>

                                        <td>
                                            <video
                                                src="{{ asset('public/storage/' . $row->video) }}"
                                                style="width:120px; height:70px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6; background:#000;"
                                                muted
                                                preload="metadata"
                                                onmouseover="this.play()"
                                                onmouseout="this.pause(); this.currentTime=0;">
                                            </video>
                                        </td>

                                        <td>
                                            @if($row->product)
                                                <span class="badge bg-light text-dark border">({{ $row->product->product_code }}) {{ $row->product->base_name }}</span>
                                              {{-- image of product --}}
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ asset('public/storage/' . $row->product->images->first()->image) }}" alt="Product Image" style="width:40px; height:40px; object-fit:cover; border-radius:4px; border:1px solid #dee2e6; margin-right:8px;">
                                                    <span>{{ $row->product->base_name }}</span>
                                                </div> 
                                                @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('jewellery-in-motions.toggleStatus', $row->id) }}" method="POST" class="d-inline">
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
                                               data-update-url="{{ route('jewellery-in-motions.update', $row->id) }}"
                                               data-video="{{ asset('public/storage/' . $row->video) }}"
                                               data-product-id="{{ $row->product_id }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editJewelleryInMotionModal">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('jewellery-in-motions.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteJewelleryInMotionModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Jewellery In Motion Videos Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $jewelleryInMotions->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addJewelleryInMotionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Jewellery In Motion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('jewellery-in-motions.store') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="form-group">
                        <label class="form-label">Video * <small class="text-muted">(MP4, WEBM, MOV — max 50MB)</small></label>
                        <input type="file"
                               name="video"
                               id="add_video_input"
                               accept="video/*"
                               class="form-control @error('video') is-invalid @enderror"
                               onchange="previewVideo(this, 'add_video_preview', 'add_video_wrap')">
                        @error('video') <div class="invalid-feedback">{{ $message }}</div> @enderror

                        <div id="add_video_wrap" class="mt-2" style="display:none;">
                            <video id="add_video_preview" controls
                                   style="width:100%; max-height:200px; border-radius:8px; border:1px solid #dee2e6; background:#000;">
                            </video>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Product <small class="text-muted">(Optional)</small></label>
                        <select name="product_id" class="form-select @error('product_id') is-invalid @enderror">
                            <option value="">— Select Product —</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    ({{ $product->product_code }}) {{ $product->base_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('product_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="add_active" {{ old('is_active', 1) ? 'checked' : '' }}>
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

{{-- EDIT MODAL --}}
<div class="modal fade" id="editJewelleryInMotionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Jewellery In Motion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Video <small class="text-muted">(Leave blank to keep existing)</small></label>

                        {{-- Current video preview --}}
                        <div class="mb-2">
                            <video id="edit_video_preview" controls
                                   style="width:100%; max-height:200px; border-radius:8px; border:1px solid #dee2e6; background:#000;">
                            </video>
                        </div>

                        <input type="file"
                               name="video"
                               id="edit_video_input"
                               accept="video/*"
                               class="form-control"
                               onchange="previewVideo(this, 'edit_video_preview', null)">
                        <small class="text-muted">MP4, WEBM, MOV — max 50MB</small>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Product <small class="text-muted">(Optional)</small></label>
                        <select id="edit_product_id" name="product_id" class="form-select">
                            <option value="">— Select Product —</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}"> ( {{$product->product_code}} ) {{ $product->base_name }}</option>
                            @endforeach
                        </select> 
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_active">
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

{{-- DELETE MODAL --}}
<div class="modal fade" id="deleteJewelleryInMotionModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Jewellery In Motion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this video?</p>
                <small class="text-muted">This action cannot be undone. The video file will also be permanently removed.</small>
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
/* Video preview helper */
function previewVideo(input, previewId, wrapId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const url = URL.createObjectURL(input.files[0]);
        preview.src = url;
        preview.style.display = 'block';
        if (wrapId) document.getElementById(wrapId).style.display = 'block';
    }
}

/* Edit modal – populate fields */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editForm').action      = this.dataset.updateUrl;
        document.getElementById('edit_active').checked  = (this.dataset.active === '1');

        // Load current video
        const videoEl   = document.getElementById('edit_video_preview');
        videoEl.src     = this.dataset.video;
        videoEl.load();

        // Reset file input
        document.getElementById('edit_video_input').value = '';

        // Set product dropdown
        const productSelect = document.getElementById('edit_product_id');
        productSelect.value = this.dataset.productId || '';
    });
});

/* Delete modal – set form action */
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteForm').action = this.dataset.deleteUrl;
    });
});

/* Auto-open ADD modal on validation error */
@if($errors->any())
document.addEventListener('DOMContentLoaded', function () {
    new bootstrap.Modal(document.getElementById('addJewelleryInMotionModal')).show();
});
@endif
</script>
@endsection