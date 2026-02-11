{{-- <!-- wrapper  -->	
            <div id="wrapper">
                <!-- dashbard-menu-wrap -->	
                <div class="dashbard-menu-overlay"></div>
                <div class="dashbard-menu-wrap">
                    <div class="dashbard-menu-close"><i class="fal fa-times"></i></div>
                    <div class="dashbard-menu-container">
                        <!-- user-profile-menu-->
                        <div class="user-profile-menu">
                            <h3>Main</h3>
                            <ul class="no-list-style">
                                <li><a href="dashboard.html" class="user-profile-act"><i class="fal fa-chart-line"></i>Dashboard</a></li>
                                <li><a href="dashboard-myprofile.html"><i class="fal fa-user-edit"></i> Edit profile</a></li>
                                <li><a href="dashboard-messages.html"><i class="fal fa-envelope"></i> Messages <span>3</span></a></li>
                                <li><a href="dashboard-agents.html"><i class="fal fa-users"></i> Agents List</a></li>
                                <li>
                                    <a href="#" class="submenu-link"><i class="fal fa-plus"></i>Submenu</a>
                                    <ul  class="no-list-style">
                                        <li><a href="#"><i class="fal fa-th-list"></i> Submenu 2 </a></li>
                                        <li><a href="#"> <i class="fal fa-calendar-check"></i> Submenu 2</a></li>
                                        <li><a href="#"><i class="fal fa-comments-alt"></i>Submenu 2</a></li>
                                        <li><a href="#"><i class="fal fa-file-plus"></i> Submenu 2</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!-- user-profile-menu end-->
                        <!-- user-profile-menu-->
                        <div class="user-profile-menu">
                            <h3>Listings</h3>
                            <ul  class="no-list-style">
                                <li><a href="dashboard-listing-table.html"><i class="fal fa-th-list"></i> My listigs  </a></li>
                                <li><a href="dashboard-bookings.html"> <i class="fal fa-calendar-check"></i> Bookings <span>2</span></a></li>
                                <li><a href="dashboard-review.html"><i class="fal fa-comments-alt"></i> Reviews </a></li>
                                <li><a href="dashboard-add-listing.html"><i class="fal fa-file-plus"></i> Add New</a></li>
                            </ul>
                        </div>
                        <!-- user-profile-menu end--> 
                    </div>
                    <div class="dashbard-menu-footer">© Homeradar 2022 .  All rights reserved.</div>
                </div>
                <!-- dashbard-menu-wrap end  --> --}}


<!-- wrapper  -->   
<div id="wrapper">
    <!-- dashbard-menu-wrap --> 
    <div class="dashbard-menu-overlay"></div>
    <div class="dashbard-menu-wrap">
        <div class="dashbard-menu-close"><i class="fal fa-times"></i></div>
        <div class="dashbard-menu-container">
            <!-- user-profile-menu-->
            <div class="user-profile-menu">
                <h3>Menu Principal</h3>
                <ul class="no-list-style">
                    <li><a href="{{ route('hoost.home') }}" class="user-profile-act"><i class="fal fa-home"></i> Accueil</a></li>
                    
                    @foreach ($mainmenus as $menu)
                        @if($menu->sousmenus->isEmpty())
                            <li>
                                <a href="{{ Route::has($menu->url) ? route($menu->url) : '#' }}">
                                    <i class="fal {{ $menu->icon }}"></i> {{ $menu->name }}
                                </a>
                            </li>
                        @else
                            <li>
                                <a href="#" class="submenu-link">
                                    <i class="fal {{ $menu->icon }}"></i> {{ $menu->name }}
                                </a>
                                <ul class="no-list-style">
                                    @foreach ($menu->sousmenus as $sousmenu)
                                        <li>
                                            <a href="{{ Route::has($sousmenu->url) ? route($sousmenu->url) : '#' }}">
                                                <i class="fal fa-angle-right"></i> {{ $sousmenu->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>
            <!-- user-profile-menu end-->
        </div>
        <div class="dashbard-menu-footer">© Votre Application {{ date('Y') }}. Tous droits réservés.</div>
    </div>
    <!-- dashbard-menu-wrap end  -->
</div>