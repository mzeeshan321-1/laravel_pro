@php
    $initials = strtoupper(substr(Auth::user()->name, 0, 1));
    $colors = ['#f94144', '#f3722c', '#f8961e', '#f9c74f', '#90be6d', '#43aa8b', '#577590'];
    $colorIndex = (int) substr(md5(Auth::user()->id), 0, 1) % count($colors);
    $randomColor = $colors[$colorIndex];
@endphp

<!-- ======= Header ======= -->
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
        <a href="{{ route('hr_manager.dashboard') }}" class="logo d-flex align-items-center">
            <img src="{{ asset('admin_assets/img/logo.png') }}" alt="">
            <span class="d-none d-lg-block">HR Dashboard</span>
        </a>
        <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <div class="search-bar">
        <form class="search-form d-flex align-items-center" method="POST" action="#">
            <input type="text" name="query" placeholder="Search" title="Enter search keyword">
            <button type="submit" title="Search"><i class="bi bi-search"></i></button>
        </form>
    </div><!-- End Search Bar -->

    <nav class="header-nav ms-auto">
        <ul class="d-flex align-items-center">

            <li class="nav-item d-block d-lg-none">
                <a class="nav-link nav-icon search-bar-toggle " href="#">
                    <i class="bi bi-search"></i>
                </a>
            </li><!-- End Search Icon-->

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
                        <a class="dropdown-item d-flex align-items-center"
                            href="{{ route('hr_manager.profile.edit') }}">
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
            <a class="nav-link {{ request()->routeIs('hr_manager.dashboard') ? '' : 'collapsed' }}"
                href="{{ route('hr_manager.dashboard') }}">
                <i class="bi bi-grid"></i>
                <span>Dashboard</span>
            </a>
        </li><!-- End Dashboard Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.employees', 'hr_manager.employees.create', 'hr_manager.employees.edit', 'hr_manager.employees.e-profile') ? '' : 'collapsed' }}"
                href="{{ route('hr_manager.employees') }}">
                <i class="bi bi-people"></i>
                <span>Employees</span>
            </a>
        </li><!-- End Employee Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.departments', 'hr_manager.departments.create', 'hr_manager.departments.edit') ? '' : 'collapsed' }}"
                href="{{ route('hr_manager.departments') }}">
                <i class="bi bi-buildings"></i>
                <span>Departments</span>
            </a>
        </li><!-- End Department Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.holidays', 'hr_manager.holidays.create', 'hr_manager.holidays.edit') ? '' : 'collapsed' }}"
                href="{{ route('hr_manager.holidays') }}">
                <i class="bi bi-calendar3"></i>
                <span>Holidays</span>
            </a>
        </li><!-- End Holidays Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.payroll', 'hr_manager.payroll.create', 'hr_manager.payroll.edit') ? '' : 'collapsed' }}"
                href="{{ route('hr_manager.payroll') }}">
                <i class="bi bi-cash-stack"></i>
                <span>Payroll</span>
            </a>
        </li><!-- End Payroll Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.leaves', 'hr_manager.leaves.create', 'hr_manager.leaves.edit', 'hr_manager.leaves.leaveRequests') ? '' : 'collapsed' }}"
                data-bs-target="#leave-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-card-text"></i>
                <span>Leaves Management</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="leave-nav"
                class="nav-content collapse {{ request()->routeIs('hr_manager.leaves', 'hr_manager.leaves.create', 'hr_manager.leaves.edit', 'hr_manager.leaves.leaveRequests') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('hr_manager.leaves.leaveRequests') }}"
                        class="{{ request()->routeIs('hr_manager.leaves.leaveRequests') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Leave Requests</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hr_manager.leaves') }}"
                        class="{{ request()->routeIs('hr_manager.leaves') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Leaves (HR)</span>
                    </a>
                </li>
            </ul>
        </li><!-- End Leaves Management Nav -->

        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('hr_manager.jobs', 'hr_manager.jobs.*', 'hr_manager.job_history', 'hr_manager.job_history.*', 'hr_manager.job_grades', 'hr_manager.job_grades.*') ? '' : 'collapsed' }}"
                data-bs-target="#jobs-nav" data-bs-toggle="collapse" href="#">
                <i class="bi bi-briefcase"></i>
                <span>Job Management</span>
                <i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="jobs-nav"
                class="nav-content collapse {{ request()->routeIs('hr_manager.jobs', 'hr_manager.jobs.*', 'hr_manager.job_history', 'hr_manager.job_history.*', 'hr_manager.job_grades', 'hr_manager.job_grades.*') ? 'show' : '' }}"
                data-bs-parent="#sidebar-nav">
                <li>
                    <a href="{{ route('hr_manager.jobs') }}"
                        class="{{ request()->routeIs('hr_manager.jobs', 'hr_manager.jobs.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Jobs</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hr_manager.job_history') }}"
                        class="{{ request()->routeIs('hr_manager.job_history', 'hr_manager.job_history.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Job History</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('hr_manager.job_grades') }}"
                        class="{{ request()->routeIs('hr_manager.job_grades', 'hr_manager.job_grades.*') ? 'active' : '' }}">
                        <i class="bi bi-circle"></i>
                        <span>Job Grades</span>
                    </a>
                </li>
            </ul>
        </li><!-- End jobs Management Nav -->
    </ul>
</aside><!-- End Sidebar-->
