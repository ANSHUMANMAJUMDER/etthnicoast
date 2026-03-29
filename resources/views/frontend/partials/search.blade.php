<div class="search-overlay" id="searchOverlay">
    <button class="search-close" id="searchClose">
        <i class="fas fa-times"></i>
    </button>
    <div class="search-container">
        <div class="search-input-wrapper">
            <input
                type="text"
                class="search-input"
                placeholder="Search for jewelry..."
                id="searchInput"
                autocomplete="off"
            >
            <button class="search-icon-btn" id="searchBtn">
                <i class="fas fa-search"></i>
            </button>
        </div>

        <span class="search-label">Popular Searches</span>
        <div class="search-suggestions">
            <a href="#" class="search-suggestion-item" data-query="Rings">Rings</a>
            <a href="#" class="search-suggestion-item" data-query="Necklaces">Necklaces</a>
            <a href="#" class="search-suggestion-item" data-query="Earrings">Earrings</a>
            <a href="#" class="search-suggestion-item" data-query="Bracelets">Bracelets</a>
            <a href="#" class="search-suggestion-item" data-query="Bridal Sets">Bridal Sets</a>
            <a href="#" class="search-suggestion-item" data-query="New Arrivals">New Arrivals</a>
        </div>

        {{-- Live results --}}
        <div class="search-results-container" id="searchResults"></div>
    </div>
</div>

<script>
    window.searchAjaxUrl = "{{ route('search.ajax') }}";
</script>