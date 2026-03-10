@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Categories</h4>
                <h6>Manage Categories</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addCategory">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Category
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
       <div class="card mb-3">
  <div class="card-body">
    <form method="GET" action="{{ route('categories.index') }}">
      <div class="row g-2 align-items-center">

        <div class="col-md-4">
          <input type="text"
                 name="q"
                 value="{{ $q ?? '' }}"
                 class="form-control"
                 placeholder="Search category / type / description...">
        </div>

        <div class="col-md-3">
          <select name="type_id" class="form-control">
            <option value="">All Types</option>
            @foreach($categoryTypes as $type)
              <option value="{{ $type->id }}" {{ ($typeId == $type->id) ? 'selected' : '' }}>
                {{ $type->type_name }}
              </option>
            @endforeach
          </select>
        </div>

        <div class="col-md-2">
          <button class="btn btn-primary w-100" type="submit">Filter</button>
        </div>

        <div class="col-md-2">
          <a href="{{ route('categories.index') }}" class="btn btn-light w-100">Reset</a>
        </div>

      </div>
    </form>
  </div>
</div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">

                    <table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Category Type</th>
                                <th>Category Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($categories->count() > 0)
                                @foreach($categories as $cat)
                                    <tr>
                                        <td>{{ ($categories->currentPage()-1) * $categories->perPage() + $loop->iteration }}</td>
                                        <td>{{ $cat->type?->type_name ?? '-' }}</td>
                                        <td>{{ $cat->category_name }}</td>
                                        <td>{{ $cat->description ? $cat->description : '-' }}</td>
                                        <td>
  <form action="{{ route('categories.toggleStatus', $cat->id) }}"
        method="POST"
        class="d-inline toggleStatusForm">
    @csrf
    @method('PATCH')

    @if($cat->status)
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
                                               data-update-url="{{ route('categories.update', $cat->id) }}"
                                               data-type-id="{{ $cat->category_type_id }}"
                                               data-name="{{ $cat->category_name }}"
                                               data-description="{{ $cat->description ?? '' }}"
                                               data-status="{{ $cat->status ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editCategory">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete (Modal) --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('categories.destroy', $cat->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteCategoryModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No Categories Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>

                {{-- Pagination --}}
                <div class="d-flex justify-content-end mt-3">
                    {{ $categories->links() }}
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ================= ADD MODAL ================= --}}
<div class="modal fade" id="addCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('categories.store') }}" method="POST">
                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Category Type *</label>
                        <select name="category_type_id"
                                class="form-control @error('category_type_id') is-invalid @enderror">
                            <option value="">Select Type</option>
                            @foreach($categoryTypes as $type)
                                <option value="{{ $type->id }}" {{ old('category_type_id') == $type->id ? 'selected' : '' }}>
                                    {{ $type->type_name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text"
                               name="category_name"
                               value="{{ old('category_name') }}"
                               class="form-control @error('category_name') is-invalid @enderror">
                        @error('category_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Description</label>
                        <textarea name="description"
                                  rows="3"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="status"
                                   id="add_status"
                                   {{ old('status', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="add_status">Active</label>
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

{{-- ================= EDIT MODAL ================= --}}
<div class="modal fade" id="editCategory" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">

                    <div class="form-group">
                        <label class="form-label">Category Type *</label>
                        <select name="category_type_id"
                                id="edit_type_id"
                                class="form-control @error('category_type_id') is-invalid @enderror">
                            <option value="">Select Type</option>
                            @foreach($categoryTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->type_name }}</option>
                            @endforeach
                        </select>
                        @error('category_type_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Category Name *</label>
                        <input type="text"
                               id="edit_name"
                               name="category_name"
                               class="form-control @error('category_name') is-invalid @enderror">
                        @error('category_name')
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

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="status" id="edit_status">
                            <label class="form-check-label" for="edit_status">Active</label>
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

{{-- ================= DELETE MODAL ================= --}}
<div class="modal fade" id="deleteCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Category?</p>
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
/* ========== EDIT fill ========== */
document.querySelectorAll('.editBtn').forEach(btn => {
  btn.addEventListener('click', function () {
    document.getElementById('editForm').action = this.dataset.updateUrl;
    document.getElementById('edit_type_id').value = this.dataset.typeId || '';
    document.getElementById('edit_name').value = this.dataset.name || '';
    document.getElementById('edit_description').value = this.dataset.description || '';
    document.getElementById('edit_status').checked = (this.dataset.status === '1');
  });
});

/* ========== DELETE modal set action ========== */
document.querySelectorAll('.deleteBtn').forEach(btn => {
  btn.addEventListener('click', function () {
    document.getElementById('deleteForm').action = this.dataset.deleteUrl;
  });
});

/* ========== Auto open ADD modal on validation errors ========== */
@if ($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    var addModal = new bootstrap.Modal(document.getElementById('addCategory'));
    addModal.show();
});
@endif
</script>
@endsection