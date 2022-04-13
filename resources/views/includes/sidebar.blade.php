<aside class="main-sidebar sidebar-dark-primary elevation-4 theme-bg">
    <!-- Brand Logo -->
    <a href="/" class="brand-link">
        <img src="{{url('asset/img/logo.png')}}" alt="logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{settings('app_name')}}</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                @if(Auth::user()->avatar)
                    <img src="{{url(Auth::user()->avatar)}}" class="img-circle elevation-2" alt="User Image">
                @else
                    <img src="{{url('asset/img/default_user.jpg')}}" class="img-circle elevation-2" alt="User Image">
                @endif
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <li class="nav-item">
                    <a href="/" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            @lang('trans.dashboard')
{{--                            <i class="right fas fa-angle-left"></i>--}}
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('employees.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            @lang('trans.employee')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('leaves.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-copy"></i>
                        <p>
                            @lang('trans.leave')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('attendances.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            @lang('trans.attendance')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('conveyance-bills.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-hand-holding-usd"></i>
                        <p>
                            @lang('trans.conveyance_bill')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('departments.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>
                            @lang('trans.department')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('loans.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-landmark"></i>
                        <p>
                            @lang('trans.loan')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('holidays.index')}}" class="nav-link">
                        <i class="nav-icon far fa-calendar-check"></i>
                        <p>
                            @lang('trans.holiday')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('firs.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-users-slash"></i>
                        <p>
                            @lang('trans.FIR')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('tasks.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tasks"></i>
                        <p>
                            @lang('trans.task')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('settings.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-tools"></i>
                        <p>
                            @lang('trans.setting')
                        </p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{route('notices.index')}}" class="nav-link">
                        <i class="nav-icon fas fa-flag"></i>
                        <p>
                            Notices
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->


    </div>
    <!-- /.sidebar -->
</aside>

