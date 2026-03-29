@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-title">
                <h4>Static Pages</h4>
                <h6>Manage frontend static page content</h6>
            </div>
        </div>

        {{-- Success Alert --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Cards --}}
        <div class="row">
            @foreach($pages as $item)
            <div class="col-xl-3 col-sm-6 col-12 mb-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body d-flex flex-column">
                        <div class="mb-3">
                            <span class="badge bg-primary bg-opacity-10 text-primary"
                                  style="font-size:.72rem; letter-spacing:1px;">
                                /{{ $item['slug'] }}
                            </span>
                        </div>
                        <h6 class="fw-bold mb-1 text-dark">{{ $item['label'] }}</h6>
                        <small class="text-muted mb-4">
                            Last updated:
                            {{ $item['page']->updated_at ? $item['page']->updated_at->diffForHumans() : 'Never' }}
                        </small>
                        <div class="mt-auto">
                            <a href="{{ route('admin.static-pages.edit', $item['slug']) }}"
                               class="btn btn-primary btn-sm w-100">
                                <i class="fa fa-pen me-1"></i> Edit Content
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</div>

@endsection