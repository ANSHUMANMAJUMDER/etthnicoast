@extends('layouts.master')

@section('content')
<div class="page-wrapper">
<div class="content">

    <div class="page-header">
        <div class="page-title">
            <h4>{{ $user->name ?? $user->email }}</h4>
            <h6><a href="{{ route('admin.users.index') }}" class="text-muted">Customers</a> › Customer Detail</h6>
        </div>
        <div class="page-btn">
            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">← Back</a>
        </div>
    </div>

    {{-- User summary cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mx-auto mb-2"
                         style="width:56px;height:56px;font-size:1.4rem;">
                        {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
                    </div>
                    <h6 class="mb-0">{{ $user->name ?? 'Customer' }}</h6>
                    <small class="text-muted">{{ $user->email }}</small><br>
                    @if($user->phone ?? $user->mobile ?? null)
                        <small class="text-muted">{{ $user->phone ?? $user->mobile }}</small>
                    @endif
                    <hr>
                    <small class="text-muted">Member since {{ $user->created_at->format('d M Y') }}</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-primary mb-0">{{ $orders->count() }}</h2>
                    <small class="text-muted text-uppercase letter-spacing-1">Total Orders</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-success mb-0">₹{{ number_format($orders->sum('total_amount')) }}</h2>
                    <small class="text-muted text-uppercase">Total Spent</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center h-100">
                <div class="card-body d-flex flex-column justify-content-center">
                    <h2 class="text-warning mb-0">{{ $wishlists->count() }}</h2>
                    <small class="text-muted text-uppercase">Wishlist Items</small>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabs --}}
    <ul class="nav nav-tabs mb-3" id="userTabs">
        <li class="nav-item">
            <a class="nav-link active" data-bs-toggle="tab" href="#tab-orders">
                Orders <span class="badge bg-primary ms-1">{{ $orders->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-invoices">
                Invoices <span class="badge bg-secondary ms-1">{{ $invoices->count() }}</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-bs-toggle="tab" href="#tab-wishlist">
                Wishlist <span class="badge bg-warning ms-1">{{ $wishlists->count() }}</span>
            </a>
        </li>
    </ul>

    <div class="tab-content">

        {{-- ══ ORDERS TAB ══ --}}
        <div class="tab-pane fade show active" id="tab-orders">
            <div class="card">
                <div class="card-body">
                    @forelse($orders as $order)
                        <div class="border rounded mb-3 overflow-hidden">
                            {{-- Order header --}}
                            <div class="d-flex align-items-center justify-content-between p-3 bg-light flex-wrap gap-2">
                                <div class="d-flex gap-4 flex-wrap">
                                    <div>
                                        <small class="text-muted d-block" style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Order ID</small>
                                        <strong>{{ $order->order_code }}</strong>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Date</small>
                                        <span>{{ $order->created_at->format('d M Y, h:i A') }}</span>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Total</small>
                                        <strong>₹{{ number_format($order->total_amount) }}</strong>
                                    </div>
                                    <div>
                                        <small class="text-muted d-block" style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Status</small>
                                        @php
                                            $statusColors = ['confirmed'=>'success','paid'=>'success','pending'=>'warning','shipped'=>'info','delivered'=>'success','cancelled'=>'danger'];
                                            $color = $statusColors[strtolower($order->status)] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">{{ ucfirst($order->status) }}</span>
                                    </div>
                                    @if($order->invoice)
                                    <div>
                                        <small class="text-muted d-block" style="font-size:.65rem;letter-spacing:1px;text-transform:uppercase;">Invoice</small>
                                        <span>{{ $order->invoice->invoice_number }}</span>
                                    </div>
                                    @endif
                                </div>

                                {{-- ── ACTION BUTTONS ── --}}
                                <div class="d-flex gap-2">
                                    {{-- Product Label (small print) --}}
                                    <a href="{{ route('admin.users.print-label', $order->id) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-secondary"
                                       title="Print product label to paste on parcel">
                                        <i class="fas fa-tag me-1"></i> Product Label
                                    </a>
                                    {{-- Admin Invoice (full print) --}}
                                    @if($order->invoice)
                                    <a href="{{ route('admin.users.print-invoice', $order->invoice->id) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Print full invoice for admin records">
                                        <i class="fas fa-file-invoice me-1"></i> Invoice
                                    </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Order items --}}
                            <div class="p-3">
                                <table class="table table-sm mb-0">
                                    <thead>
                                        <tr>
                                            <th style="width:60px"></th>
                                            <th>Product</th>
                                            <th>SKU</th>
                                            <th>Qty</th>
                                            <th>Price</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($order->items as $item)
                                            @php
                                                $product = $item->product;
                                                $thumb   = $product?->images->first()?->image ?? null;
                                            @endphp
                                            <tr>
                                                <td>
                                                    @if($thumb)
                                                        <img src="{{ asset('public/storage/'.$thumb) }}"
                                                             style="width:48px;height:56px;object-fit:cover;border-radius:4px;">
                                                    @else
                                                        <div style="width:48px;height:56px;background:#f0f0f0;border-radius:4px;"></div>
                                                    @endif
                                                </td>
                                                <td class="align-middle">{{ $product?->base_name ?? 'Product' }}</td>
                                                <td class="align-middle"><code>{{ $product?->product_code }}</code></td>
                                                <td class="align-middle">{{ $item->quantity }}</td>
                                                <td class="align-middle">₹{{ number_format($item->price) }}</td>
                                                <td class="align-middle fw-bold">₹{{ number_format($item->total_price) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="5" class="text-end fw-bold">Order Total</td>
                                            <td class="fw-bold text-primary">₹{{ number_format($order->total_amount) }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted py-4">No orders found</p>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- ══ INVOICES TAB ══ --}}
        <div class="tab-pane fade" id="tab-invoices">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Invoice #</th>
                                    <th>Order ID</th>
                                    <th>Date</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($invoices as $invoice)
                                    <tr>
                                        <td><strong>{{ $invoice->invoice_number }}</strong></td>
                                        <td><code>{{ $invoice->order?->order_code }}</code></td>
                                        <td>{{ $invoice->created_at->format('d M Y') }}</td>
                                        <td>{{ $invoice->items->count() }}</td>
                                        <td>₹{{ number_format($invoice->total_amount) }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('admin.users.print-invoice', $invoice->id) }}"
                                               target="_blank"
                                               class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-print me-1"></i> Print
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="6" class="text-center text-muted">No invoices found</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══ WISHLIST TAB ══ --}}
        <div class="tab-pane fade" id="tab-wishlist">
            <div class="card">
                <div class="card-body">
                    @if($wishlists->count())
                        <div class="row g-3">
                            @foreach($wishlists as $wish)
                                @php
                                    $product = $wish->product;
                                    $thumb   = $product?->images->first()?->image ?? null;
                                @endphp
                                <div class="col-md-3 col-sm-4 col-6">
                                    <div class="card h-100">
                                        @if($thumb)
                                            <img src="{{ asset('public/storage/'.$thumb) }}"
                                                 class="card-img-top"
                                                 style="height:180px;object-fit:cover;">
                                        @else
                                            <div style="height:180px;background:#f0f0f0;"></div>
                                        @endif
                                        <div class="card-body p-2">
                                            <p class="mb-1 small fw-bold text-truncate">{{ $product?->base_name }}</p>
                                            <p class="mb-0 small text-muted">₹{{ number_format($product?->base_price ?? 0) }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-center text-muted py-4">No wishlist items</p>
                    @endif
                </div>
            </div>
        </div>

    </div>{{-- /tab-content --}}

</div>
</div>
@endsection