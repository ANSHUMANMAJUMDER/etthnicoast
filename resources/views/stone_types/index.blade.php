@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="page-header">
            <div class="page-title">
                <h4>Stone Types</h4>
                <h6>Manage Stone Types</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addStoneType">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Stone Type
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        {{-- Search --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('stone-types.index') }}">
                    <div class="row g-2 align-items-center">
                        <div class="col-md-4">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search name...">
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-primary w-100" type="submit">Search</button>
                        </div>
                        <div class="col-md-2">
                            <a href="{{ route('stone-types.index') }}" class="btn btn-light w-100">Reset</a>
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
                                <th>Name</th>
                                <th>Display Order</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($stoneTypes->count())
                                @foreach($stoneTypes as $row)
                                    <tr>
                                        <td>{{ ($stoneTypes->currentPage()-1) * $stoneTypes->perPage() + $loop->iteration }}</td>
                                        <td>{{ $row->name }}</td>
                                        <td>{{ $row->display_order }}</td>

                                        <td>
                                            <form action="{{ route('stone-types.toggleStatus', $row->id) }}" method="POST" class="d-inline">
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
                                               data-update-url="{{ route('stone-types.update', $row->id) }}"
                                               data-name="{{ $row->name }}"
                                               data-display-order="{{ $row->display_order }}"
                                               data-active="{{ $row->is_active ? 1 : 0 }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#editStoneType">
                                                <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                            </a>

                                            {{-- Delete modal --}}
                                            <a href="javascript:void(0);"
                                               class="deleteBtn"
                                               data-delete-url="{{ route('stone-types.destroy', $row->id) }}"
                                               data-bs-toggle="modal"
                                               data-bs-target="#deleteStoneTypeModal">
                                                <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="5" class="text-center">No Stone Types Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $stoneTypes->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ADD MODAL --}}
<div class="modal fade" id="addStoneType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Stone Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('stone-types.store') }}" method="POST">
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
                               class="form-control @error('name') is-invalid @enderror">
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Display Order</label>
                        <input type="number"
                               name="display_order"
                               value="{{ old('display_order', 0) }}"
                               class="form-control @error('display_order') is-invalid @enderror">
                        @error('display_order') <div class="invalid-feedback">{{ $message }}</div> @enderror
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
<div class="modal fade" id="editStoneType" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Stone Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="form-group">
                        <label class="form-label">Name *</label>
                        <input type="text" id="edit_name" name="name" class="form-control">
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Display Order</label>
                        <input type="number" id="edit_display_order" name="display_order" class="form-control">
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
<div class="modal fade" id="deleteStoneTypeModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Stone Type</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Stone Type?</p>
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
document.querySelectorAll('.editBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('editForm').action = this.dataset.updateUrl;
        document.getElementById('edit_name').value = this.dataset.name || '';
        document.getElementById('edit_display_order').value = this.dataset.displayOrder || 0;
        document.getElementById('edit_active').checked = (this.dataset.active === '1');
    });
});

document.querySelectorAll('.deleteBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        document.getElementById('deleteForm').action = this.dataset.deleteUrl;
    });
});

@if($errors->any())
document.addEventListener("DOMContentLoaded", function () {
    new bootstrap.Modal(document.getElementById('addStoneType')).show();
});
@endif
</script>
@endsection