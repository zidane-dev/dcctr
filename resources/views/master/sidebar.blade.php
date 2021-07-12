<!-- main-sidebar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar sidebar-scroll">
    <div class="main-sidebar-header active">
        <a class="desktop-logo logo-light active" href=""><img src="{{URL::asset('assets/img/mcinet/logo.png')}}" class="main-logo" alt="logo"></a>
        <a class="desktop-logo logo-dark active" href=""><img src="{{URL::asset('assets/img/mcinet/logo.png')}}" class="main-logo dark-theme" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-light active" href=""><img src="{{URL::asset('assets/img/mcinet/logo.png')}}" class="logo-icon" alt="logo"></a>
        <a class="logo-icon mobile-logo icon-dark active" href=""><img src="{{URL::asset('assets/img/mcinet/logo.png')}}" class="logo-icon dark-theme" alt="logo"></a>
    </div>
    <div class="main-sidemenu">
        {{-- <div class="app-sidebar__user clearfix">
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
        </div> --}}
        
        <ul class="side-menu"> 
            <!-- Dashboard -->
            <li class="slide">
                <a class="sub-side-menu__item" href="{{route('dashboard.index')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"
                        width="24" height="24" viewBox="0 0 24 24" fill="#ffffff" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                <span class="sub-side-menu__label">
                    @lang('sidebar.dashboard')
                </span>
            </a>
            </li>
            <!-- Models or Parameters -->
        @can('administrate')
            <li class="side-item side-item-category">@lang('sidebar.administration')</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <svg xmlns="http://www.w3.org/2000/svg" class="side-menu__icon"
                        width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#000000" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs">
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
                    <!-- Parametres -->
                <ul class="slide-menu">
                    <!------------------------------------------------------------------------------------------------->
                    <!-- Parametres 1 -->
                    <li class="sub-slide">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="">
                            
        
                            <span class="sub-side-menu__label">
                                Cat 1
                            </span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <!-- Axes -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('axes.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">
                                        @lang('sidebar.axes')
                                    </span>
                                </a>
                            </li>
                            <!-- Indicateurs -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('indicateurs.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">@lang('sidebar.indicateurs')</span>
                                </a>
                            </li>
                            <!-- Regions-->
                            <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('regions.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">@lang('sidebar.regions')
                                    </span>
                                </a>
                            </li>
                            <!-- Ressources -->
                            <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('ressources.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">@lang('sidebar.ressources')
                                    </span>
                                </a>
                            </li>
                            <!-- Secteurs -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('secteurs.index')}}"> 
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i> 
                                    <span class="side-menu__label">
                                        @lang('sidebar.secteurs')
                                    </span>
                                </a>
                            </li>
                            <!-- Structures -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('structures.index')}}"> 
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i> 
                                    <span class="side-menu__label">
                                        @lang('sidebar.structures')
                                    </span>
                                </a>
                            </li>
                            <!-- Unites -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('unites.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">
                                        @lang('sidebar.unites')
                                    </span>
                                </a>
                            </li>
                            <!--Type Credit-->
                            {{-- <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('typecredits.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"> </i>
                                    <span class="side-menu__label"> @lang('sidebar.typeCredits') </span>
                                </a>
                            </li> --}}
                            <!-- Qualites -->
                            <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('qualites.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">
                                        @lang('sidebar.qualites')
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <!------------------------------------------------------------------------------------------------->
                    <!-- Parametres 2 -->
                    <li class="sub-slide">
                        <a class="sub-side-menu__item" data-toggle="sub-slide" href="">
                            <span class="sub-side-menu__label">
                                Cat 2
                            </span>
                            <i class="angle fe fe-chevron-down"></i>
                        </a>
                        <ul class="sub-slide-menu">
                            <!-- Attribution -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('attributions.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">
                                        @lang('sidebar.attributions')
                                    </span>
                                </a>
                            </li>
                            <!-- Objectif -->
                            <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('objectifs.index')}}">
                                    <i class ="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label"> @lang('sidebar.objectifs') </span>
                                </a>
                            </li>
                            <!-- Depenses -->
                            <li class="sub-slide">
                                <a class="side-menu__item"  href="{{route('depenses.index')}}">
                                    <i class ="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label"> @lang('sidebar.depenses') </span>
                                </a>
                            </li>
                            <!-- Dpcis -->
                            <li class="sub-slide">
                                <a class="side-menu__item" href="{{route('dpcis.index')}}">
                                    <i class="fas fa-ellipsis-h custom_style_icon"></i>
                                    <span class="side-menu__label">
                                        @lang('sidebar.dpcis')
                                    </span>
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </li>
            <!-- SIDEBAR.USER -->
            <li class="side-item side-item-category">@lang('sidebar.users')</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <i class="fas fa-users custom_style_icon"></i>
                        <span class="side-menu__label">
                            @lang('sidebar.users')
                        </span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('users.index')}}">
                            <i class="fas fa-address-book custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.liste user')
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('rights')}}">
                            <i class="fas fa-key custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.user_roles')
                            </span>
                        </a>
                    </li>
                    {{-- <li><a class="slide-item" href="{{route('roles.index')}}">Rôles des utilisateurs</a></li> --}}
                </ul>
            </li>

        @endcan
            <!------------------------------------------------------------------------------------------------->
            <!-- Public -->
            <li class="side-item side-item-category">@lang('sidebar.public')</li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="1" stroke-linecap="square" stroke-linejoin="arcs"><rect x="3" y="3" width="7" height="7"></rect><rect x="14" y="3" width="7" height="7"></rect><rect x="14" y="14" width="7" height="7"></rect><rect x="3" y="14" width="7" height="7"></rect></svg>
                    <span class="side-menu__label">
                        @lang('sidebar.axes')
                    </span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <!-- Axes -->
                <ul class="slide-menu">
                    <!-- Attributions de processus -->
                    @canany(['administrate','sd', 'dc'])
                    <li class="slide">
                        <a class="side-menu__item" title="@lang('sidebar.att_procs')" 
                                href="{{route('attprocs.index')}}">
                            <i class="fas fa-boxes custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.att_procs')
                            </span>
                        </a>
                    </li>
                    @endcanany
                    <!-- Ressources Humaines -->
                    @canany(['administrate','ac','sd', 'dc'])
                    <li class="slide">
                        <a class="side-menu__item" title="@lang('sidebar.rhsds')"
                                href="{{route('rhs.index')}}">
                            <i class="fas fa-boxes custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.rhsds')
                            </span>
                        </a>
                    </li>
                    <!-- Budget -->
                    <li class="slide">
                        <a class="side-menu__item"
                                    href="{{route('budgets.index')}}">
                            <i class="fas fa-boxes custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.budgets')
                            </span>
                        </a>
                    </li>
                    @endcanany
                    <!-- Indicateurs de Performance -->
                    @canany(['administrate','sd', 'dc'])
                    <li class="slide">
                        <a class="side-menu__item" title="@lang('sidebar.indicperfs')"
                                href="">
                            <i class="fas fa-boxes custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.indicperfs')
                            </span>
                        </a>
                    </li>
                     @endcanany
                </ul>
            </li>
            <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs"><path d="M14 2H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h12a2 2 0 0 0 2-2V8l-6-6z"/><path d="M14 3v5h5M16 13H8M16 17H8M10 9H8"/></svg>
                    <span class="side-menu__label">
                        @lang('uploads.documents')
                    </span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                <ul class="slide-menu">
                    <!-- Rapports  -->
                    <li class="slide">
                        <a class="side-menu__item" title="@lang('uploads.title')" 
                                href="{{route('documents.index')}}">
                            <svg class="fas fa-boxes custom_style_icon" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="3" stroke-linecap="square" stroke-linejoin="arcs"><line x1="8" y1="6" x2="21" y2="6"></line><line x1="8" y1="12" x2="21" y2="12"></line><line x1="8" y1="18" x2="21" y2="18"></line><line x1="3" y1="6" x2="3.01" y2="6"></line><line x1="3" y1="12" x2="3.01" y2="12"></line><line x1="3" y1="18" x2="3.01" y2="18"></line></svg>
                            <span class="side-menu__label">
                                @lang('uploads.title')
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" title="@lang('uploads.title')" 
                                href="{{route('documents.create')}}">
                            <svg class="fas fa-boxes custom_style_icon" xmlns="http://www.w3.org/2000/svg" width="35" height="35" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="2.5" stroke-linecap="square" stroke-linejoin="arcs"><path d="M20 11.08V8l-6-6H6a2 2 0 0 0-2 2v16c0 1.1.9 2 2 2h6"/><path d="M14 3v5h5M18 21v-6M15 18h6"/></svg>
                            <span class="side-menu__label">
                                @lang('uploads.add')
                            </span>
                        </a>
                    </li>
                </ul>
            </li>
            
             <!-- Validation -->
            
             <li class="side-item side-item-category">@lang('sidebar.validation')</li>
             <li class="slide">
                <a class="side-menu__item" data-toggle="slide" href="">
                    <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#478ced" stroke-width="2" stroke-linecap="square" stroke-linejoin="arcs">
                        <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline>
                    </svg>
                    <span class="side-menu__label">
                        @lang('sidebar.validation_tables')
                    </span>
                    <i class="angle fe fe-chevron-down"></i>
                </a>
                 <ul class="slide-menu">
                    @can('administrate')
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('archives.index')}}">
                            <i class="fas fa-archive custom_style_icon"></i>
                            <span class="side-menu__label">
                                @lang('sidebar.archives')
                            </span>
                        </a>
                    </li>
                    @endcan
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('validation.att_procs')}}">   
                            <i class="fas fa-users custom_style_icon"></i>
                            @if(session()->get('attproc_count') > 0)
                                <label class="badge badge-warning">
                                    <span class="text-light ">{{session()->get('attproc_count')}}</span>
                                </label>
                            @else
                                <label class="badge badge-success">
                                    <span class="text-light ">0</span>
                                </label>
                            @endif
                            <span class="side-menu__label">
                                @lang('sidebar.att_procs')
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('validation.rhsds')}}">   
                            <i class="fas fa-users custom_style_icon"></i>
                            @if(session()->get('rh_count') > 0)
                                <label class="badge badge-warning">
                                    <span class="text-light ">{{session()->get('rh_count')}}</span>
                                </label>
                            @else
                                <label class="badge badge-success">
                                    <span class="text-light ">0</span>
                                </label>
                            @endif
                            <span class="side-menu__label">
                                @lang('sidebar.rhsds')
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('validation.budgets')}}">   
                            <i class="fas fa-users custom_style_icon"></i>
                            @if(session()->get('bdg_count') > 0)
                                <label class="badge badge-warning">
                                    <span class="text-light ">{{session()->get('bdg_count')}}</span>
                                </label>
                            @else
                                <label class="badge badge-success">
                                    <span class="text-light ">0</span>
                                </label>
                            @endif
                            <span class="side-menu__label">
                                @lang('sidebar.budgets')
                            </span>
                        </a>
                    </li>
                    <li class="slide">
                        <a class="side-menu__item" href="{{route('validation.indic_perfs')}}">   
                            <i class="fas fa-users custom_style_icon"></i>
                            @if(session()->get('indic_count') > 0)
                                <label class="badge badge-warning">
                                    <span class="text-light ">{{session()->get('indic_count')}}</span>
                                </label>
                            @else
                                <label class="badge badge-success">
                                    <span class="text-light ">0</span>
                                </label>
                            @endif
                            <span class="side-menu__label">
                                @lang('sidebar.indicperfs')
                            </span>
                        </a>
                    </li>
                    {{-- <li class="slide">
                        <a class="side-menu__item" href="{{route('show.session')}}">
                            <i class="fas fa-users custom_style_icon"></i>
                            <span class="side-menu__label">
                            SESSION
                        </span>
                        </a>
                        <a class="side-menu__item" href="{{route('show.requete')}}">
                            <i class="fas fa-users custom_style_icon"></i>
                            <span class="side-menu__label">
                            REQUETE
                        </span>
                        </a>
                    </li> --}}
                 </ul>
             </li>
        </ul>
    </div>
</aside>
