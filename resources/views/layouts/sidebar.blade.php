<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4 ">
    <!-- Brand Logo -->
    <a href="{{ route('about') }}" class="brand-link">
        <img src="{{ asset('') }}assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Sip<b>manner</b> <small>
                {{ Auth::user()->getSetting('tahun') }}</small></span>
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
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->


                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>



                <li class="nav-header">Change Agent Network</li>

                @can('viewAny', App\Can::class)
                    <li class="nav-item">
                        <a href="{{ route('cans.index') }}" class="nav-link {{ Request::is('cans*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-chart-pie"></i>
                            <p>
                                Data
                                @if ($counts['canCount'] != 0)
                                    <span class="badge badge-info right">{{ $counts['canCount'] }}</span>
                                @endif
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
                            @if ($counts['programCount'] != 0)
                                <span class="badge badge-info right">{{ $counts['programCount'] }}</span>
                            @endif

                        </p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('progress.index') }}"
                        class="nav-link {{ Request::is('progress*') ? 'active' : '' }}">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>
                            Progres
                            @if ($counts['progressCount'] != 0)
                                <span class="badge badge-info right">{{ $counts['progressCount'] }}</span>
                            @endif
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
                                @if ($counts['reportCount'] != 0)
                                    <span class="badge badge-info right">{{ $counts['reportCount'] }}</span>
                                @endif
                            </p>
                        </a>
                    </li>
                @endcan

                <!-- jika pengguna adalah admin tampilkan menu dibawah -->
                @if (Auth::user()->isAdminOrTopLeader())
                    <li class="nav-item">
                        <a href="#" class="nav-link {{ Request::is('rekaps*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-ellipsis-h"></i>
                            <p>
                                Rekap
                                <i class="right fas fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{ route('reports.index') }}"
                                    class="nav-link {{ Request::is('rekaps*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Intervensi Nasional</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('rekap.intervensikhusus.index') }}"
                                    class="nav-link {{ Request::is('rekap.intervensikhusus*') ? 'active' : '' }}">
                                    <i class="far fa-circle nav-icon"></i>
                                    <p>Rencana Aksi</p>
                                </a>
                            </li>

                        </ul>
                    </li>
                @endif



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


                @can('viewAny', App\User::class)
                    <li class="nav-header">Manajemen User</li>

                    <li class="nav-item ">
                        <a href="{{ route('users.index') }}"
                            class="nav-link {{ (Request::is('users*') and !Request::is('users/recap*')) ? 'active' : '' }}">
                            <i class="nav-icon far fa-plus-square"></i>
                            <p>
                                User
                            </p>
                        </a>
                    </li>

                    <li class="nav-item ">
                        <a href="{{ route('users.recap') }}"
                            class="nav-link {{ Request::is('users/recap*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-table"></i>
                            <p>
                                Rekap User
                            </p>
                        </a>
                    </li>
                @endcan



            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
