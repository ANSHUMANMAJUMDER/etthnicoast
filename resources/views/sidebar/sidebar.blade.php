<div class="sidebar" id="sidebar">
    <div class="sidebar-inner slimscroll">
        <div id="sidebar-menu" class="sidebar-menu">
            <ul>
                <li class="{{set_active(['home'])}}">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('public/assets/img/icons/dashboard.svg') }}" alt="img">
                        <span>Dashboard</span>
                    </a>
                </li>

                {{-- Banner section  --}}
                    <li class="{{set_active(['banners'])}}">
                        <a href="{{ route('banners.index') }}">
                            <img src="{{ asset('public/assets/img/icons/banner-icon.svg') }}" alt="img">
                            <span>Banners</span>
                        </a>
                    </li>

                    {{-- Promo strip section --}}
                    <li class="{{set_active(['promo-strips'])}}">
                        <a href="{{ route('promo-strips.index') }}">
                            <img src="{{ asset('public/assets/img/icons/promotional-sticker.svg') }}" alt="img">
                            <span>Promo Strips</span>
                        </a>
                    </li>
                    {{-- Collection range section --}}
                    <li class="{{set_active(['collection-ranges'])}}">
                        <a href="{{ route('collection-ranges.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Collection Ranges</span>
                        </a>
                    </li>
                    {{-- Home page banner setup section --}}
                    <li class="{{set_active(['home-page-banner-setups'])}}">
                        <a href="{{ route('home-page-banner-setups.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Home Page Banner Setups</span>
                        </a>
                    </li>

                    {{-- Shop by lifestyle section --}}
                    <li class="{{set_active(['shop-by-life-styles'])}}">
                        <a href="{{ route('shop-by-life-styles.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Shop By Life Styles</span>
                        </a>
                    </li>
                    {{-- jewellery in motion section --}}
                    <li class="{{set_active(['jewellery-in-motions'])}}">
                        <a href="{{ route('jewellery-in-motions.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Jewellery In Motion</span>
                        </a>
                    </li>

                    {{-- our best sellers section --}}
                    <li class="{{set_active(['our-best-sellers'])}}">
                        <a href="{{ route('our-best-sellers.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Our Best Sellers</span>
                        </a>
                    </li>

                    {{-- Etthnicoast World section --}}
                    <li class="{{set_active(['etthnicoast-worlds'])}}">
                        <a href="{{ route('etthnicoast-worlds.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Etthnicoast Worlds</span>
                        </a>
                    </li>
                    {{-- Shop The Look section --}}
                    <li class="{{set_active(['shop-the-looks'])}}">
                        <a href="{{ route('shop-the-looks.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Shop The Looks</span>
                        </a>
                    </li>

                    {{-- OUr valued partner section --}}
                    <li class="{{set_active(['our-valued-partners'])}}">
                        <a href="{{ route('our-valued-partners.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Our Valued Partners</span>
                        </a>
                    </li>

                    {{-- Home review customer review section --}}
                    <li class="{{set_active(['home-customer-reviews'])}}">
                        <a href="{{ route('home-customer-reviews.index') }}">
                            <img src="{{ asset('public/assets/img/icons/plus.svg') }}" alt="img">
                            <span>Home Customer Reviews</span>
                        </a>
                    </li>

                <li class="{{set_active(['category_type/category_type_list'])}}">
                    <a href="{{ route('category_type.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Category Types</span>
                    </a>
                </li>
                <li class="{{set_active(['categories'])}}">
                    <a href="{{ route('categories.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Categories</span>
                    </a>
                </li>
                {{-- Pearl type      --}}
                     
                <li class="{{set_active(['pearl_types'])}}">
                    <a href="{{ route('pearl-types.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Pearl Types</span>
                    </a>
                </li>

                {{-- Pearl type      --}}
                <li class="{{set_active(['polish_types'])}}">
                    <a href="{{ route('polish-types.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Polish Types</span>
                    </a>
                </li>
                
                {{-- Stone type      --}}
                <li class="{{set_active(['stone_types'])}}">
                    <a href="{{ route('stone-types.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Stone Types</span>
                    </a>
                </li>

                {{-- Monthly sales report --}}
                <li class="{{set_active(['reports/sales'])}}">
                    <a href="{{ route('reports.sales') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Monthly Sales Report</span>
                    </a>
                </li>

                {{-- Products --}}
                <li class="{{set_active(['products'])}}">
                    <a href="{{ route('products.index') }}">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Products</span>
                    </a>

                {{-- <li class="submenu">
                    <a href="javascript:void(0);">
                        <img src="{{ asset('public/assets/img/icons/product.svg') }}" alt="img">
                        <span>Product</span>
                        <span class="menu-arrow"></span>
                    </a>
                    <ul>
                        <li><a href="{{ route('product/list') }}" class="{{set_active(['product/list'])}}">Product List</a></li>
                        <li><a href="{{ route('product/add') }}" class="{{set_active(['product/add'])}}">Add Product</a></li>
                        <li><a href="{{ route('product/categorylist') }}" class="{{set_active(['product/categorylist'])}}">Category List</a></li>
                        <li><a href="{{ route('product/addcategory') }}" class="{{set_active(['product/addcategory'])}}">Add Category</a></li>
                        <li><a href="{{ route('product/subcategorylist') }}" class="{{set_active(['product/subcategorylist'])}}">Sub Category List</a></li>
                        <li><a href="{{ route('product/subaddcategory') }}" class="{{set_active(['product/subaddcategory'])}}">Add Sub Category</a></li>
                        <li><a href="{{ route('product/brandlist') }}" class="{{set_active(['product/brandlist'])}}">Brand List</a></li>
                        <li><a href="{{ route('product/addbrand') }}" class="{{set_active(['product/addbrand'])}}">Add Brand</a></li>
                        <li><a href="{{ route('product/importproduct') }}" class="{{set_active(['product/importproduct'])}}">Import Products</a></li>
                        <li><a href="{{ route('product/barcode') }}" class="{{set_active(['product/barcode'])}}">Print Barcode</a></li>
                    </ul>
                </li> --}}
             
            </ul>
        </div>
    </div>
</div>