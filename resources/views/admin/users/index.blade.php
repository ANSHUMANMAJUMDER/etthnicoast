@extends('layouts.master')

@section('content')
<div class="page-wrapper">
<div class="content">

    <div class="page-header">
        <div class="page-title">
            <h4>Customers</h4>
            <h6>All registered users</h6>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Search --}}
    <div class="card mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row g-2 align-items-center">
                    <div class="col-md-4">
                        <input type="text" name="q" value="{{ $q ?? '' }}"
                               class="form-control" placeholder="Search name or email…">
                    </div>
                    <div class="col-md-2">
                        <button class="btn btn-primary w-100" type="submit">Search</button>
                    </div>
                    <div class="col-md-2">
                        <a href="{{ route('admin.users.index') }}" class="btn btn-light w-100">Reset</a>
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
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Orders</th>
                            <th>Wishlist</th>
                            <th>Total Spent</th>
                            <th>Joined</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ ($users->currentPage()-1) * $users->perPage() + $loop->iteration }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                                             style="width:34px;height:34px;font-size:.8rem;flex-shrink:0;">
                                            {{ strtoupper(substr($user->name ?? $user->email, 0, 1)) }}
                                        </div>
                                        <span>{{ $user->name ?? '—' }}</span>
                                    </div>
                                </td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? $user->mobile ?? '—' }}</td>
                                <td><span class="badge bg-info text-white">{{ $user->orders_count }}</span></td>
                                <td><span class="badge bg-secondary">{{ $user->wishlists_count }}</span></td>
                                <td>₹{{ number_format($user->orders_sum_total_amount ?? 0) }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td class="text-end">
                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                       class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye me-1"></i> View
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center">No customers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

</div>
</div>
@endsection