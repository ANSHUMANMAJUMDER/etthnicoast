@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Collection Ranges</h4>
                <h6>Manage Collection Ranges</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addCollectionRangeModal">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Collection Range
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('collection-ranges.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search name...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('collection-ranges.index') }}" class="btn btn-light w-100">Reset</a>
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
                                <th>Image</th>
                                <th>Name</th>
                                <th>URL</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($collectionRanges->count())
                                @foreach($collectionRanges as $row)
                                    <tr>
                                        <td>{{ ($collectionRanges->currentPage()-1) * $collectionRanges->perPage() + $loop->iteration }}</td>

                                        <td>
                                            @if($row->image)
                                                <img src="{{ asset('public/storage/' . $row->image) }}"
                                                     alt="{{ $row->name }}"
                                                     style="width:70px; height:50px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>{{ $row->name }}</td>

                                        <td>
                                            @if($row->url)
                                                <a href="{{ $row->url }}" target="_blank" class="text-primary" style="font-size:13px;">
                                                    {{ Str::limit($row->url, 35) }}
                                                </a>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>
                                            <form action="{{ route('collection-ranges.toggleStatus', $row->id) }}" method="POST" class="d-inline">
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
                                               data-update-url="{{ route('collection-ranges.update', $row->id) }}"
                                               data-name="{{ $row->name }}"
                                               data-url="{{ $row->url }}"
                                               data-image="{{ $row->image ? asset('public/storage/' . $row->image) : '' }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editCollectionRangeModal">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('collection-ranges.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteCollectionRangeModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No Collection Ranges Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $collectionRanges->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addCollectionRangeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Collection Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('collection-ranges.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label class="form-label">Name *</label>
                        <input type="text"
                               name="name"
                               value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror"
                               placeholder="Enter collection range name">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">URL</label>
                        <input type="text"
                               name="url"
                               value="{{ old('url') }}"
                               class="form-control @error('url') is-invalid @enderror"
                               placeholder="https://example.com/collection">
                        @error('url') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Image</label>
                        <input type="file"
                               name="image"
                               id="add_image_input"
                               accept="image/*"
                               class="form-control @error('image') is-invalid @enderror"
                               onchange="previewImage(this, 'add_image_preview')">
                        @error('image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="mt-2">
                            <img id="add_image_preview" src="#" alt="Preview"
                                 style="display:none; width:100%; max-height:160px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
                        </div>
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
<div class="modal fade" id="editCollectionRangeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Collection Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" id="edit_name" name="name" class="form-control" placeholder="Enter collection range name">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">URL</label>
                        <input type="text" id="edit_url" name="url" class="form-control" placeholder="https://example.com/collection">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Image <small class="text-muted">(Leave blank to keep existing)</small></label>

                        <div class="mb-2" id="edit_image_wrap" style="display:none;">
                            <img id="edit_image_preview" src="#" alt="Current Image"
                                 style="width:100%; max-height:160px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
                        </div>

                        <input type="file"
                               name="image"
                               id="edit_image_input"
                               accept="image/*"
                               class="form-control"
                               onchange="previewImage(this, 'edit_image_preview', 'edit_image_wrap')">
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
<div class="modal fade" id="deleteCollectionRangeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Collection Range</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Collection Range?</p>
                <small class="text-muted">This action cannot be undone. The image will also be permanently removed.</small>
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
/* Image preview helper */
function previewImage(input, previewId, wrapId = null) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
            if (wrapId) document.getElementById(wrapId).style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* Edit modal – populate fields */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editForm').action     = this.dataset.updateUrl;
        document.getElementById('edit_name').value     = this.dataset.name || '';
        document.getElementById('edit_url').value      = this.dataset.url || '';
        document.getElementById('edit_active').checked = (this.dataset.active === '1');

        // Reset file input
        document.getElementById('edit_image_input').value = '';

        // Show current image if exists
        const wrap    = document.getElementById('edit_image_wrap');
        const preview = document.getElementById('edit_image_preview');
        if (this.dataset.image) {
            preview.src          = this.dataset.image;
            wrap.style.display   = 'block';
        } else {
            wrap.style.display   = 'none';
            preview.src          = '#';
        }
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
    new bootstrap.Modal(document.getElementById('addCollectionRangeModal')).show();
});
@endif
</script>
@endsection