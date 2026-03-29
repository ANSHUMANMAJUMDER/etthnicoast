@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Sub-Categories</h4>
                <h6>
                    <a href="{{ route('tab-categories.index') }}" class="text-muted">Tab Categories</a>
                    &rsaquo; {{ $tabCategory->name }}
                </h6>
            </div>
            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addSubCategory">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Sub-Category
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Info banner --}}
        <div class="card mb-3 border-start border-primary border-4">
            <div class="card-body py-2">
                <span class="fw-semibold">Category:</span> {{ $tabCategory->name }}
                &nbsp;|&nbsp;
                <code>{{ $tabCategory->slug }}</code>
                &nbsp;|&nbsp;
                <span class="badge {{ $tabCategory->is_active ? 'bg-success' : 'bg-danger' }}">
                    {{ $tabCategory->is_active ? 'Active' : 'Inactive' }}
                </span>
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
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Display Order</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($subCategories->count())
                                @foreach($subCategories as $row)
                                    <tr>
                                        <td>{{ ($subCategories->currentPage()-1) * $subCategories->perPage() + $loop->iteration }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td><code>{{ $row->slug }}</code></td>
                                        <td>{{ $row->display_order }}</td>
                                        <td>
                                            <form action="{{ route('tab-categories.sub-categories.toggleStatus', [$tabCategory->id, $row->id]) }}" method="POST" class="d-inline">
                                                @csrf @method('PATCH')
                                                <button type="submit" class="btn btn-sm {{ $row->is_active ? 'btn-success' : 'btn-danger' }}">
                                                    {{ $row->is_active ? 'Active' : 'Inactive' }}
                                                </button>
                                            </form>
                                        </td>
                                        <td class="text-end">
                                            <a href="javascript:void(0);"
                                               class="me-3 editSubBtn"
                                               data-update-url="{{ route('tab-categories.sub-categories.update', [$tabCategory->id, $row->id]) }}"
                                               data-name="{{ $row->name }}"
                                               data-display-order="{{ $row->display_order }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editSubCategory">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>
                                            <a href="javascript:void(0);"
                                               class="deleteSubBtn"
                                               data-delete-url="{{ route('tab-categories.sub-categories.destroy', [$tabCategory->id, $row->id]) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteSubModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No Sub-Categories Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $subCategories->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addSubCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('tab-categories.sub-categories.store', $tabCategory->id) }}" method="POST">
                @csrf
                <div class="modal-body">
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                        </div>
                    @endif
                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" name="name" value="{{ old('name') }}"
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" name="display_order" value="{{ old('display_order', 0) }}"
                               class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="add_sub_active"
                                   {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="add_sub_active">Active</label>
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
<div class="modal fade" id="editSubCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editSubForm" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" id="edit_sub_name" name="name" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" id="edit_sub_order" name="display_order" class="form-control">
                    </div>
                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_sub_active">
                            <label class="form-check-label" for="edit_sub_active">Active</label>
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
<div class="modal fade" id="deleteSubModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Sub-Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this sub-category?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteSubForm" method="POST">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
document.querySelectorAll('.editSubBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editSubForm').action    = this.dataset.updateUrl;
        document.getElementById('edit_sub_name').value  = this.dataset.name || '';
        document.getElementById('edit_sub_order').value = this.dataset.displayOrder || 0;
        document.getElementById('edit_sub_active').checked = (this.dataset.active === '1');
    });
});

document.querySelectorAll('.deleteSubBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteSubForm').action = this.dataset.deleteUrl;
    });
});

@if($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    new bootstrap.Modal(document.getElementById('addSubCategory')).show();
});
@endif
</script>
@endsection