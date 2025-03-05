<!-- ========== App Menu ========== -->
<div class="app-menu navbar-menu">
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-dark.png') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ URL::asset('build/images/logo-sm.png') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ URL::asset('build/images/logo-light.png') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><span>@lang('translation.menu')</span></li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('dashboard') }}">
                        <i class="bx bx-home"></i> <span>@lang('translation.dashboard')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarAccounts" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarAccounts">
                        <i class="bx bx-user"></i> <span>@lang('translation.accounts')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarAccounts">
                        <ul class="nav nav-sm flex-column">

                            <li class="nav-item">
                                <a href="{{ route('users.index') }}" class="nav-link">@lang('translation.users')</a>
                            </li>
                            <li class="nav-item">
                                <a href="#sidebarBackendUsers" class="nav-link" data-bs-toggle="collapse" role="button"
                                    aria-expanded="false" aria-controls="sidebarBackendUsers">@lang('translation.backendUsers')
                                </a>
                                <div class="collapse menu-dropdown" id="sidebarBackendUsers">
                                    <ul class="nav nav-sm flex-column">
                                        <li class="nav-item">
                                            <a href="apps-tasks-kanban" class="nav-link">Customer Service Users</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-tasks-kanban" class="nav-link">Developers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-tasks-kanban" class="nav-link">Technical Support
                                                Specialists</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-tasks-list-view" class="nav-link">User Managers</a>
                                        </li>
                                        <li class="nav-item">
                                            <a href="apps-tasks-details" class="nav-link">System Administrators</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="{{ route('job-posts.index') }}">
                        <i class="bx bx-collection"></i> <span>@lang('translation.job-posts')</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#sidebarServices" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarServices">
                        <i class='bx bx-briefcase'></i> <span>@lang('translation.services')</span>
                    </a>
                    <div class="collapse menu-dropdown" id="sidebarServices">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('service-categories.index') }}" class="nav-link">@lang('translation.service-categories')</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('job-services.index') }}" class="nav-link">@lang('translation.job-services')</a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link menu-link" href="#">
                        <i class="bx bx-buildings"></i> <span>@lang('translation.api-consumers')</span>
                    </a>
                </li>
            </ul>
        </div>
        <!-- Sidebar -->
    </div>
    <div class="sidebar-background"></div>
</div>
<!-- Left Sidebar End -->
<!-- Vertical Overlay-->
<div class="vertical-overlay"></div>
