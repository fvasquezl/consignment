<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link text-center h3">
{{--        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"--}}
{{--             style="opacity: .8">--}}
        <span class="brand-text font-weight-light">Consigment</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('img/user1.png')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">{{auth()->user()->name}}</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

                <li class="nav-item">
                    <a href="{{route('dashboard.index')}}"  class="{{(request()->is('dashboard') ? 'nav-link active' : 'nav-link')}}" >
                        <i class="fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                @if (auth()->user()->role == 'mi')
                <li class="nav-item has-treeview {{(request()->is('admin/users') ? 'menu-open' :  '')}}">
                    <a href="#" class="nav-link">
                        <i class="fas fa-cogs"></i>
                        <p>
                            Admin Area
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{route('users.index')}}"  class = "{{(request()->is('admin/users') ? 'nav-link active' :  'nav-link')}}">
                                <i class="fas fa-users"></i>
                                <p>Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                @endif
                <li class="nav-item">
                    <a href="{{route('sales.index')}}"  class="{{(request()->is('sales') ? 'nav-link active' : 'nav-link')}}" >
                        <i class="fas fa-shipping-fast"></i>
                        <p>
                            Sales Snapshot
                        </p>
                    </a>
                </li>

                <li class="nav-item">
                   <a href="{{route('details.index')}}"  class="{{(request()->is('details') ? 'nav-link active' : 'nav-link')}}" >
                        <i class="fas fa-project-diagram"></i>
                        <p>
                            Sales Details
                        </p>
                    </a>
                </li>


                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                        <i class="fas fa-power-off"></i>
                        {{ __('Logout') }}
                    </a>

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
