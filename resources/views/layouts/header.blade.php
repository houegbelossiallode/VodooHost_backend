{{-- <!-- header -->
<header class="main-header">
    @php
        $user = auth()->user();
        $photo = $user->photo;
        // Initiales à partir du nom + prénom
        $initials = strtoupper(substr($user->nom, 0, 1) . substr($user->prenom ?? '', 0, 1));

        // Avatar généré si pas de photo
        $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
    @endphp
    <!--  logo  -->
    <div class="logo-holder"><a href="{{ route('hoost.home') }}"><img src="{{ asset('assets/images/voodoo/popo.png') }}"
            alt=""></a></div>
    <!-- logo end  -->
    <!-- nav-button-wrap-->
    <div class="nav-button-wrap color-bg nvminit">
        <div class="nav-button">
            <span></span><span></span><span></span>
        </div>
    </div>
    <!-- nav-button-wrap end-->
    <!-- header-search button  -->
    <div class="header-search-button">
        <i class="fal fa-search"></i>
        <span>Recherche</span>
    </div>
    
    <!-- header-search button end  -->
    <!--  add new  btn -->
    <div class="add-list_wrap">
        <a href="dashboard-add-listing.html" class="add-list color-bg"><i class="fal fa-plus"></i> <span>Add Listing</span></a>
    </div>
    <!--  add new  btn end -->
    <!--  header-opt_btn -->
    <div class="header-opt_btn tolt" data-microtip-position="bottom" data-tooltip="Language / Currency">
        <span><i class="fal fa-globe"></i></span>
    </div>
    <!--  header-opt_btn end -->
    <!--  cart-btn   -->
    <div class="cart-btn  tolt show-header-modal" data-microtip-position="bottom"
        data-tooltip="{{ __('messages.wishlist') }} / {{ __('messages.compare') }}">
        <i class="fal fa-bell"></i>
        <span class="cart-btn_counter color-bg">5</span>
    </div>
    <!--  cart-btn end -->
    <!--  login btn -->
    <div class="show-reg-form dasbdord-submenu-open"><img src="{{ auth()->user()->photo ?? $avatar }}" alt="">
    </div>
    <!--  login btn  end -->
    <!--  dashboard-submenu-->
    <div class="dashboard-submenu">
        <div class="dashboard-submenu-title fl-wrap">Bienvenue,
            <span>{{ auth()->user()->nom ?? __('messages.user') }}</span>
        </div>
        <ul>
            <li><a href="{{ route('hoost.reservations.history') }}"><i class="fas fa-plane"></i>Mes précédents séjours</a></li>
            <li><a href="{{ route('hoost.profile.aide') }}"> <i class="fal fa-file-plus"></i>Centre d'aide</a></li>
            <li><a href="{{ route('hoost.notifications.edit') }}"> <i class="fal fa-bell"></i>Notifications</a></li>
            <li><a href="{{ route('hoost.preferences.edit') }}"> <i class="fal fa-magic"></i>Expérience culturelle</a></li>
            <li><a href="{{ route('hoost.profile.index') }}"><i class="fal fa-user-edit"></i>{{ __('messages.settings') }}</a></li>
        </ul>
        <a href="{{ route('hoost.logout') }}" class="color-bg db_log-out"><i
                class="far fa-power-off"></i>{{ __('messages.logout') }}</a>
    </div>
    <!--  dashboard-submenu  end -->
    <!--  navigation -->
    <div class="nav-holder main-menu">
                    <nav>
                        <ul class="no-list-style">
                            <li>
                                <a href="#">Home <i class="fa fa-caret-down"></i></a>
                                <!--second level -->
                                <ul>
                                    <li><a href="index.html">Parallax Image</a></li>
                                    <li><a href="index2.html">Slider</a></li>
                                    <li><a href="index3.html">Video</a></li>
                                    <li><a href="index4.html">Slideshow</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                            <li>
                                <a href="#">Listings <i class="fa fa-caret-down"></i></a>
                                <!--second level -->
                                <ul>
                                    <li><a href="listing.html">Column map</a></li>
                                    <li><a href="listing2.html">Column map 2</a></li>
                                    <li><a href="listing3.html">Fullwidth Map</a></li>
                                    <li><a href="listing4.html">Fullwidth Map 2</a></li>
                                    <li><a href="listing5.html">Without Map</a></li>
                                    <li><a href="listing6.html">Without Map 2</a></li>
                                    <li>
                                        <a href="#">Single <i class="fa fa-caret-down"></i></a>
                                        <!--third  level  -->
                                        <ul>
                                            <li><a href="listing-single.html">Style 1</a></li>
                                            <li><a href="listing-single2.html">Style 2</a></li>
                                            <li><a href="listing-single3.html">Style 3</a></li>
                                        </ul>
                                        <!--third  level end-->
                                    </li>
                                </ul>
                                <!--second level end-->
                            </li>
                            <li>
                                <a href="#">Agents<i class="fa fa-caret-down"></i></a>
                                <!--second level -->
                                <ul>
                                    <li><a href="agent-list.html">Agent List</a></li>
                                    <li><a href="agency-list.html">Agency List</a></li>
                                    <li><a href="agent-single.html">Agent Single</a></li>
                                    <li><a href="agency-single.html">Agency Single</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                            <li>
                                <a href="blog.html">News</a>
                            </li>
                            <li>
                                <a href="#" class="act-link">Pages <i class="fa fa-caret-down"></i></a>
                                <!--second level -->
                                <ul>
                                    <li><a href="about.html">About</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="help.html">Help FAQ</a></li>
                                    <li><a href="pricing.html">Pricing </a></li>
                                    <li><a href="dashboard.html">User Dashboard</a></li>
                                    <li><a href="blog-single.html">Blog Single</a></li>
                                    <li><a href="compare.html">Compare</a></li>
                                    <li><a href="coming-soon.html">Coming Soon</a></li>
                                    <li><a href="404.html">404</a></li>
                                </ul>
                                <!--second level end-->
                            </li>
                        </ul>
                    </nav>
                </div>
    <!-- navigation  end -->
    <!-- header-search-wrapper -->
    <div class="header-search-wrapper novis_search">
        <div class="header-serach-menu">

        </div>

        <div class="custom-form">
            <form method="post" name="registerform">
                <label>Mots-clés</label>
                <input type="text" placeholder="Adresse, Rue, Ville..." value="" />
                <button type="button" onclick="location.href='listing.html'" class="btn float-btn color-bg">
                    <i class="fal fa-search"></i> Rechercher
                </button>
            </form>
        </div>
        <!-- header-search-wrapper end  -->
        <!-- wishlist-wrap-->
        <div class="header-modal novis_wishlist tabs-act">
            <ul class="tabs-menu fl-wrap no-list-style">
                <li class="current"><a href="#tab-wish"> Wishlist <span>- 3</span></a></li>
                <li><a href="#tab-compare"> Compare <span>- 2</span></a></li>
            </ul>
            <!--tabs -->
            <div class="tabs-container">
                <div class="tab">
                    <!--tab -->
                    <div id="tab-wish" class="tab-content first-tab">
                        <!-- header-modal-container-->
                        <div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
                            <!--widget-posts-->
                            <div class="widget-posts  fl-wrap">
                                <ul class="no-list-style">
                                    <li>
                                        <div class="widget-posts-img"><a href="listing-single.html"><img
                                                    src="images/all/small/1.jpg" alt=""></a>
                                        </div>
                                        <div class="widget-posts-descr">
                                            <h4><a href="listing-single.html">Affordable Urban Room</a></h4>
                                            <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                        class="fas fa-map-marker-alt"></i> 40 Journal Square , NJ,
                                                    USA</a></div>
                                            <div class="widget-posts-descr-price"><span>Price: </span> $ 1500 / per
                                                month</div>
                                            <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="widget-posts-img"><a href="listing-single.html"><img
                                                    src="images/all/small/1.jpg" alt=""></a>
                                        </div>
                                        <div class="widget-posts-descr">
                                            <h4><a href="listing-single.html">Family House</a></h4>
                                            <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                        class="fas fa-map-marker-alt"></i> 34-42 Montgomery St , NY,
                                                    USA</a></div>
                                            <div class="widget-posts-descr-price"><span>Price: </span> $ 50.000</div>
                                            <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="widget-posts-img"><a href="listing-single.html"><img
                                                    src="images/all/small/1.jpg" alt=""></a>
                                        </div>
                                        <div class="widget-posts-descr">
                                            <h4><a href="listing-single.html">Apartment to Rent</a></h4>
                                            <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                        class="fas fa-map-marker-alt"></i>75 Prince St, NY, USA</a>
                                            </div>
                                            <div class="widget-posts-descr-price"><span>Price: </span> $100 / per night
                                            </div>
                                            <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- widget-posts end-->
                        </div>
                        <!-- header-modal-container end-->
                        <div class="header-modal-top fl-wrap">
                            <div class="clear_wishlist color-bg"><i class="fal fa-trash-alt"></i> Clear all</div>
                        </div>
                    </div>
                    <!--tab end -->
                    <!--tab -->
                    <div class="tab">
                        <div id="tab-compare" class="tab-content">
                            <!-- header-modal-container-->
                            <div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
                                <!--widget-posts-->
                                <div class="widget-posts  fl-wrap">
                                    <ul class="no-list-style">
                                        <li>
                                            <div class="widget-posts-img"><a href="listing-single.html"><img
                                                        src="images/all/small/1.jpg" alt=""></a>
                                            </div>
                                            <div class="widget-posts-descr">
                                                <h4><a href="listing-single.html">Gorgeous house for sale</a></h4>
                                                <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                            class="fas fa-map-marker-alt"></i> 70 Bright St New York,
                                                        USA </a></div>
                                                <div class="widget-posts-descr-price"><span>Price: </span> $ 52.100
                                                </div>
                                                <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="widget-posts-img"><a href="listing-single.html"><img
                                                        src="images/all/small/1.jpg" alt=""></a>
                                            </div>
                                            <div class="widget-posts-descr">
                                                <h4><a href="listing-single.html">Family Apartments</a></h4>
                                                <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                            class="fas fa-map-marker-alt"></i> W 85th St, New York, USA
                                                    </a></div>
                                                <div class="widget-posts-descr-price"><span>Price: </span> $ 72.400
                                                </div>
                                                <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <!-- widget-posts end-->
                            </div>
                            <!-- header-modal-container end-->
                            <div class="header-modal-top fl-wrap">
                                <a class="clear_wishlist color-bg" href="compare.html"><i class="fal fa-random"></i>
                                    Compare</a>
                            </div>
                        </div>
                    </div>
                    <!--tab end -->
                </div>
                <!--tabs end -->
            </div>
        </div>
        <!--wishlist-wrap end -->
        <!--header-opt-modal-->
        <div class="header-opt-modal novis_header-mod">
            <div class="header-opt-modal-container hopmc_init">
                <div class="header-opt-modal-item lang-item fl-wrap">
                    <h4>
                        {{ __('messages.language') }} :
                        <span>{{ app()->getLocale() }}</span>
                    </h4>

                    <div class="header-opt-modal-list fl-wrap">
                        <ul>
                            <li>
                                <a href="#" data-lang="en"
                                    onclick="changeLanguageWithGoogle('en'); return false;">
                                    English
                                </a>
                            </li>
                            <li>
                                <a href="#" data-lang="fr"
                                    onclick="changeLanguageWithGoogle('fr'); return false;">
                                    Français
                                </a>
                            </li>
                            <li>
                                <a href="#" data-lang="es"
                                    onclick="changeLanguageWithGoogle('es'); return false;">
                                    Español
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="header-opt-modal-item currency-item fl-wrap">
                    <h4>{{ __('messages.currency') }}: <span>USD</span></h4>
                    <div class="header-opt-modal-list fl-wrap">
                        <ul>
                            <li><a href="#" class="current-lan" data-lantext="USD">USD</a></li>
                            <li><a href="#" data-lantext="EUR">EUR</a></li>
                            <li><a href="#" data-lantext="GBP">GBP</a></li>
                            <li><a href="#" data-lantext="RUR">RUR</a></li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!--header-opt-modal end -->
</header> --}}



<!-- header -->
<header class="main-header">
    <!--  logo  -->
     @php
        $user = auth()->user();
        $photo = $user->photo;
        // Initiales à partir du nom + prénom
        $initials = strtoupper(substr($user->nom, 0, 1) . substr($user->prenom ?? '', 0, 1));

        // Avatar généré si pas de photo
        $avatar = "https://ui-avatars.com/api/?name={$initials}&background=D1B11B&color=fff&size=128&rounded=true";
    @endphp
    <!--  logo  -->
    <div class="logo-holder"><a href="{{ route('hoost.home') }}"><img src="{{ asset('assets/images/voodoo/popo.png') }}" alt=""></a></div>
    <!-- logo end  -->
    <!-- nav-button-wrap-->
    <div class="nav-button-wrap color-bg nvminit">
        <div class="nav-button">
            <span></span><span></span><span></span>
        </div>
    </div>
    <!-- nav-button-wrap end-->
    <!-- header-search button  -->
    <div class="header-search-button">
        <i class="fal fa-search"></i>
        <span>Recherche...</span>
    </div>
    <!-- header-search button end  -->
    <!--  add new  btn -->
    {{-- <div class="add-list_wrap">
        <a href="dashboard-add-listing.html" class="add-list color-bg"><i class="fal fa-plus"></i> <span>Add Listing</span></a>
    </div> --}}
    <!--  add new  btn end -->
    <!--  header-opt_btn -->
    <div class="header-opt_btn tolt" data-microtip-position="bottom" data-tooltip="Language / Currency">
        <span><i class="fal fa-globe"></i></span>
    </div>
    <!--  header-opt_btn end -->
    <!--  cart-btn   -->
    <div class="cart-btn  tolt show-header-modal" data-microtip-position="bottom"
        data-tooltip="Notifications">
        <i class="fal fa-bell"></i>
        <span class="cart-btn_counter color-bg">5</span>
    </div>
    <!--  cart-btn end -->
    <!--  login btn -->
     <div class="show-reg-form dasbdord-submenu-open"><img src="{{ auth()->user()->photo ?? $avatar }}" alt=""></div>
    <!--  login btn  end -->
    <!--  dashboard-submenu-->
    <div class="dashboard-submenu">
        <div class="dashboard-submenu-title fl-wrap">Bienvenue,
            <span>{{ auth()->user()->nom ?? __('messages.user') }}</span>
        </div>
        <ul>
            <li><a href="{{ route('hoost.reservations.history') }}"><i class="fas fa-plane"></i>Mes précédents séjours</a></li>
            <li><a href="{{ route('hoost.profile.aide') }}"> <i class="fal fa-file-plus"></i>Centre d'aide</a></li>
            <li><a href="{{ route('hoost.notifications.edit') }}"> <i class="fal fa-bell"></i>Notifications</a></li>
            <li><a href="{{ route('hoost.preferences.edit') }}"> <i class="fal fa-magic"></i>Expérience culturelle</a></li>
            <li><a href="{{ route('hoost.profile.index') }}"><i class="fal fa-user-edit"></i>{{ __('messages.settings') }}</a></li>
        </ul>
        <a href="{{ route('hoost.logout') }}" class="color-bg db_log-out"><i class="far fa-power-off"></i>{{ __('messages.logout') }}</a>
    </div>
    <!--  dashboard-submenu  end -->
    <!--  navigation -->
    {{-- <div class="nav-holder main-menu">
        <nav>
            <ul class="no-list-style">
                <li>
                    <a href="#">Home <i class="fa fa-caret-down"></i></a>
                    <!--second level -->
                    <ul>
                        <li><a href="index.html">Parallax Image</a></li>
                        <li><a href="index2.html">Slider</a></li>
                        <li><a href="index3.html">Video</a></li>
                        <li><a href="index4.html">Slideshow</a></li>
                    </ul>
                    <!--second level end-->
                </li>
                <li>
                    <a href="#">Listings <i class="fa fa-caret-down"></i></a>
                    <!--second level -->
                    <ul>
                        <li><a href="listing.html">Column map</a></li>
                        <li><a href="listing2.html">Column map 2</a></li>
                        <li><a href="listing3.html">Fullwidth Map</a></li>
                        <li><a href="listing4.html">Fullwidth Map 2</a></li>
                        <li><a href="listing5.html">Without Map</a></li>
                        <li><a href="listing6.html">Without Map 2</a></li>
                        <li>
                            <a href="#">Single <i class="fa fa-caret-down"></i></a>
                            <!--third  level  -->
                            <ul>
                                <li><a href="listing-single.html">Style 1</a></li>
                                <li><a href="listing-single2.html">Style 2</a></li>
                                <li><a href="listing-single3.html">Style 3</a></li>
                            </ul>
                            <!--third  level end-->
                        </li>
                    </ul>
                    <!--second level end-->
                </li>
                <li>
                    <a href="#">Agents<i class="fa fa-caret-down"></i></a>
                    <!--second level -->
                    <ul>
                        <li><a href="agent-list.html">Agent List</a></li>
                        <li><a href="agency-list.html">Agency List</a></li>
                        <li><a href="agent-single.html">Agent Single</a></li>
                        <li><a href="agency-single.html">Agency Single</a></li>
                    </ul>
                    <!--second level end-->
                </li>
                <li>
                    <a href="blog.html">News</a>
                </li>
                <li>
                    <a href="#" class="act-link">Pages <i class="fa fa-caret-down"></i></a>
                    <!--second level -->
                    <ul>
                        <li><a href="about.html">About</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="help.html">Help FAQ</a></li>
                        <li><a href="pricing.html">Pricing </a></li>
                        <li><a href="dashboard.html">User Dashboard</a></li>
                        <li><a href="blog-single.html">Blog Single</a></li>
                        <li><a href="compare.html">Compare</a></li>
                        <li><a href="coming-soon.html">Coming Soon</a></li>
                        <li><a href="404.html">404</a></li>
                    </ul>
                    <!--second level end-->
                </li>
            </ul>
        </nav>
    </div> --}}
    <!-- navigation  end -->
    <!-- header-search-wrapper -->
    <div class="header-search-wrapper novis_search">
        {{-- <div class="header-serach-menu">
            <div class="custom-switcher fl-wrap">
                <div class="fieldset fl-wrap">
                    <input type="radio" name="duration-1" id="buy_sw" class="tariff-toggle" checked>
                    <label for="buy_sw">Buy</label>
                    <input type="radio" name="duration-1" class="tariff-toggle" id="rent_sw">
                    <label for="rent_sw" class="lss_lb">Rent</label>
                    <span class="switch color-bg"></span>
                </div>
            </div>
        </div> --}}
        <div class="custom-form">
            <form method="post" name="registerform">
                <label>Mots clés</label>
                <input type="text" placeholder="recherche" value="" />
                <button onclick="location.href='listing.html'" type="button" class="btn float-btn color-bg"><i class="fal fa-search"></i>Recherche</button>
            </form>
        </div>
    </div>
    <!-- header-search-wrapper end  -->
    <!-- wishlist-wrap-->
    <div class="header-modal novis_wishlist tabs-act">
        {{-- <ul class="tabs-menu fl-wrap no-list-style">
            <li class="current"><a href="#tab-wish"> Wishlist <span>- 3</span></a></li>
            <li><a href="#tab-compare"> Compare <span>- 2</span></a></li>
        </ul> --}}
        <!--tabs -->
        <div class="tabs-container">
            {{-- <div class="tab"> --}}
                <!--tab -->
                <div id="tab-wish" class="tab-content first-tab">
                    <!-- header-modal-container-->
                    <div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
                        <!--widget-posts-->
                        <div class="widget-posts  fl-wrap">
                            <ul class="no-list-style">
                                <li>
                                    <div class="widget-posts-img"><a href="listing-single.html"><img
                                                src="images/all/small/1.jpg" alt=""></a>
                                    </div>
                                    <div class="widget-posts-descr">
                                        <h4><a href="listing-single.html">Affordable Urban Room</a></h4>
                                        <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                    class="fas fa-map-marker-alt"></i> 40 Journal Square , NJ, USA</a>
                                        </div>
                                        <div class="widget-posts-descr-price"><span>Price: </span> $ 1500 / per month
                                        </div>
                                        {{-- <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div> --}}
                                    </div>
                                </li>
                                
                            </ul>
                        </div>
                        <!-- widget-posts end-->
                    </div>
                    <!-- header-modal-container end-->
                    <div class="header-modal-top fl-wrap">
                        <div class="clear_wishlist color-bg"><i class="fal fa-eye-alt"></i> Afficher toutes les notifications</div>
                    </div>
                {{-- </div> --}}
                <!--tab end -->
                <!--tab -->
                {{-- <div class="tab">
                    <div id="tab-compare" class="tab-content">
                        <!-- header-modal-container-->
                        <div class="header-modal-container scrollbar-inner fl-wrap" data-simplebar>
                            <!--widget-posts-->
                            <div class="widget-posts  fl-wrap">
                                <ul class="no-list-style">
                                    <li>
                                        <div class="widget-posts-img"><a href="listing-single.html"><img
                                                    src="images/all/small/1.jpg" alt=""></a>
                                        </div>
                                        <div class="widget-posts-descr">
                                            <h4><a href="listing-single.html">Gorgeous house for sale</a></h4>
                                            <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                        class="fas fa-map-marker-alt"></i> 70 Bright St New York, USA
                                                </a></div>
                                            <div class="widget-posts-descr-price"><span>Price: </span> $ 52.100</div>
                                            <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                        </div>
                                    </li>
                                    <li>
                                        <div class="widget-posts-img"><a href="listing-single.html"><img
                                                    src="images/all/small/1.jpg" alt=""></a>
                                        </div>
                                        <div class="widget-posts-descr">
                                            <h4><a href="listing-single.html">Family Apartments</a></h4>
                                            <div class="geodir-category-location fl-wrap"><a href="#"><i
                                                        class="fas fa-map-marker-alt"></i> W 85th St, New York, USA
                                                </a></div>
                                            <div class="widget-posts-descr-price"><span>Price: </span> $ 72.400</div>
                                            <div class="clear-wishlist"><i class="fal fa-trash-alt"></i></div>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                            <!-- widget-posts end-->
                        </div>
                        <!-- header-modal-container end-->
                        <div class="header-modal-top fl-wrap">
                            <a class="clear_wishlist color-bg" href="compare.html"><i class="fal fa-random"></i>Compare</a>
                        </div>
                    </div>
                </div> --}}
                <!--tab end -->
            </div>
            <!--tabs end -->
        </div>
    </div>
    <!--wishlist-wrap end -->
    <!--header-opt-modal-->
    <div class="header-opt-modal novis_header-mod">
        <div class="header-opt-modal-container hopmc_init">
            <div class="header-opt-modal-item lang-item fl-wrap">
                <h4>Language: <span>EN</span></h4>
                <div class="header-opt-modal-list fl-wrap">
                    <ul>
                        <li><a href="#" class="current-lan" data-lantext="EN">English</a></li>
                        <li><a href="#" data-lantext="FR">Franais</a></li>
                        <li><a href="#" data-lantext="ES">Espaol</a></li>
                        <li><a href="#" data-lantext="DE">Deutsch</a></li>
                    </ul>
                </div>
            </div>
            <div class="header-opt-modal-item currency-item fl-wrap">
                <h4>Currency: <span>USD</span></h4>
                <div class="header-opt-modal-list fl-wrap">
                    <ul>
                        <li><a href="#" class="current-lan" data-lantext="USD">USD</a></li>
                        <li><a href="#" data-lantext="EUR">EUR</a></li>
                        <li><a href="#" data-lantext="GBP">GBP</a></li>
                        <li><a href="#" data-lantext="RUR">RUR</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--header-opt-modal end -->
</header>
