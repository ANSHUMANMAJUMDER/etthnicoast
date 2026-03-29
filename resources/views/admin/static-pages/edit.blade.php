@extends('layouts.master')
@section('content')

<div class="page-wrapper">
    <div class="content">

        {{-- Page Header --}}
        <div class="page-header">
            <div class="page-title">
                <h4>Edit: {{ $label }}</h4>
                <h6>Manage content for the {{ $label }} page</h6>
            </div>
            <div class="page-btn">
                <a href="{{ route('admin.static-pages.index') }}" class="btn btn-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Back to Pages
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form method="POST"
              action="{{ route('admin.static-pages.update', $slug) }}"
              enctype="multipart/form-data">
            @csrf @method('PUT')

            {{-- ── HERO ────────────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-image me-2 text-primary"></i>Hero Section
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label">Tag <small class="text-muted">(small label above title)</small></label>
                            <input type="text" name="hero_tag" class="form-control"
                                   value="{{ old('hero_tag', $page->hero_tag) }}"
                                   placeholder="e.g. Our Commitment">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hero Title</label>
                            <input type="text" name="hero_title" class="form-control"
                                   value="{{ old('hero_title', $page->hero_title) }}"
                                   placeholder="e.g. Our Story">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Hero Subtitle</label>
                            <input type="text" name="hero_subtitle" class="form-control"
                                   value="{{ old('hero_subtitle', $page->hero_subtitle) }}"
                                   placeholder="e.g. Rooted in craft. Worn with intention.">
                        </div>
                        <div class="col-12">
                            <label class="form-label">Hero Image</label>
                            @if($page->hero_image)
                                <div class="mb-2 d-flex align-items-center gap-3">
                                    <img src="{{ asset('public/storage/' . $page->hero_image) }}"
                                         style="height:100px; width:200px; object-fit:cover; border-radius:6px; border:1px solid #dee2e6;">
                                    <small class="text-muted">Current image. Upload a new one to replace.</small>
                                </div>
                            @endif
                            <input type="file" name="hero_image" class="form-control" accept="image/*">
                            <small class="text-muted">Recommended: 1920×800px. Leave blank to keep existing.</small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── STATS / BADGES ──────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-chart-bar me-2 text-primary"></i>Stats / Badges
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="formatStats">
                            <i class="fa fa-code me-1"></i>Format
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" id="validateStats">
                            <i class="fa fa-check me-1"></i>Validate
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="statsStatus" class="mb-2" style="display:none;"></div>
                    <textarea name="stats_json" id="statsJson"
                              class="form-control font-monospace" rows="8"
                              style="font-size:.82rem; line-height:1.5;">{{ json_encode($page->stats, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                    <div class="mt-2 p-2 bg-light rounded">
                        <small class="text-muted d-block mb-1"><strong>Format for About / Why Us:</strong></small>
                        <code style="font-size:.78rem;">{"num": "10K+", "label": "Happy Customers"}</code>
                        <small class="text-muted d-block mt-1 mb-1"><strong>Format for Animal Welfare:</strong></small>
                        <code style="font-size:.78rem;">{"icon": "fa-solid fa-paw", "label": "Status", "value": "100% Cruelty Free"}</code>
                    </div>
                </div>
            </div>

            {{-- ── SECTIONS ─────────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-layer-group me-2 text-primary"></i>Page Sections
                    </h5>
                    <div class="d-flex gap-2">
                        <button type="button" class="btn btn-outline-secondary btn-sm" id="formatJson">
                            <i class="fa fa-code me-1"></i>Format
                        </button>
                        <button type="button" class="btn btn-outline-info btn-sm" id="validateJson">
                            <i class="fa fa-check me-1"></i>Validate
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div id="jsonStatus" class="mb-2" style="display:none;"></div>
                    <textarea name="sections_json" id="sectionsJson"
                              class="form-control font-monospace" rows="30"
                              style="font-size:.8rem; line-height:1.5;">{{ json_encode($page->sections, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) }}</textarea>
                    <div class="mt-2 p-2 bg-light rounded">
                        <small class="text-muted"><strong>Available section types for this page:</strong></small><br>
                        <div class="mt-1 d-flex flex-wrap gap-1">
                            @foreach(['intro','timeline','team','values','pillars','compare','promises','testimonials','channels','faq','contact_info','statement','commitments','feature_split','certifications'] as $type)
                                <span class="badge bg-secondary bg-opacity-75" style="font-size:.72rem;">{{ $type }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── CTA ──────────────────────────────────────────── --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fa fa-bullhorn me-2 text-primary"></i>CTA Banner
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">CTA Title</label>
                            <input type="text" name="cta_title" class="form-control"
                                   value="{{ old('cta_title', $page->cta_title) }}"
                                   placeholder="e.g. Find your piece of the story">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">CTA Subtitle</label>
                            <input type="text" name="cta_subtitle" class="form-control"
                                   value="{{ old('cta_subtitle', $page->cta_subtitle) }}"
                                   placeholder="e.g. Explore our latest collections">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button Text</label>
                            <input type="text" name="cta_button_text" class="form-control"
                                   value="{{ old('cta_button_text', $page->cta_button_text) }}"
                                   placeholder="e.g. Shop Now">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Button URL</label>
                            <input type="text" name="cta_button_url" class="form-control"
                                   value="{{ old('cta_button_url', $page->cta_button_url) }}"
                                   placeholder="e.g. /collection">
                        </div>
                    </div>
                </div>
            </div>

            {{-- ── ACTIONS ──────────────────────────────────────── --}}
            <div class="d-flex gap-2 mb-5">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fa fa-save me-2"></i>Save Changes
                </button>
                <a href="{{ url('/' . $slug) }}" target="_blank" class="btn btn-outline-secondary">
                    <i class="fa fa-eye me-2"></i>Preview Page ↗
                </a>
                <a href="{{ route('admin.static-pages.index') }}" class="btn btn-outline-danger ms-auto">
                    Cancel
                </a>
            </div>

        </form>
    </div>
</div>

@push('scripts')
<script>
// Sections JSON
document.getElementById('formatJson')?.addEventListener('click', () => {
    formatTextarea('sectionsJson', 'jsonStatus');
});
document.getElementById('validateJson')?.addEventListener('click', () => {
    validateTextarea('sectionsJson', 'jsonStatus');
});

// Stats JSON
document.getElementById('formatStats')?.addEventListener('click', () => {
    formatTextarea('statsJson', 'statsStatus');
});
document.getElementById('validateStats')?.addEventListener('click', () => {
    validateTextarea('statsJson', 'statsStatus');
});

function formatTextarea(taId, statusId) {
    const ta = document.getElementById(taId);
    try {
        ta.value = JSON.stringify(JSON.parse(ta.value), null, 2);
        showStatus(statusId, 'Formatted ✓', 'success');
    } catch(e) {
        showStatus(statusId, 'Invalid JSON: ' + e.message, 'danger');
    }
}

function validateTextarea(taId, statusId) {
    const ta = document.getElementById(taId);
    try {
        JSON.parse(ta.value);
        showStatus(statusId, 'Valid JSON ✓', 'success');
    } catch(e) {
        showStatus(statusId, 'Invalid JSON: ' + e.message, 'danger');
    }
}

function showStatus(id, msg, type) {
    const el = document.getElementById(id);
    el.className = `alert alert-${type} py-2`;
    el.textContent = msg;
    el.style.display = 'block';
    setTimeout(() => el.style.display = 'none', 3000);
}
</script>
@endpush

@endsection