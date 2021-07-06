<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 ">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
        <img src="{{ asset('') }}assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sipmanner</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar ">
        <!-- Sidebar user panel (optional) -->
        {{-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('') }}assets/dist/img/user2-160x160.jpg" class="img-circle elevation-2"
                    alt="User Image">
            </div>
            <div class="info">
                <a href="{{ route('users.show', Auth::user()) }}" class="d-block">{{ Auth::user()->name }}</a>
              <span style="color: #c2c7d0">{{ Auth::user()->role->name }}</span> 
            </div>
        </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->




                <li class="nav-item">
                    <a href="{{ route('dashboard') }}"
                        class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>


                @can('viewAny', App\User::class)
                    <li class="nav-item ">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ Request::is('users*') ? 'active' : '' }}">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>
                @endcan

                @can('viewAny', App\Can::class)
                    <li class="nav-item">
                        <a href="{{ route('cans.index') }}" class="nav-link {{ Request::is('cans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Data
                                {{-- <span class="badge badge-info right">2</span> --}}
                            </p>
                        </a>
                    </li>
                @endcan

                <li class="nav-header">Program</li>



                <li class="nav-item">
                    <a href="{{ route('programs.index') }}"
                        class="nav-link {{ Request::is('programs*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p>
                            Rencana
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('progress.index') }}"
                        class="nav-link {{ Request::is('progress*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Progres
                        </p>
                    </a>
                </li>

                @can('viewAny', App\Report::class)
                    <li class="nav-item">
                        <a href="{{ route('reports.index') }}"
                            class="nav-link {{ Request::is('reports*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book"></i>
                            <p>
                                Laporan
                            </p>
                        </a>
                    </li>
                @endcan
                <li class="nav-item">
                    <a href="{{ route('articles.index') }}"
                        class="nav-link {{ Request::is('articles*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            Sharing
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('faq') }}" class="nav-link {{ Request::is('faq*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-search"></i>
                        <p>
                            FAQ
                        </p>
                    </a>
                </li>




            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
