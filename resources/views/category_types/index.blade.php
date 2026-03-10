@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <!-- Page Header -->
        <div class="page-header">
            <div class="page-title">
                <h4>Category Types</h4>
                <h6>Manage Category Types</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addCategoryType">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Category Type
                </a>
            </div>
        </div>

        <!-- Success Message -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- Search -->
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('category_type.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text"
                                   name="q"
                                   value="{{ $q ?? '' }}"
                                   class="form-control"
                                   placeholder="Search by type name / description...">
                        </div>

                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>

                        <div class="col-md-2">
                            <a href="{{ route('category_type.index') }}" class="btn btn-light w-100">Reset</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Table -->
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Type Name</th>
                                <th>Description</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($categoryTypes->count() > 0)

                                @foreach($categoryTypes as $type)
                                    <tr>
                                        <td>{{ ($categoryTypes->currentPage()-1) * $categoryTypes->perPage() + $loop->iteration }}</td>
                                        <td>{{ $type->type_name }}</td>
                                        <td>{{ $type->description ? $type->description : '-' }}</td>

                                        <td class="text-end">

                                            <!-- Edit -->
                                            <a href="javascript:void(0);"
                                               class="me-3 editBtn"
                                               data-name="{{ $type->type_name }}"
                                               data-description="{{ $type->description ?? '' }}"
                                               data-update-url="{{ route('category_type.update', $type->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editCategoryType">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            <!-- Delete (Modal) -->
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('category_type.destroy', $type->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteCategoryTypeModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>

                                        </td>
                                    </tr>
                                @endforeach

                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No Category Types Found</td>
                                </tr>
                            @endif
                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-end mt-3">
                    {{ $categoryTypes->links() }}
                </div>

            </div>
        </div>

    </div>
</div>


<!-- ================= ADD MODAL ================= -->
<div class="modal fade" id="addCategoryType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Category Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('category_type.store') }}" method="POST">
                @csrf
                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Type Name *</label>
                        <input type="text"
                               name="type_name"
                               value="{{ old('type_name') }}"
                               class="form-control @error('type_name') is-invalid @enderror"
                               placeholder="Enter category type">

                        @error('type_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  rows="3"
                                  class="form-control @error('description') is-invalid @enderror"
                                  placeholder="Optional description">{{ old('description') }}</textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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


<!-- ================= EDIT MODAL ================= -->
<div class="modal fade" id="editCategoryType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Category Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Type Name *</label>
                        <input type="text"
                               id="edit_type_name"
                               name="type_name"
                               class="form-control @error('type_name') is-invalid @enderror">

                        @error('type_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_description"
                                  name="description"
                                  rows="3"
                                  class="form-control @error('description') is-invalid @enderror"></textarea>

                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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


<!-- ================= DELETE CONFIRM MODAL ================= -->
<div class="modal fade" id="deleteCategoryTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Category Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Category Type?</p>
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
/* ================= EDIT MODAL FILL ================= */
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        const name = this.dataset.name || '';
        const description = this.dataset.description || '';
        const updateUrl = this.dataset.updateUrl;

        document.getElementById('edit_type_name').value = name;
        document.getElementById('edit_description').value = description;
        document.getElementById('editForm').action = updateUrl;
    });
});

/* ================= DELETE MODAL ACTION SET ================= */
document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteForm').action = this.dataset.deleteUrl;
    });
});

/* ================= AUTO OPEN ADD MODAL ON VALIDATION ERROR ================= */
@if ($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    var addModal = new bootstrap.Modal(document.getElementById('addCategoryType'));
    addModal.show();
});
@endif
</script>
@endsection