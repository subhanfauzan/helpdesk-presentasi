<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="html/index.html" class="logo-link nk-sidebar-logo">
                <img class="logo-light logo-img" src="{{ asset('public/image/Logo_Posyandu.png') }}" srcset="./images/logo2x.png 2x" alt="logo">
                <img class="logo-dark logo-img" src="{{ asset('public/image/Logo_Posyandu.png') }}" srcset="./images/logo-dark2x.png 2x" alt="logo-dark">
                <img class="logo-small logo-img logo-img-small" src="{{ asset('public/image/Logo_Posyandu.png') }}" srcset="./images/logo-small2x.png 2x" alt="logo-small">
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><em class="icon ni ni-arrow-left"></em></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><em class="icon ni ni-menu"></em></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-heading">
                        <h6 class="overline-title text-primary-alt">Use-Case Preview</h6>
                    </li><!-- .nk-menu-item -->

                    <li class="nk-menu-item">
                        <a href="{{url('home/index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">Dashboard</span>
                        </a>
                    </li><!-- .nk-menu-item -->
                    @foreach(Session::get('user_app')['menu'] as $datas => $value)
                    

                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-dashboard-fill"></em></span>
                            <span class="nk-menu-text">{{$datas}}</span>
                        </a>
                        <ul class="nk-menu-sub">
                           
                            
                            @php
                            for($i = 0; $i < count($value); $i++){
                            @endphp
                                <li class="nk-menu-item">
                                    <a href="{{url($value[$i]['m_sub_menu_url_sub_menu'])}}" class="nk-menu-link"><span class="nk-menu-text">{{$value[$i]['m_sub_menu_nama_sub_menu']}}</span></a>
                                </li>
                            @php
                            }
                            @endphp

                            
                            

                        </ul><!-- .nk-menu-sub -->
                    </li>
                    @endforeach

                    <!-- <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-users"></em></span>
                            <span class="nk-menu-text">Master</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('user/index')}}" class="nk-menu-link"><span class="nk-menu-text">User</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('role/index')}}" class="nk-menu-link"><span class="nk-menu-text">Role</span></a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{url('menu/index')}}" class="nk-menu-link"><span class="nk-menu-text">Menu</span></a>
                            </li>
                        </ul>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><em class="icon ni ni-menu"></em></span>
                            <span class="nk-menu-text">Mapping</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{url('mapping_menu/index')}}" class="nk-menu-link"><span class="nk-menu-text">Mapping Menu</span></a>
                            </li>
                        </ul>
                    </li> -->
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>