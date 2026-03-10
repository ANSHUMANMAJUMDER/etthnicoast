@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Banners</h4>
                <h6>Manage Banners</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addBannerModal">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Banner
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('banners.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search title...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('banners.index') }}" class="btn btn-light w-100">Reset</a>
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
                                <th>Title</th>
                                <th>Subtitle</th>
                                <th>Button Text</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($banners->count())
                                @foreach($banners as $row)
                                    <tr>
                                        <td>{{ ($banners->currentPage()-1) * $banners->perPage() + $loop->iteration }}</td>

                                        <td>
                                            <img src="{{ asset('public/storage/' . $row->image) }}"
                                                 alt="{{ $row->title }}"
                                                 style="width:80px; height:50px; object-fit:cover; border-radius:6px;">
                                        </td>

                                        <td>{{ $row->title }}</td>
                                        <td>{{ $row->subtitle ?? '—' }}</td>
                                        <td>{{ $row->button ?? '—' }}</td>
                                        <td>
                                            <form action="{{ route('banners.toggleStatus', $row->id) }}" method="POST" class="d-inline">
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
                                               data-update-url="{{ route('banners.update', $row->id) }}"
                                               data-title="{{ $row->title }}"
                                               data-subtitle="{{ $row->subtitle }}"
                                               data-image="{{ asset('public/storage/' . $row->image) }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editBannerModal">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('banners.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteBannerModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No Banners Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $banners->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('banners.store') }}" method="POST" enctype="multipart/form-data">
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
                        <label class="form-label">Title *</label>
                        <input type="text"
                               name="title"
                               value="{{ old('title') }}"
                               class="form-control @error('title') is-invalid @enderror"
                               placeholder="Enter banner title">
                        @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text"
                               name="subtitle"
                               value="{{ old('subtitle') }}"
                               class="form-control @error('subtitle') is-invalid @enderror"
                               placeholder="Enter subtitle (optional)">
                        @error('subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Button Text<span>*</span></label>
                        <input type="text"
                               name="button"
                               value="{{ old('button') }}"
                               class="form-control @error('button') is-invalid @enderror"
                               placeholder="Enter button text (optional)">
                        @error('button') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Image *</label>
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
<div class="modal fade" id="editBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Title *</label>
                        <input type="text" id="edit_title" name="title" class="form-control" placeholder="Enter banner title">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Subtitle</label>
                        <input type="text" id="edit_subtitle" name="subtitle" class="form-control" placeholder="Enter subtitle (optional)">
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Button Text</label>
                        <input type="text" id="edit_button" name="button" class="form-control" placeholder="Enter button text (optional)">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Image <small class="text-muted">(Leave blank to keep existing)</small></label>

                        {{-- Current image preview --}}
                        <div class="mb-2">
                            <img id="edit_image_preview" src="#" alt="Current Banner"
                                 style="width:100%; max-height:160px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
                        </div>

                        <input type="file"
                               name="image"
                               id="edit_image_input"
                               accept="image/*"
                               class="form-control"
                               onchange="previewImage(this, 'edit_image_preview')">
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
<div class="modal fade" id="deleteBannerModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Banner</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Banner?</p>
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
function previewImage(input, previewId) {
    const preview = document.getElementById(previewId);
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

/* Edit modal – populate fields */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editForm').action    = this.dataset.updateUrl;
        document.getElementById('edit_title').value   = this.dataset.title || '';
        document.getElementById('edit_subtitle').value = this.dataset.subtitle || '';
        document.getElementById('edit_button').value   = this.dataset.button || '';
        document.getElementById('edit_active').checked = (this.dataset.active === '1');

        // Show current image
        const preview = document.getElementById('edit_image_preview');
        preview.src   = this.dataset.image;
        preview.style.display = 'block';

        // Reset file input so old selection doesn't carry over
        document.getElementById('edit_image_input').value = '';
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
    new bootstrap.Modal(document.getElementById('addBannerModal')).show();
});
@endif
</script>
@endsection