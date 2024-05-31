<aside class="main-sidebar sidebar-dark-secondary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{ asset('assets/images/logo.jpg') }}" alt="Zek Logo" class="brand-image img-circle elevation-3"
            style="opacity: .8">
        <span class="brand-text font-weight-light">Zek Catering</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('AdminLTE/dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{ $user->first_name . ' ' . $user->last_name }}</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" data-page="dashboard"
                        class="link nav-link {{ $title == 'Dashboard' ? 'active' : '' }}">
                        <i class="nav-icon fa-solid fa-house"></i>
                        <p>
                            DASHBOARD
                            {{-- <span class="badge badge-info right">2</span> --}}
                        </p>
                    </a>
                </li>
                <li class="nav-header">CATERING</li>
                <li class="nav-item">
                    <a href="{{ route('categories.index') }}" data-page="categories"
                        class="link nav-link {{ $title == 'Categories' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            CATEGORIES
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('packages.index') }}" data-page="packages"
                        class="link nav-link {{ $title == 'Packages' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            PACKAGES
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dishes.index') }}" data-page="dishes"
                        class="link nav-link {{ $title == 'Dishes' ? 'active' : '' }}">
                        <i class="nav-icon fas fa-box"></i>
                        <p>
                            DISHES
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>