@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Home Page Banner Setups</h4>
                <h6>Manage Home Page Banner Setups</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addBannerSetupModal">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Banner Setup
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('home-page-banner-setups.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search title or banner title...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('home-page-banner-setups.index') }}" class="btn btn-light w-100">Reset</a>
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
                                <th>Banner Image</th>
                                <th>Title</th>
                                <th>Banner Title</th>
                                <th>Banner Subtitle</th>
                                <th>Button 1</th>
                                <th>Button 2</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($bannerSetups->count())
                                @foreach($bannerSetups as $row)
                                    <tr>
                                        <td>{{ ($bannerSetups->currentPage()-1) * $bannerSetups->perPage() + $loop->iteration }}</td>

                                        <td>
                                            <img src="{{ asset('public/storage/' . $row->banner_image) }}"
                                                 alt="{{ $row->banner_title }}"
                                                 style="width:80px; height:50px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                                        </td>

                                        <td>{{ $row->title ?? '—' }}</td>
                                        <td>{{ $row->banner_title ?? '—' }}</td>
                                        <td>{{ $row->banner_subtitle ?? '—' }}</td>
                                        <td>{{ $row->button_text ?? '—' }}</td>
                                        <td>{{ $row->button_text_2 ?? '—' }}</td>

                                        <td>
                                            <form action="{{ route('home-page-banner-setups.toggleStatus', $row->id) }}" method="POST" class="d-inline">
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
                                               data-update-url="{{ route('home-page-banner-setups.update', $row->id) }}"
                                               data-banner-image="{{ asset('public/storage/' . $row->banner_image) }}"
                                               data-banner-title="{{ $row->banner_title }}"
                                               data-banner-subtitle="{{ $row->banner_subtitle }}"
                                               data-banner-link="{{ $row->banner_link }}"
                                               data-button-text="{{ $row->button_text }}"
                                               data-button-text-2="{{ $row->button_text_2 }}"
                                               data-title="{{ $row->title }}"
                                               data-description="{{ $row->description }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editBannerSetupModal">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('home-page-banner-setups.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteBannerSetupModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No Banner Setups Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $bannerSetups->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addBannerSetupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Home Page Banner Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('home-page-banner-setups.store') }}" method="POST" enctype="multipart/form-data">
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

                    {{-- Banner Image --}}
                    <div class="form-group">
                        <label class="form-label">Banner Image *</label>
                        <input type="file"
                               name="banner_image"
                               id="add_banner_image_input"
                               accept="image/*"
                               class="form-control @error('banner_image') is-invalid @enderror"
                               onchange="previewImage(this, 'add_banner_image_preview')">
                        @error('banner_image') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        <div class="mt-2">
                            <img id="add_banner_image_preview" src="#" alt="Preview"
                                 style="display:none; width:100%; max-height:180px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" value="{{ old('title') }}"
                                       class="form-control @error('title') is-invalid @enderror"
                                       placeholder="Section title">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Title</label>
                                <input type="text" name="banner_title" value="{{ old('banner_title') }}"
                                       class="form-control @error('banner_title') is-invalid @enderror"
                                       placeholder="Main heading on banner">
                                @error('banner_title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Subtitle</label>
                                <input type="text" name="banner_subtitle" value="{{ old('banner_subtitle') }}"
                                       class="form-control @error('banner_subtitle') is-invalid @enderror"
                                       placeholder="Sub-heading on banner">
                                @error('banner_subtitle') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Link</label>
                                <input type="text" name="banner_link" value="{{ old('banner_link') }}"
                                       class="form-control @error('banner_link') is-invalid @enderror"
                                       placeholder="https://example.com/collection">
                                @error('banner_link') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Button Text 1</label>
                                <input type="text" name="button_text" value="{{ old('button_text') }}"
                                       class="form-control @error('button_text') is-invalid @enderror"
                                       placeholder="e.g. Shop Now">
                                @error('button_text') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Button Text 2</label>
                                <input type="text" name="button_text_2" value="{{ old('button_text_2') }}"
                                       class="form-control @error('button_text_2') is-invalid @enderror"
                                       placeholder="e.g. Learn More">
                                @error('button_text_2') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Short description displayed on the banner...">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
<div class="modal fade" id="editBannerSetupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Home Page Banner Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    {{-- Current / New Banner Image --}}
                    <div class="form-group">
                        <label class="form-label">Banner Image <small class="text-muted">(Leave blank to keep existing)</small></label>
                        <div class="mb-2">
                            <img id="edit_banner_image_preview" src="#" alt="Current Banner Image"
                                 style="width:100%; max-height:180px; object-fit:cover; border-radius:8px; border:1px solid #dee2e6;">
                        </div>
                        <input type="file"
                               name="banner_image"
                               id="edit_banner_image_input"
                               accept="image/*"
                               class="form-control"
                               onchange="previewImage(this, 'edit_banner_image_preview')">
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Title</label>
                                <input type="text" id="edit_title" name="title" class="form-control" placeholder="Section title">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Title</label>
                                <input type="text" id="edit_banner_title" name="banner_title" class="form-control" placeholder="Main heading on banner">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Subtitle</label>
                                <input type="text" id="edit_banner_subtitle" name="banner_subtitle" class="form-control" placeholder="Sub-heading on banner">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Banner Link</label>
                                <input type="text" id="edit_banner_link" name="banner_link" class="form-control" placeholder="https://example.com/collection">
                            </div>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Button Text 1</label>
                                <input type="text" id="edit_button_text" name="button_text" class="form-control" placeholder="e.g. Shop Now">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">Button Text 2</label>
                                <input type="text" id="edit_button_text_2" name="button_text_2" class="form-control" placeholder="e.g. Learn More">
                            </div>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_description" name="description" rows="3" class="form-control" placeholder="Short description..."></textarea>
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
<div class="modal fade" id="deleteBannerSetupModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Banner Setup</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Banner Setup?</p>
                <small class="text-muted">This action cannot be undone. The banner image will also be permanently removed.</small>
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

/* Edit modal – populate all fields */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editForm').action              = this.dataset.updateUrl;
        document.getElementById('edit_title').value             = this.dataset.title || '';
        document.getElementById('edit_banner_title').value      = this.dataset.bannerTitle || '';
        document.getElementById('edit_banner_subtitle').value   = this.dataset.bannerSubtitle || '';
        document.getElementById('edit_banner_link').value       = this.dataset.bannerLink || '';
        document.getElementById('edit_button_text').value       = this.dataset.buttonText || '';
        document.getElementById('edit_button_text_2').value     = this.dataset.buttonText2 || '';
        document.getElementById('edit_description').value       = this.dataset.description || '';
        document.getElementById('edit_active').checked          = (this.dataset.active === '1');

        // Show current banner image
        const preview = document.getElementById('edit_banner_image_preview');
        preview.src   = this.dataset.bannerImage;
        preview.style.display = 'block';

        // Reset file input
        document.getElementById('edit_banner_image_input').value = '';
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
    new bootstrap.Modal(document.getElementById('addBannerSetupModal')).show();
});
@endif
</script>
@endsection