@extends('layouts.master')

@section('content')
<div class="page-wrapper">
    <div class="content">

        {{-- Header --}}
        <div class="page-header">
            <div class="page-title">
                <h4>Products</h4>
                <h6>Manage Products + Variants</h6>
            </div>

            <div class="page-btn">
                <a class="btn btn-added" data-bs-toggle="modal" data-bs-target="#addProduct">
                    <img src="{{ asset('public/assets/img/icons/plus.svg') }}" class="me-2">Add Product
                </a>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        {{-- Filters --}}
        <div class="card mb-3">
            <div class="card-body">
                <form method="GET" action="{{ route('products.index') }}">
                    <div class="row g-2 align-items-center">

                        <div class="col-md-3">
                            <input type="text" name="q" value="{{ $q ?? '' }}" class="form-control" placeholder="Search code / name...">
                        </div>

                        <div class="col-md-2">
                            <select name="category_id" class="form-control">
                                <option value="">All Categories</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ ($filters['category_id'] ?? null) == $c->id ? 'selected' : '' }}>
                                        {{ $c->category_name ?? $c->name ?? 'Category' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="polish_type_id" class="form-control">
                                <option value="">All Polish</option>
                                @foreach($polishTypes as $t)
                                    <option value="{{ $t->id }}" {{ ($filters['polish_type_id'] ?? null) == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="stone_type_id" class="form-control">
                                <option value="">All Stone</option>
                                @foreach($stoneTypes as $t)
                                    <option value="{{ $t->id }}" {{ ($filters['stone_type_id'] ?? null) == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2">
                            <select name="pearl_type_id" class="form-control">
                                <option value="">All Pearl</option>
                                @foreach($pearlTypes as $t)
                                    <option value="{{ $t->id }}" {{ ($filters['pearl_type_id'] ?? null) == $t->id ? 'selected' : '' }}>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-1">
                            <button class="btn btn-primary w-100" type="submit">Go</button>
                        </div>

                        <div class="col-md-2 mt-2">
                            <a href="{{ route('products.index') }}" class="btn btn-light w-100">Reset</a>
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
                            <th>Code</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Qty</th>
                            <th>Status</th>
                            <th>Images</th>
                            <th>Variants</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>

                        <tbody>
                        @if($products->count())
                            @foreach($products as $p)
                                <tr>
                                    <td>{{ ($products->currentPage()-1) * $products->perPage() + $loop->iteration }}</td>
                                    <td>{{ $p->product_code }}</td>
                                    <td>{{ $p->base_name }}</td>
                                    <td>{{ $p->category?->category_name ?? '-' }}</td>
                                    <td>{{ number_format($p->base_price, 2) }}</td>
                                    <td>{{ $p->quantity }}</td>

                                    {{-- Toggle status --}}
                                    <td>
                                        <form action="{{ route('products.toggleStatus', $p->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
                                            @if($p->is_active)
                                                <button type="submit" class="btn btn-sm btn-success">Active</button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-danger">Inactive</button>
                                            @endif
                                        </form>
                                    </td>

                                    {{-- <td>{{ $p->images?->count() ?? 0 }}</td> --}}
                                    {{-- show image instead  --}}
                                   {{-- <td>
                                        @if($p->images?->count())
                                            <img src="{{ asset('public/storage/' . $p->images->first()->image) }}" alt="Product Image" width="50" height="50" style="object-fit: cover; border-radius: 4px;">
                                            <span class="badge bg-secondary">{{ $p->images->count() }}</span>
                                        @else
                                            -
                                        @endif
                                    </td>--}}
                                    <td>
    @if($p->images?->count())
        <img src="{{ asset('public/storage/' . $p->images->first()->image) }}"
             alt="Product Image"
             width="50" height="50"
             style="object-fit: cover; border-radius: 4px; cursor: pointer;"
             class="openGalleryBtn"
             data-images='@json($p->images->map(fn($img) => asset("public/storage/" . $img->image)))'
             data-product-name="{{ $p->base_name }}">
        <span class="badge bg-secondary" style="cursor:pointer;"
              class="openGalleryBtn">{{ $p->images->count() }}</span>
    @else
        -
    @endif
</td>
                                    {{-- Variant modal open --}}
                                    <td>
                                        <a href="javascript:void(0)"
                                           class="btn btn-sm btn-outline-primary variantBtn"
                                           data-product-id="{{ $p->id }}"
                                           data-product-name="{{ $p->base_name }}"
                                           data-variant-store-url="{{ route('products.variants.store', $p->id) }}"
                                           data-variants='@json($p->variants)'
                                           data-bs-toggle="modal"
                                           data-bs-target="#variantModal">
                                            Manage ({{ $p->variants?->count() ?? 0 }})
                                        </a>
                                    </td>

                                    {{-- Actions --}}
                                    <td class="text-end">

                                        <a href="javascript:void(0);"
   class="me-2 similarBtn"
   title="Similar Items"
   data-product-id="{{ $p->id }}"
   data-product-name="{{ $p->base_name }}"
   data-sync-url="{{ route('products.similar.sync', $p->id) }}"
   data-fetch-url="{{ route('products.similar.data', $p->id) }}"
   data-bs-toggle="modal"
   data-bs-target="#similarItemsModal">
    <img src="{{ asset('public/assets/img/icons/layer.svg') }}"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
         style="width:18px; height:18px;">
    <span style="display:none; font-size:11px; background:#6c757d; color:#fff; padding:2px 6px; border-radius:4px;">Similar</span>
</a>

{{-- Complete The Look --}}
<a href="javascript:void(0);"
   class="me-2 completeLookBtn"
   title="Complete The Look"
   data-product-id="{{ $p->id }}"
   data-product-name="{{ $p->base_name }}"
   data-sync-url="{{ route('products.completeLook.sync', $p->id) }}"
   data-fetch-url="{{ route('products.completeLook.data', $p->id) }}"
   data-bs-toggle="modal"
   data-bs-target="#completeLookModal">
    <img src="{{ asset('public/assets/img/icons/eye.svg') }}"
         onerror="this.style.display='none'; this.nextElementSibling.style.display='inline';"
         style="width:18px; height:18px;">
    <span style="display:none; font-size:11px; background:#0d6efd; color:#fff; padding:2px 6px; border-radius:4px;">Look</span>
</a>
                                        {{-- Edit Product --}}
                                        <a href="javascript:void(0);"
                                           class="me-3 editBtn"
                                           data-update-url="{{ route('products.update', $p->id) }}"
                                           data-product_code="{{ $p->product_code }}"
                                           data-base_name="{{ $p->base_name }}"
                                           data-description="{{ $p->description ?? '' }}"
                                           data-quantity="{{ $p->quantity }}"
                                           data-base_price="{{ $p->base_price }}"
                                           data-discount_price="{{ $p->discount_price ?? '' }}"
                                           data-cgst="{{ $p->cgst ?? '' }}"
                                           data-sgst="{{ $p->sgst ?? '' }}"
                                           data-weight="{{ $p->weight ?? '' }}"
                                           data-stone_type_id="{{ $p->stone_type_id ?? '' }}"
                                           data-pearl_type_id="{{ $p->pearl_type_id ?? '' }}"
                                           data-polish_type_id="{{ $p->polish_type_id ?? '' }}"
                                           data-category_id="{{ $p->category_id ?? '' }}"
                                           data-active="{{ $p->is_active ? 1 : 0 }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#editProduct">
                                            <img src="{{ asset('public/assets/img/icons/edit.svg') }}">
                                        </a>

                                        {{-- Delete Product --}}
                                        <a href="javascript:void(0);"
                                           class="deleteBtn"
                                           data-delete-url="{{ route('products.destroy', $p->id) }}"
                                           data-bs-toggle="modal"
                                           data-bs-target="#deleteProductModal">
                                            <img src="{{ asset('public/assets/img/icons/delete.svg') }}">
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="10" class="text-center">No Products Found</td></tr>
                        @endif
                        </tbody>
                    </table>

                </div>

                <div class="d-flex justify-content-end mt-3">
                    {{ $products->links() }}
                </div>
            </div>
        </div>

    </div>
</div>

{{-- ================= IMAGE GALLERY MODAL ================= --}}
<div class="modal fade" id="imageGalleryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bg-dark text-white">

            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="galleryProductName"></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body text-center position-relative" style="min-height: 400px;">

                {{-- Main Image --}}
                <img id="galleryMainImage"
                     src=""
                     alt="Product Image"
                     style="max-height: 400px; max-width: 100%; object-fit: contain; border-radius: 8px;">

                {{-- Prev / Next Arrows --}}
                <button id="galleryPrev"
                        class="btn btn-dark position-absolute top-50 start-0 translate-middle-y ms-2"
                        style="z-index:10; opacity:0.8;">&#8249;</button>
                <button id="galleryNext"
                        class="btn btn-dark position-absolute top-50 end-0 translate-middle-y me-2"
                        style="z-index:10; opacity:0.8;">&#8250;</button>

                {{-- Counter --}}
                <div id="galleryCounter" class="mt-2 small text-muted"></div>
            </div>

            {{-- Thumbnails --}}
            <div class="modal-footer border-secondary justify-content-center flex-wrap gap-2" id="galleryThumbs">
            </div>

        </div>
    </div>
</div>
{{-- ================= ADD PRODUCT MODAL ================= --}}
<div class="modal fade" id="addProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Add Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
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

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Product Code</label>
                            <input type="text" name="product_code" value="{{ old('product_code') }}"
                                   class="form-control @error('product_code') is-invalid @enderror"
                                   placeholder="Auto Generated if empty">
                            @error('product_code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Base Name *</label>
                            <input type="text" name="base_name" value="{{ old('base_name') }}"
                                   class="form-control @error('base_name') is-invalid @enderror">
                            @error('base_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                    <div class="row mt-3">

    <div class="col-md-3">
        <label class="form-label">Item Type</label>
        <select id="item_prefix" class="form-control">
            <option value="">Select</option>
            @foreach($itemPrefixes as $i)
                <option value="{{ $i->prefix }}">{{ $i->item_name }} ({{ $i->prefix }})</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Embellishment</label>
        <select id="emb_prefix" class="form-control">
            <option value="">Select</option>
            @foreach($emblishments as $e)
                <option value="{{ $e->prefix }}">{{ $e->emblishment_name }} ({{ $e->prefix }})</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Finishing</label>
        <select id="fin_prefix" class="form-control">
            <option value="">Select</option>
            @foreach($finishings as $f)
                <option value="{{ $f->prefix }}">{{ $f->finishing_name }} ({{ $f->prefix }})</option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Maker</label>
        <select id="maker_prefix" class="form-control">
            <option value="">Select</option>
            @foreach($makers as $m)
                <option value="{{ $m->prefix }}">{{ $m->makers_name }} ({{ $m->prefix }})</option>
            @endforeach
        </select>
    </div>

</div>

                    <div class="mt-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                        @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3"><label class="form-label">Quantity</label><input type="number" step="0.001" name="quantity" value="{{ old('quantity', 0) }}" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">Base Price *</label><input type="number" step="0.01" name="base_price" value="{{ old('base_price', 0) }}" class="form-control @error('base_price') is-invalid @enderror"></div>
                        <div class="col-md-3"><label class="form-label">Discount Price</label><input type="number" step="0.01" name="discount_price" value="{{ old('discount_price') }}" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">Weight (g)</label><input type="number" step="0.001" name="weight" value="{{ old('weight') }}" class="form-control"></div>
                        @error('base_price') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3"><label class="form-label">CGST</label><input type="number" step="0.01" name="cgst" value="{{ old('cgst') }}" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">SGST</label><input type="number" step="0.01" name="sgst" value="{{ old('sgst') }}" class="form-control"></div>

                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}" {{ old('category_id') == $c->id ? 'selected' : '' }}>
                                        {{ $c->category_name ?? $c->name ?? 'Category' }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Polish</label>
                            <select name="polish_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($polishTypes as $t)
                                    <option value="{{ $t->id }}" {{ old('polish_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Stone</label>
                            <select name="stone_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($stoneTypes as $t)
                                    <option value="{{ $t->id }}" {{ old('stone_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Pearl</label>
                            <select name="pearl_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($pearlTypes as $t)
                                    <option value="{{ $t->id }}" {{ old('pearl_type_id') == $t->id ? 'selected' : '' }}>{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Product Images (Multiple)</label>
                        <input type="file" name="images[]" id="productImagesInput" class="form-control @error('images.*') is-invalid @enderror" multiple>
                        @error('images.*') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                        <small class="text-muted">jpg/png/webp allowed.</small>
                    </div>

                    <div class="d-flex flex-wrap mt-2 gap-2" id="productPreview"></div>

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="add_is_active" {{ old('is_active', 1) ? 'checked' : '' }}>
                            <label class="form-check-label" for="add_is_active">Active</label>
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

{{-- ================= EDIT PRODUCT MODAL ================= --}}
<div class="modal fade" id="editProduct" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editProductForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">

                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label">Product Code *</label>
                            <input type="text" id="edit_product_code" name="product_code" class="form-control" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Base Name *</label>
                            <input type="text" id="edit_base_name" name="base_name" class="form-control" required>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="form-label">Description</label>
                        <textarea id="edit_description" name="description" rows="3" class="form-control"></textarea>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3"><label class="form-label">Quantity</label><input type="number" step="0.001" id="edit_quantity" name="quantity" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">Base Price *</label><input type="number" step="0.01" id="edit_base_price" name="base_price" class="form-control" required></div>
                        <div class="col-md-3"><label class="form-label">Discount Price</label><input type="number" step="0.01" id="edit_discount_price" name="discount_price" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">Weight (g)</label><input type="number" step="0.001" id="edit_weight" name="weight" class="form-control"></div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-3"><label class="form-label">CGST</label><input type="number" step="0.01" id="edit_cgst" name="cgst" class="form-control"></div>
                        <div class="col-md-3"><label class="form-label">SGST</label><input type="number" step="0.01" id="edit_sgst" name="sgst" class="form-control"></div>

                        <div class="col-md-3">
                            <label class="form-label">Category</label>
                            <select id="edit_category_id" name="category_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($categories as $c)
                                    <option value="{{ $c->id }}">{{ $c->category_name ?? $c->name ?? 'Category' }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Polish</label>
                            <select id="edit_polish_type_id" name="polish_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($polishTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label">Stone</label>
                            <select id="edit_stone_type_id" name="stone_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($stoneTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Pearl</label>
                            <select id="edit_pearl_type_id" name="pearl_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($pearlTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Add More Images (Multiple)</label>
                        <input type="file" name="images[]" class="form-control" multiple>
                        <small class="text-muted">This will append new images (won’t delete old).</small>
                    </div>

                    <div class="form-group mt-3">
                        <label class="form-label">Status</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_active" id="edit_is_active">
                            <label class="form-check-label" for="edit_is_active">Active</label>
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

{{-- ================= DELETE PRODUCT MODAL ================= --}}
<div class="modal fade" id="deleteProductModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Product?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteProductForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>

{{-- ================= VARIANT MODAL (ADD + LIST + EDIT + DELETE) ================= --}}
<div class="modal fade" id="variantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Manage Variants - <span id="variantProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- Add Variant --}}
                <form id="variantForm" method="POST" enctype="multipart/form-data" class="border rounded p-3 mb-3">
                    @csrf
                    <div class="row g-2">

                        <div class="col-md-3">
                            <label class="form-label">Variant Code</label>
                            <input type="text" name="product_code" class="form-control" placeholder="Auto Generated if empty">
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Polish</label>
                            <select name="polish_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($polishTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Stone</label>
                            <select name="stone_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($stoneTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">Pearl</label>
                            <select name="pearl_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($pearlTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-2"><label class="form-label">Qty</label><input type="number" step="0.001" name="quantity" class="form-control" value="0"></div>
                        <div class="col-md-2"><label class="form-label">Base Price *</label><input type="number" step="0.01" name="base_price" class="form-control" required value="0"></div>
                        <div class="col-md-2"><label class="form-label">Discount</label><input type="number" step="0.01" name="discount_price" class="form-control"></div>
                        <div class="col-md-2"><label class="form-label">CGST</label><input type="number" step="0.01" name="cgst" class="form-control"></div>
                        <div class="col-md-2"><label class="form-label">SGST</label><input type="number" step="0.01" name="sgst" class="form-control"></div>
                        <div class="col-md-2"><label class="form-label">Weight</label><input type="number" step="0.001" name="weight" class="form-control"></div>

                        <div class="col-md-6">
                            <label class="form-label">Variant Images (Multiple)</label>
                            <input type="file" name="variant_images[]" id="variantImagesInput" class="form-control" multiple>
                        </div>

                        <div class="col-md-3 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100">Add Variant</button>
                        </div>

                    </div>

                    <div class="d-flex flex-wrap mt-2 gap-2" id="variantPreview"></div>
                </form>

                {{-- Existing variants list --}}
                <div class="border rounded p-3">
                    <h6 class="mb-2">Existing Variants</h6>

                    <div class="table-responsive mt-3">
                        <table class="table table-sm" id="variantTable">
                            <thead>
                            <tr>
                                <th>Code</th>
                                <th>Polish</th>
                                <th>Stone</th>
                                <th>Pearl</th>
                                <th>Price</th>
                                <th>Qty</th>
                                <th>Images</th> {{-- ✅ --}}
                                <th class="text-end">Action</th>
                            </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

{{-- ================= EDIT VARIANT MODAL ================= --}}
<div class="modal fade" id="editVariantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Edit Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form id="editVariantForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-body">
                    <div class="row g-2">
                        <div class="col-md-4">
                            <label class="form-label">Variant Code *</label>
                            <input type="text" name="product_code" id="ev_product_code" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Polish</label>
                            <select name="polish_type_id" id="ev_polish_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($polishTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Stone</label>
                            <select name="stone_type_id" id="ev_stone_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($stoneTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Pearl</label>
                            <select name="pearl_type_id" id="ev_pearl_type_id" class="form-control">
                                <option value="">Select</option>
                                @foreach($pearlTypes as $t)
                                    <option value="{{ $t->id }}">{{ $t->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Base Price *</label>
                            <input type="number" step="0.01" name="base_price" id="ev_base_price" class="form-control" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Qty</label>
                            <input type="number" step="0.001" name="quantity" id="ev_quantity" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Discount</label>
                            <input type="number" step="0.01" name="discount_price" id="ev_discount_price" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">CGST</label>
                            <input type="number" step="0.01" name="cgst" id="ev_cgst" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">SGST</label>
                            <input type="number" step="0.01" name="sgst" id="ev_sgst" class="form-control">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Weight</label>
                            <input type="number" step="0.001" name="weight" id="ev_weight" class="form-control">
                        </div>

                        {{-- ✅ EXISTING VARIANT IMAGES --}}
                        <div class="col-md-12">
                            <label class="form-label">Existing Images</label>
                            <div id="ev_existing_images" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        {{-- ✅ NEW PREVIEW --}}
                        <div class="col-md-12 mt-2">
                            <label class="form-label">New Images Preview</label>
                            <div id="ev_new_preview" class="d-flex flex-wrap gap-2"></div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label">Add Variant Images (Multiple)</label>
                            <input type="file" name="variant_images[]" id="ev_variant_images_input" class="form-control" multiple>
                            <small class="text-muted">This will append new images.</small>
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

{{-- ================= DELETE VARIANT MODAL ================= --}}
<div class="modal fade" id="deleteVariantModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-danger">Delete Variant</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <p class="mb-0">Are you sure you want to delete this Variant?</p>
                <small class="text-muted">This action cannot be undone.</small>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteVariantForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Yes, Delete</button>
                </form>
            </div>

        </div>
    </div>
</div>



{{-- ================= SIMILAR ITEMS MODAL ================= --}}
<div class="modal fade" id="similarItemsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Similar Items — <span id="similarProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <div class="row g-3">

                    {{-- LEFT: Search + All Products ──────────────────────── --}}
                    <div class="col-md-6">
                        <div class="d-flex gap-2 mb-2">
                            <input type="text" id="similarSearchInput" class="form-control form-control-sm"
                                   placeholder="Search product code or name...">
                        </div>

                        <div id="similarAllProducts"
                             style="max-height:420px; overflow-y:auto; border:1px solid #dee2e6; border-radius:8px; padding:8px;">
                            <div class="text-center text-muted py-4">Loading products...</div>
                        </div>
                    </div>

                    {{-- RIGHT: Selected (already linked) ──────────────────── --}}
                    <div class="col-md-6">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <label class="form-label mb-0 fw-semibold">
                                Selected Similar Items
                                <span id="similarSelectedCount" class="badge bg-secondary ms-1">0</span>
                            </label>
                            <button type="button" class="btn btn-xs btn-outline-danger btn-sm" onclick="clearSimilarSelected()">
                                Clear All
                            </button>
                        </div>

                        <div id="similarSelectedList"
                             style="max-height:420px; overflow-y:auto; border:1px solid #dee2e6; border-radius:8px; padding:8px;">
                            <div class="text-center text-muted py-4" id="similarEmptyMsg">No items selected yet</div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="modal-footer">
                <form id="similarSyncForm" method="POST">
                    @csrf
                    <div id="similarHiddenInputs"></div>
                    <button type="submit" class="btn btn-submit" id="similarSaveBtn">
                        Save Similar Items
                    </button>
                </form>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>


{{-- ================= COMPLETE THE LOOK MODAL ================= --}}
<div class="modal fade" id="completeLookModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Complete The Look — <span id="lookProductName"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                {{-- Slot indicators ──────────────────────────────────────── --}}
                <div class="row g-3 mb-3">
                    <div class="col-12">
                        <p class="text-muted mb-2" style="font-size:13px;">
                            Select up to <strong>3 products</strong> to complete this look. Drag to reorder.
                        </p>
                        <div class="d-flex gap-3" id="lookSlots">
                            <div class="look-slot" data-pos="1" style="flex:1; min-height:120px; border:2px dashed #dee2e6; border-radius:10px; display:flex; align-items:center; justify-content:center; text-align:center; padding:10px; position:relative; transition:border-color .2s;">
                                <span class="slot-label text-muted" style="font-size:12px;">Slot 1<br><small>Empty</small></span>
                            </div>
                            <div class="look-slot" data-pos="2" style="flex:1; min-height:120px; border:2px dashed #dee2e6; border-radius:10px; display:flex; align-items:center; justify-content:center; text-align:center; padding:10px; position:relative; transition:border-color .2s;">
                                <span class="slot-label text-muted" style="font-size:12px;">Slot 2<br><small>Empty</small></span>
                            </div>
                            <div class="look-slot" data-pos="3" style="flex:1; min-height:120px; border:2px dashed #dee2e6; border-radius:10px; display:flex; align-items:center; justify-content:center; text-align:center; padding:10px; position:relative; transition:border-color .2s;">
                                <span class="slot-label text-muted" style="font-size:12px;">Slot 3<br><small>Empty</small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                {{-- Product Search + List ─────────────────────────────────── --}}
                <div class="d-flex gap-2 mb-2">
                    <input type="text" id="lookSearchInput" class="form-control form-control-sm"
                           placeholder="Search product code or name...">
                </div>

                <div id="lookAllProducts"
                     style="max-height:320px; overflow-y:auto; border:1px solid #dee2e6; border-radius:8px; padding:8px;">
                    <div class="text-center text-muted py-4">Loading products...</div>
                </div>

            </div>

            <div class="modal-footer">
                <form id="lookSyncForm" method="POST">
                    @csrf
                    <div id="lookHiddenInputs"></div>
                    <button type="submit" class="btn btn-submit" id="lookSaveBtn">
                        Save Complete The Look
                    </button>
                </form>
                <button type="button" class="btn btn-cancel" data-bs-dismiss="modal">Cancel</button>
            </div>

        </div>
    </div>
</div>








@endsection

@section('script')
<script>

    function generateProductCode() {
    const item = document.getElementById('item_prefix').value || '';
    const emb  = document.getElementById('emb_prefix').value || '';
    const fin  = document.getElementById('fin_prefix').value || '';
    const maker= document.getElementById('maker_prefix').value || '';

    if (!item) return;

    const random = Math.floor(1000 + Math.random() * 9000);

    const code = `${item}-${emb}-${fin}-${maker}-${random}`
        .replace(/--+/g, '-')
        .replace(/-$/, '');

    document.querySelector('input[name="product_code"]').value = code;
}

document.getElementById('item_prefix').addEventListener('change', generateProductCode);
document.getElementById('emb_prefix').addEventListener('change', generateProductCode);
document.getElementById('fin_prefix').addEventListener('change', generateProductCode);
document.getElementById('maker_prefix').addEventListener('change', generateProductCode);
const STORAGE_BASE = "{{ asset('public/storage') }}/";


/* -------- Image Gallery -------- */
let galleryImages = [];
let galleryIndex = 0;

function openGallery(images, productName, startIndex = 0) {
    galleryImages = images;
    galleryIndex = startIndex;
    document.getElementById('galleryProductName').innerText = productName + ' — Images';
    renderGallery();
    new bootstrap.Modal(document.getElementById('imageGalleryModal')).show();
}

function renderGallery() {
    const main = document.getElementById('galleryMainImage');
    const counter = document.getElementById('galleryCounter');
    const thumbs = document.getElementById('galleryThumbs');

    main.src = galleryImages[galleryIndex];
    counter.innerText = (galleryIndex + 1) + ' / ' + galleryImages.length;

    // thumbs
    thumbs.innerHTML = '';
    galleryImages.forEach((url, i) => {
        const img = document.createElement('img');
        img.src = url;
        img.style.cssText = 'width:60px;height:60px;object-fit:cover;border-radius:6px;cursor:pointer;border:' + (i === galleryIndex ? '2px solid #0d6efd' : '2px solid transparent');
        img.addEventListener('click', () => {
            galleryIndex = i;
            renderGallery();
        });
        thumbs.appendChild(img);
    });

    // show/hide arrows
    document.getElementById('galleryPrev').style.display = galleryImages.length > 1 ? '' : 'none';
    document.getElementById('galleryNext').style.display = galleryImages.length > 1 ? '' : 'none';
}

document.getElementById('galleryPrev').addEventListener('click', () => {
    galleryIndex = (galleryIndex - 1 + galleryImages.length) % galleryImages.length;
    renderGallery();
});
document.getElementById('galleryNext').addEventListener('click', () => {
    galleryIndex = (galleryIndex + 1) % galleryImages.length;
    renderGallery();
});

// keyboard navigation
document.addEventListener('keydown', function (e) {
    const modal = document.getElementById('imageGalleryModal');
    if (!modal.classList.contains('show')) return;
    if (e.key === 'ArrowLeft') { galleryIndex = (galleryIndex - 1 + galleryImages.length) % galleryImages.length; renderGallery(); }
    if (e.key === 'ArrowRight') { galleryIndex = (galleryIndex + 1) % galleryImages.length; renderGallery(); }
});

document.querySelectorAll('.openGalleryBtn').forEach(el => {
    el.addEventListener('click', function () {
        let images = [];
        try { images = JSON.parse(this.dataset.images || '[]'); } catch(e) { images = []; }
        const name = this.dataset.productName || '';
        openGallery(images, name, 0);
    });
});
/* -------- image preview helper (NEW UPLOAD FILE PREVIEW) -------- */
function previewImages(input, previewBoxId) {
    const previewBox = document.getElementById(previewBoxId);
    if (!previewBox) return;
    previewBox.innerHTML = "";

    if (!input.files || !input.files.length) return;

    Array.from(input.files).forEach(file => {
        const reader = new FileReader();
        reader.onload = function (e) {
            const wrap = document.createElement("div");
            wrap.style.width = "90px";
            wrap.style.height = "90px";
            wrap.style.border = "1px solid #ddd";
            wrap.style.borderRadius = "8px";
            wrap.style.overflow = "hidden";

            const img = document.createElement("img");
            img.src = e.target.result;
            img.style.width = "100%";
            img.style.height = "100%";
            img.style.objectFit = "cover";

            wrap.appendChild(img);
            previewBox.appendChild(wrap);
        };
        reader.readAsDataURL(file);
    });
}

/* -------- render stored thumbs helper -------- */
function renderThumbs(images, targetEl) {
    if (!targetEl) return;
    targetEl.innerHTML = "";

    if (!images || !images.length) {
        targetEl.innerHTML = `<span class="text-muted">No images</span>`;
        return;
    }

    images.forEach(img => {
        const path = img.image || "";
        if (!path) return;

        const url = path.startsWith("http") ? path : (STORAGE_BASE + path);

        const wrap = document.createElement("div");
        wrap.style.width = "60px";
        wrap.style.height = "60px";
        wrap.style.border = "1px solid #ddd";
        wrap.style.borderRadius = "8px";
        wrap.style.overflow = "hidden";

        const im = document.createElement("img");
        im.src = url;
        im.style.width = "100%";
        im.style.height = "100%";
        im.style.objectFit = "cover";

        wrap.appendChild(im);
        targetEl.appendChild(wrap);
    });
}

document.addEventListener("DOMContentLoaded", function () {

    /* Product images preview */
    const productImagesInput = document.getElementById('productImagesInput');
    if (productImagesInput) {
        productImagesInput.addEventListener("change", function () {
            previewImages(this, "productPreview");
        });
    }

    /* Variant images preview (Add Variant) */
    const variantImagesInput = document.getElementById('variantImagesInput');
    if (variantImagesInput) {
        variantImagesInput.addEventListener("change", function () {
            previewImages(this, "variantPreview");
        });
    }

    /* Variant images preview (Edit Variant) */
    const evFileInput = document.getElementById("ev_variant_images_input");
    if (evFileInput) {
        evFileInput.addEventListener("change", function () {
            previewImages(this, "ev_new_preview");
        });
    }

    /* Edit product fill */
    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('editProductForm').action = this.dataset.updateUrl;

            document.getElementById('edit_product_code').value = this.dataset.product_code || '';
            document.getElementById('edit_base_name').value = this.dataset.base_name || '';
            document.getElementById('edit_description').value = this.dataset.description || '';
            document.getElementById('edit_quantity').value = this.dataset.quantity || 0;
            document.getElementById('edit_base_price').value = this.dataset.base_price || 0;
            document.getElementById('edit_discount_price').value = this.dataset.discount_price || '';
            document.getElementById('edit_cgst').value = this.dataset.cgst || '';
            document.getElementById('edit_sgst').value = this.dataset.sgst || '';
            document.getElementById('edit_weight').value = this.dataset.weight || '';

            document.getElementById('edit_stone_type_id').value = this.dataset.stone_type_id || '';
            document.getElementById('edit_pearl_type_id').value = this.dataset.pearl_type_id || '';
            document.getElementById('edit_polish_type_id').value = this.dataset.polish_type_id || '';
            document.getElementById('edit_category_id').value = this.dataset.category_id || '';

            document.getElementById('edit_is_active').checked = (this.dataset.active === '1');
        });
    });

    /* Delete product modal action */
    document.querySelectorAll('.deleteBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            document.getElementById('deleteProductForm').action = this.dataset.deleteUrl;
        });
    });

    /* ✅ Variant modal setup + form action */
    document.querySelectorAll('.variantBtn').forEach(btn => {
        btn.addEventListener('click', function () {
            const storeUrl = this.dataset.variantStoreUrl;
            const productName = this.dataset.productName || '';
            const variantsJson = this.dataset.variants || '[]';

            document.getElementById('variantProductName').innerText = productName;

            // set store action
            const vForm = document.getElementById('variantForm');
            vForm.action = storeUrl;

            // reset previews and inputs
            const pv = document.getElementById('variantPreview');
            if (pv) pv.innerHTML = "";
            if (variantImagesInput) variantImagesInput.value = "";

            // render variants list
            let variants = [];
            try { variants = JSON.parse(variantsJson); } catch(e) { variants = []; }

            const tbody = document.querySelector('#variantTable tbody');
            tbody.innerHTML = "";

            if (!variants.length) {
                tbody.innerHTML = `<tr><td colspan="8" class="text-center text-muted">No variants found</td></tr>`;
                return;
            }

            variants.forEach(v => {
                const editUrl = `{{ url('products/variants') }}/${v.id}`;
                const delUrl  = `{{ url('products/variants') }}/${v.id}`;

                const thumbsHtml = (v.images && v.images.length)
                    ? v.images.slice(0, 3).map(im => {
                        const url = (im.image && im.image.startsWith("http")) ? im.image : (STORAGE_BASE + (im.image || ""));
                        return `<img src="${url}" style="width:40px;height:40px;object-fit:cover;border-radius:6px;border:1px solid #ddd;margin-right:4px;" />`;
                    }).join("")
                    : `<span class="text-muted">No</span>`;

                const tr = document.createElement('tr');
                tr.innerHTML = `
                    <td>${v.product_code ?? '-'}</td>
                    <td>${v.polish_type_id ?? '-'}</td>
                    <td>${v.stone_type_id ?? '-'}</td>
                    <td>${v.pearl_type_id ?? '-'}</td>
                    <td>${v.base_price ?? 0}</td>
                    <td>${v.quantity ?? 0}</td>
                    <td>${thumbsHtml}</td>
                    <td class="text-end">
                        <button type="button"
                            class="btn btn-sm btn-outline-primary me-1 editVariantBtn"
                            data-edit-url="${editUrl}"
                            data-variant='${JSON.stringify(v).replace(/'/g, "&apos;")}'
                            data-bs-toggle="modal"
                            data-bs-target="#editVariantModal"
                        >Edit</button>

                        <button type="button"
                            class="btn btn-sm btn-outline-danger deleteVariantBtn"
                            data-delete-url="${delUrl}"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteVariantModal"
                        >Delete</button>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            bindVariantRowButtons();
        });
    });

    function bindVariantRowButtons() {
        document.querySelectorAll('.editVariantBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('editVariantForm').action = this.dataset.editUrl;

                let v = {};
                try { v = JSON.parse(this.dataset.variant || "{}"); } catch(e) { v = {}; }

                document.getElementById('ev_product_code').value = v.product_code || '';
                document.getElementById('ev_polish_type_id').value = v.polish_type_id || '';
                document.getElementById('ev_stone_type_id').value = v.stone_type_id || '';
                document.getElementById('ev_pearl_type_id').value = v.pearl_type_id || '';
                document.getElementById('ev_base_price').value = v.base_price || 0;
                document.getElementById('ev_quantity').value = v.quantity || 0;
                document.getElementById('ev_discount_price').value = v.discount_price || '';
                document.getElementById('ev_cgst').value = v.cgst || '';
                document.getElementById('ev_sgst').value = v.sgst || '';
                document.getElementById('ev_weight').value = v.weight || '';

                // existing images
                renderThumbs(v.images || [], document.getElementById("ev_existing_images"));

                // reset new preview
                const newPrev = document.getElementById("ev_new_preview");
                if (newPrev) newPrev.innerHTML = "";

                const fileInput = document.getElementById("ev_variant_images_input");
                if (fileInput) fileInput.value = "";
            });
        });

        document.querySelectorAll('.deleteVariantBtn').forEach(btn => {
            btn.addEventListener('click', function () {
                document.getElementById('deleteVariantForm').action = this.dataset.deleteUrl;
            });
        });
    }

    /* safety: prevent submit if action missing */
    const vForm = document.getElementById('variantForm');
    if (vForm) {
        vForm.addEventListener('submit', function(e){
            if (!this.action) {
                e.preventDefault();
                alert("Variant form action missing. Click Manage button again.");
            }
        });
    }

    @if($errors->any())
        new bootstrap.Modal(document.getElementById('addProduct')).show();
    @endif
});




const ALL_PRODUCTS   = @json($allProducts ?? []);
const STORAGE_BASE_R = "{{ asset('public/storage') }}/";

/* ═══════════════════════════════════════════════════════
   SIMILAR ITEMS
═══════════════════════════════════════════════════════ */
let similarSelectedIds  = new Set();
let similarCurrentProdId = null;

function productThumb(img) {
    if (!img) return `<div style="width:42px;height:42px;background:#f0f0f0;border-radius:6px;display:flex;align-items:center;justify-content:center;color:#aaa;font-size:10px;">No img</div>`;
    const url = img.startsWith('http') ? img : (STORAGE_BASE_R + img);
    return `<img src="${url}" style="width:42px;height:42px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">`;
}

function renderSimilarAllProducts(search = '') {
    const box = document.getElementById('similarAllProducts');
    const lower = search.toLowerCase();

    const filtered = ALL_PRODUCTS.filter(p =>
        p.id !== similarCurrentProdId &&
        (p.product_code?.toLowerCase().includes(lower) || p.base_name?.toLowerCase().includes(lower))
    );

    if (!filtered.length) {
        box.innerHTML = `<div class="text-center text-muted py-3">No products found</div>`;
        return;
    }

    box.innerHTML = filtered.map(p => {
        const selected = similarSelectedIds.has(p.id);
        const img      = p.images?.[0]?.image || null;
        return `
        <div class="d-flex align-items-center gap-2 p-2 mb-1 rounded"
             style="border:1px solid ${selected ? '#0d6efd' : '#eee'}; background:${selected ? '#f0f5ff' : '#fff'}; cursor:pointer; transition:all .15s;"
             onclick="toggleSimilar(${p.id})" id="simRow_${p.id}">
            ${productThumb(img)}
            <div style="flex:1; min-width:0;">
                <div style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.base_name}</div>
                <div style="font-size:11px; color:#888;">${p.product_code} &bull; ₹${parseFloat(p.base_price).toLocaleString()}</div>
            </div>
            <div style="width:22px; text-align:center;">
                ${selected
                    ? `<span style="color:#0d6efd; font-size:18px;">&#10003;</span>`
                    : `<span style="color:#ccc; font-size:18px;">&#43;</span>`}
            </div>
        </div>`;
    }).join('');
}

function renderSimilarSelected() {
    const box = document.getElementById('similarSelectedList');
    const msg = document.getElementById('similarEmptyMsg');
    document.getElementById('similarSelectedCount').textContent = similarSelectedIds.size;

    if (!similarSelectedIds.size) {
        box.innerHTML = `<div class="text-center text-muted py-4" id="similarEmptyMsg">No items selected yet</div>`;
        return;
    }

    const selectedProds = ALL_PRODUCTS.filter(p => similarSelectedIds.has(p.id));
    box.innerHTML = selectedProds.map(p => {
        const img = p.images?.[0]?.image || null;
        return `
        <div class="d-flex align-items-center gap-2 p-2 mb-1 rounded" style="border:1px solid #eee; background:#fff;">
            ${productThumb(img)}
            <div style="flex:1; min-width:0;">
                <div style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.base_name}</div>
                <div style="font-size:11px; color:#888;">${p.product_code} &bull; ₹${parseFloat(p.base_price).toLocaleString()}</div>
            </div>
            <button type="button" onclick="toggleSimilar(${p.id})"
                    style="background:none;border:none;color:#dc3545;font-size:18px;cursor:pointer;padding:0 4px;"
                    title="Remove">&times;</button>
        </div>`;
    }).join('');
}

function toggleSimilar(productId) {
    if (similarSelectedIds.has(productId)) {
        similarSelectedIds.delete(productId);
    } else {
        similarSelectedIds.add(productId);
    }
    renderSimilarAllProducts(document.getElementById('similarSearchInput').value);
    renderSimilarSelected();
    buildSimilarHiddenInputs();
}

function clearSimilarSelected() {
    similarSelectedIds.clear();
    renderSimilarAllProducts(document.getElementById('similarSearchInput').value);
    renderSimilarSelected();
    buildSimilarHiddenInputs();
}

function buildSimilarHiddenInputs() {
    const box = document.getElementById('similarHiddenInputs');
    box.innerHTML = [...similarSelectedIds].map(id =>
        `<input type="hidden" name="similar_ids[]" value="${id}">`
    ).join('');
}

// Open Similar modal
document.querySelectorAll('.similarBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        similarCurrentProdId = parseInt(this.dataset.productId);
        similarSelectedIds   = new Set();

        document.getElementById('similarProductName').textContent = this.dataset.productName;
        document.getElementById('similarSyncForm').action         = this.dataset.syncUrl;
        document.getElementById('similarSearchInput').value       = '';

        // Fetch already-linked items
        fetch(this.dataset.fetchUrl)
            .then(r => r.json())
            .then(data => {
                data.forEach(p => similarSelectedIds.add(p.id));
                renderSimilarAllProducts();
                renderSimilarSelected();
                buildSimilarHiddenInputs();
            });
    });
});

document.getElementById('similarSearchInput')?.addEventListener('input', function () {
    renderSimilarAllProducts(this.value);
});


/* ═══════════════════════════════════════════════════════
   COMPLETE THE LOOK  (max 3 slots)
═══════════════════════════════════════════════════════ */
let lookSlots          = [null, null, null]; // index 0→pos1, 1→pos2, 2→pos3
let lookCurrentProdId  = null;

function renderLookSlots() {
    lookSlots.forEach((pid, i) => {
        const slot = document.querySelector(`.look-slot[data-pos="${i + 1}"]`);
        if (!pid) {
            slot.style.borderColor = '#dee2e6';
            slot.innerHTML = `<span class="slot-label text-muted" style="font-size:12px;">Slot ${i+1}<br><small>Empty</small></span>`;
            return;
        }
        const p   = ALL_PRODUCTS.find(x => x.id === pid);
        const img = p?.images?.[0]?.image || null;
        const url = img ? (img.startsWith('http') ? img : STORAGE_BASE_R + img) : null;

        slot.style.borderColor = '#0d6efd';
        slot.innerHTML = `
            <div style="width:100%; text-align:center; position:relative;">
                ${url ? `<img src="${url}" style="width:60px;height:60px;object-fit:cover;border-radius:8px;margin-bottom:4px;">` : ''}
                <div style="font-size:11px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p?.base_name ?? ''}</div>
                <div style="font-size:10px; color:#888;">${p?.product_code ?? ''}</div>
                <button type="button"
                    onclick="removeLookSlot(${i})"
                    style="position:absolute;top:-6px;right:-6px;background:#dc3545;color:#fff;border:none;border-radius:50%;width:20px;height:20px;font-size:13px;line-height:1;cursor:pointer;"
                    title="Remove">&times;</button>
            </div>`;
    });

    buildLookHiddenInputs();
    renderLookAllProducts(document.getElementById('lookSearchInput')?.value || '');
}

function removeLookSlot(index) {
    lookSlots[index] = null;
    // compact: remove gaps
    lookSlots = lookSlots.filter(x => x !== null);
    while (lookSlots.length < 3) lookSlots.push(null);
    renderLookSlots();
}

function addToLook(productId) {
    // Already in a slot?
    if (lookSlots.includes(productId)) {
        // Remove it
        lookSlots = lookSlots.map(x => x === productId ? null : x);
        lookSlots = lookSlots.filter(x => x !== null);
        while (lookSlots.length < 3) lookSlots.push(null);
        renderLookSlots();
        return;
    }
    // Find first empty slot
    const emptyIdx = lookSlots.indexOf(null);
    if (emptyIdx === -1) {
        alert('Maximum 3 products allowed for Complete The Look. Remove one first.');
        return;
    }
    lookSlots[emptyIdx] = productId;
    renderLookSlots();
}

function buildLookHiddenInputs() {
    const box = document.getElementById('lookHiddenInputs');
    box.innerHTML = lookSlots
        .filter(x => x !== null)
        .map(id => `<input type="hidden" name="look_ids[]" value="${id}">`)
        .join('');
}

function renderLookAllProducts(search = '') {
    const box   = document.getElementById('lookAllProducts');
    const lower = search.toLowerCase();

    const filtered = ALL_PRODUCTS.filter(p =>
        p.id !== lookCurrentProdId &&
        (p.product_code?.toLowerCase().includes(lower) || p.base_name?.toLowerCase().includes(lower))
    );

    if (!filtered.length) {
        box.innerHTML = `<div class="text-center text-muted py-3">No products found</div>`;
        return;
    }

    box.innerHTML = filtered.map(p => {
        const inSlot = lookSlots.includes(p.id);
        const img    = p.images?.[0]?.image || null;
        const slotNo = inSlot ? (lookSlots.indexOf(p.id) + 1) : null;
        return `
        <div class="d-flex align-items-center gap-2 p-2 mb-1 rounded"
             style="border:1px solid ${inSlot ? '#0d6efd' : '#eee'}; background:${inSlot ? '#f0f5ff' : '#fff'}; cursor:pointer; transition:all .15s;"
             onclick="addToLook(${p.id})">
            ${productThumb(img)}
            <div style="flex:1; min-width:0;">
                <div style="font-size:13px; font-weight:500; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${p.base_name}</div>
                <div style="font-size:11px; color:#888;">${p.product_code} &bull; ₹${parseFloat(p.base_price).toLocaleString()}</div>
            </div>
            <div style="width:50px; text-align:center;">
                ${inSlot
                    ? `<span style="font-size:11px; background:#0d6efd; color:#fff; padding:2px 7px; border-radius:10px;">Slot ${slotNo}</span>`
                    : `<span style="color:#ccc; font-size:18px;">&#43;</span>`}
            </div>
        </div>`;
    }).join('');
}

// Open Complete The Look modal
document.querySelectorAll('.completeLookBtn').forEach(btn => {
    btn.addEventListener('click', function () {
        lookCurrentProdId = parseInt(this.dataset.productId);
        lookSlots         = [null, null, null];

        document.getElementById('lookProductName').textContent = this.dataset.productName;
        document.getElementById('lookSyncForm').action         = this.dataset.syncUrl;
        document.getElementById('lookSearchInput').value       = '';

        // Fetch already-linked look items
        fetch(this.dataset.fetchUrl)
            .then(r => r.json())
            .then(data => {
                data.sort((a, b) => a.position - b.position)
                    .forEach(p => {
                        const idx = p.position - 1;
                        if (idx >= 0 && idx < 3) lookSlots[idx] = p.id;
                    });
                renderLookSlots();
            });
    });
});

document.getElementById('lookSearchInput')?.addEventListener('input', function () {
    renderLookAllProducts(this.value);
});
</script>
@endsection