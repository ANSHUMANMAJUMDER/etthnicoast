<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>

                {{-- Dashboard --}}
                <li class="{{ set_active(['home']) }}">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('public/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- ════════════════════════════════
                     CUSTOMERS
                ════════════════════════════════ --}}
                <li class="submenu {{ set_active(['admin/users*']) }}">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('public/assets/img/icons/users1.svg') }}" alt="img">
                        <span>Customers</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('admin.users.index') }}"
                               class="{{ set_active(['admin/users']) }}">
                                All Customers
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ════════════════════════════════
                     CATALOGUE
                ════════════════════════════════ --}}
                <li class="submenu {{ set_active(['products', 'pearl-types*', 'polish-types*', 'stone-types*', 'tab-categories*', 'categories*', 'category_type*']) }}">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Catalogue</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('products.index') }}"
                               class="{{ set_active(['products']) }}">
                                Products
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('tab-categories.index') }}"
                               class="{{ set_active(['tab-categories*']) }}">
                                Tab Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('categories.index') }}"
                               class="{{ set_active(['categories*']) }}">
                                Categories
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('category_type.index') }}"
                               class="{{ set_active(['category_type*']) }}">
                                Category Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('pearl-types.index') }}"
                               class="{{ set_active(['pearl-types*']) }}">
                                Pearl Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('polish-types.index') }}"
                               class="{{ set_active(['polish-types*']) }}">
                                Polish Types
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('stone-types.index') }}"
                               class="{{ set_active(['stone-types*']) }}">
                                Stone Types
                            </a>
                        </li>
                          {{-- Static Pages --}}
        <li>
            <a href="{{ route('admin.static-pages.index') }}"
               class="{{ set_active(['admin.static-pages*']) }}">
                Static Pages
            </a>
        </li>
                    </ul>
                </li>

                {{-- ════════════════════════════════
                     HOME PAGE CONTENT
                ════════════════════════════════ --}}
                <li class="submenu {{ set_active(['banners*', 'promo-strips*', 'collection-ranges*', 'home-page-banner-setups*', 'shop-by-life-styles*', 'jewellery-in-motions*', 'our-best-sellers*', 'etthnicoast-worlds*', 'shop-the-looks*', 'our-valued-partners*', 'home-customer-reviews*']) }}">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('public/assets/img/icons/banner-icon.svg') }}" alt="img">
                        <span>Home Page</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('banners.index') }}"
                               class="{{ set_active(['banners*']) }}">
                                Banners
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('promo-strips.index') }}"
                               class="{{ set_active(['promo-strips*']) }}">
                                Promo Strips
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('collection-ranges.index') }}"
                               class="{{ set_active(['collection-ranges*']) }}">
                                Collection Ranges
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home-page-banner-setups.index') }}"
                               class="{{ set_active(['home-page-banner-setups*']) }}">
                                Banner Setups
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop-by-life-styles.index') }}"
                               class="{{ set_active(['shop-by-life-styles*']) }}">
                                Shop By Lifestyle
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('jewellery-in-motions.index') }}"
                               class="{{ set_active(['jewellery-in-motions*']) }}">
                                Jewellery In Motion
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('our-best-sellers.index') }}"
                               class="{{ set_active(['our-best-sellers*']) }}">
                                Best Sellers
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('etthnicoast-worlds.index') }}"
                               class="{{ set_active(['etthnicoast-worlds*']) }}">
                                Etthnicoast Worlds
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('shop-the-looks.index') }}"
                               class="{{ set_active(['shop-the-looks*']) }}">
                                Shop The Looks
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('our-valued-partners.index') }}"
                               class="{{ set_active(['our-valued-partners*']) }}">
                                Valued Partners
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('home-customer-reviews.index') }}"
                               class="{{ set_active(['home-customer-reviews*']) }}">
                                Customer Reviews
                            </a>
                        </li>
                    </ul>
                </li>

                {{-- ════════════════════════════════
                     REPORTS
                ════════════════════════════════ --}}
                <li class="submenu {{ set_active(['reports*']) }}">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('public/assets/img/icons/sales1.svg') }}" alt="img">
                        <span>Reports</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li>
                            <a href="{{ route('reports.sales') }}"
                               class="{{ set_active(['reports/sales']) }}">
                                Monthly Sales
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</div>