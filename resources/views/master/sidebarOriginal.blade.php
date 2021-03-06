<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href=""><img src="{{URL::asset('assets/img/brand/logo.png')}}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href=""><img src="{{URL::asset('assets/img/brand/logo-white.png')}}" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href=""><img src="{{URL::asset('assets/img/brand/favicon.png')}}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href=""><img src="{{URL::asset('assets/img/brand/favicon-white.png')}}" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        <div class="app-sidebar__user clearfix">
            <div class="dropdown user-pro-body">
                <a href="{{route('dashboard.index')}}">
                    <div class="">
                        <img alt="user-img" class="avatar avatar-xl brround" src="{{URL::asset('assets/img/faces/6.jpg')}}">
                        <span class="avatar-status profile-status bg-green"></span>
                    </div>
                </a>
                <div class="user-info">
                    <p></p>
                    <span class="mb-0 text-muted">Principale</span>
                </div>
            </div>
        </div>
        <ul class="side-menu"> 

            <!-- Dashboard -->
            <li class="slide">
                <a class="side-menu__item" href="{{route('dashboard.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                <span class="side-menu__label">
                    @lang('sidebar.dashboard')
                </span>
            </a>
            </li>
            <!-- Models or Parameters -->
            <li class="side-item side-item-category">@lang('sidebar.administration')</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs">
                        <line x1="4" y1="21" x2="4" y2="14"></line>
                        <line x1="4" y1="10" x2="4" y2="3"></line>
                        <line x1="12" y1="21" x2="12" y2="12"></line>
                        <line x1="12" y1="8" x2="12" y2="3"></line>
                        <line x1="20" y1="21" x2="20" y2="16"></line>
                        <line x1="20" y1="12" x2="20" y2="3"></line>
                        <line x1="1" y1="14" x2="7" y2="14"></line>
                        <line x1="9" y1="8" x2="15" y2="8"></line>
                        <line x1="17" y1="16" x2="23" y2="16"></line>
                    </svg>

                    <span class="side-menu__label">
                        @lang('sidebar.parametres')
                    </span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <!------------------------------------------------------------------------------------------------->
                    <li class="side-item side-item-category">Cat 1</li>
                    <!-- Axes -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('axes.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.axes')
                            </span>
                        </a>
                    </li>
                    <!-- Indicateurs -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('indicateurs.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">@lang('sidebar.indicateurs')</span>
                        </a>
                    </li>
                    <!-- Regions-->
                    <li class="slide">
                        <a class="side-menu__item"  href="{{route('regions.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">@lang('sidebar.regions')
                            </span>
                        </a>
                    </li>
                    <!-- Secteurs -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('secteurs.index')}}"> 
                            <i class="fas fa-ellipsis-h custom_style_icon"></i> 
                            <span class="side-menu__label">
                                @lang('sidebar.secteurs')
                            </span>
                        </a>
                    </li>
                    <!-- Structures -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('structures.index')}}"> 
                            <i class="fas fa-ellipsis-h custom_style_icon"></i> 
                            <span class="side-menu__label">
                                @lang('sidebar.structures')
                            </span>
                        </a>
                    </li>
                    <!-- Unites -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('unites.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.unites')
                            </span>
                        </a>
                    </li>
                    <!--Type Credit-->
                    <li class="slide">
                        <a class="side-menu__item"  href="{{route('typecredits.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"> </i>
                            <span class="side-menu__label"> @lang('sidebar.typeCredits') </span>
                        </a>
                    </li>
                    <!-- Qualites -->
                    <li class="slide">
                        <a class="side-menu__item"  href="{{route('qualites.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.qualites')
                            </span>
                        </a>
                    </li>
                    <!------------------------------------------------------------------------------------------------->
                    <li class="side-item side-item-category">Cat 2</li>
                    
                    <!-- Attribution -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('attributions.index')}}">
                            <i class="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.attributions')
                            </span>
                        </a>
                    </li>
                    <!-- Objectif -->
                    <li class="slide">
                        <a class="side-menu__item"  href="{{route('objectifs.index')}}">
                            <i class ="fas fa-ellipsis-h custom_style_icon"></i>
                            <span class="side-menu__label"> @lang('sidebar.objectifs') </span>
                        </a>
                    </li>
                    <!-- Dpcis -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('dpcis.index')}}">
                            <i class="fas fa-grip-horizontal custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.dpcis')
                            </span>
                        </a>
                    </li>
                    <!------------------------------------------------------------------------------------------------->
                    <li class="side-item side-item-category">Cat 3</li>
                    <!-- Ressources Humaines -->
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('rhs.index')}}">
                            <i class="fas fa-boxes custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.rhsds')
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            
            <!-- SIDEBAR.USER -->
            
            <li class="side-item side-item-category">@lang('sidebar.users')</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon" viewBox="0 0 24 24" >
                        <path d="M0 0h24v24H0V0z" fill="none"/>
                        <path d="M15 11V4H4v8.17l.59-.58.58-.59H6z" opacity=".3"/>
                        <path d="M21 6h-2v9H6v2c0 .55.45 1 1 1h11l4 4V7c0-.55-.45-1-1-1zm-5 7c.55 0 1-.45 1-1V3c0-.55-.45-1-1-1H3c-.55 0-1 .45-1 1v14l4-4h10zM4.59 11.59l-.59.58V4h11v7H5.17l-.58.59z"/>
                    </svg>
                        <span class="side-menu__label">
                            @lang('sidebar.users')
                        </span>
                        <i class="angle fe fe-chevron-down"></i>
                    </a>
                <ul class="slide-menu">
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('users.index')}}">
                            <i class="fas fa-users custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.liste user')
                            </span>
                        </a>
                    </li>
                    {{-- <li><a class="slide-item" href="{{route('roles.index')}}">R??les des utilisateurs</a></li> --}}
                </ul>
            </li>
            
        </ul>
    </div>
</aside>
