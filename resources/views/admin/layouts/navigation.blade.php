@php
    $initials = strtoupper(substr(Auth::user()->name, 0, 1));
    $colors = ['#f94144', '#f3722c', '#f8961e', '#f9c74f', '#90be6d', '#43aa8b', '#577590'];
    $colorIndex = (int) substr(md5(Auth::user()->id), 0, 1) % count($colors);
    $randomColor = $colors[$colorIndex];
@endphp

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="index.html" class="logo d-flex align-items-center">
            <img src="{{ asset('admin_assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">Admin Dashboard</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item dropdown pe-3">

                <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
                    @if ((Auth::user()->userInfo->image ?? '') != null)
                        <img src="{{ asset('images/' . (Auth::user()->userInfo->image ?? '')) }}" alt="Profile"
                            class="rounded-circle">
                    @else
                        <div class="rounded-circle d-flex justify-content-center align-items-center"
                            style="width: 40px; height: 40px; font-size: 1.5em; background-color: {{ $randomColor }}; color: #fff;">
                            {{ $initials }}
                        </div>
                    @endif
                    <span class="d-none d-md-block dropdown-toggle ps-2">{{ Auth::user()->name }}</span>
                </a><!-- End Profile Iamge Icon -->

                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">

                    <li class="dropdown-header">
                        @if ((Auth::user()->userInfo->image ?? '') != null)
                            <img src="{{ asset('images/' . (Auth::user()->userInfo->image ?? '')) }}" alt="Profile"
                                class="rounded-circle" width="100" height="100">
                        @else
                            <i class="bi bi-person-circle" style="font-size: 3em; color: {{ $randomColor }};"></i>
                        @endif
                        <h6>{{ Auth::user()->name }}</h6>
                        <span>{{ Auth::user()->email }}</span>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>

                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <i class="bi bi-person"></i>
                            <span>My Profile</span>
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item d-flex align-items-center" href="{{ route('logout') }}"
                            onclick="this.closest('form').submit();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out</span>
                        </a>
                    </li>

                </ul><!-- End Profile Dropdown Items -->
            </li><!-- End Profile Nav -->

        </ul>
    </nav><!-- End Icons Navigation -->

</header><!-- End Header -->

<!-- ======= Sidebar ======= -->
<aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? '' : 'collapsed' }}" href="{{ route('admin.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('admin.hr', 'admin.hr.create', 'admin.hr.edit') ? '' : 'collapsed' }}" href="{{ route('admin.hr') }}">
            <i class="bi bi-people"></i>
                <span>HR Managers</span>
            </a>
        </li><!-- End HR Managers Nav -->
        {{-- <li class="nav-heading">Pages</li> --}}
    </ul>
</aside><!-- End Sidebar-->
