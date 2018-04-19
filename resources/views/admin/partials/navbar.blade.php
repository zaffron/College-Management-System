<!-- Navigation-->
<nav class="navbar navbar-expand-lg {{(auth()->user()->d_mode)? ' navbar-dark bg-dark ':' navbar-light bg-light '}} fixed-top" id="mainNav">
    <a class="navbar-brand" href="{{ route('home') }}">Dashboard</a>
    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="toggle-button-container" style="color:skyblue;">
      Dark Mode: 
      <button type="button" id="theme-changer" class="btn btn-sm btn-toggle {{(auth()->user()->d_mode)? ' active ':''}}" onclick="changeThemeAdmin({{auth()->user()->id}});" data-toggle="button" aria-pressed="false" autocomplete="off">
        <div class="handle"></div>
      </button>
    </div>
    <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav navbar-sidenav">
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Dashboard">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fa fa-fw fa-dashboard"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Department">
                <a class="nav-link" href="{{ route('department.index') }}">
                    <i class="fa fa-fw fa-user-circle-o"></i>
                    <span class="nav-link-text">Department Management</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="User Management">
                <a class="nav-link" href="{{ route('user.index') }}">
                    <i class="fa fa-fw fa-user-circle-o"></i>
                    <span class="nav-link-text">User Management</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Students Management">
                <a class="nav-link" href="{{ route('student.index') }}">
                    <i class="fa fa-fw fa-male"></i>
                    <span class="nav-link-text">Students Managemenet</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Students">
                <a class="nav-link" href="{{ route('admin.graduated') }}">
                    <i class="fa fa-fw fa-graduation-cap"></i>
                    <span class="nav-link-text">Graduated Students</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Subjects Management">
                <a class="nav-link" href="{{ route('subject.index') }}">
                    <i class="fa fa-fw fa-sticky-note-o"></i>
                    <span class="nav-link-text">Subjects</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Course Management">
                <a class="nav-link" href="{{ route('course.index') }}">
                    <i class="fa fa-fw fa-sticky-note-o"></i>
                    <span class="nav-link-text">Courses</span>
                </a>
            </li>
            <li class="nav-item" data-toggle="tooltip" data-placement="right" title="Announcements">
                <a class="nav-link" href="{{ route('admin.announcement') }}">
                    <i class="fa fa-fw fa-microphone"></i>
                    <span class="nav-link-text">Announcement</span>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav sidenav-toggler">
            <li class="nav-item">
                <a class="nav-link text-center" id="sidenavToggler">
                    <i class="fa fa-fw fa-angle-left"></i>
                </a>
            </li>
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle mr-lg-2" id="alertsDropdown" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-fw fa-bell"></i>
                    <span class="indicator text-warning d-none d-lg-block">
                    <span class="badge badge-pill badge-warning">{{ count(auth()->user()->unreadNotifications)}}</span>
                    </span>
                </a>
                <div class="dropdown-menu" id="admin-nav" aria-labelledby="alertsDropdown">
                    @forelse(auth()->user()->unreadNotifications as $notification)
                        @include('layouts.partials.notifications.'.snake_case(class_basename($notification->type)));
                    @empty
                    <div class="container">
                        No notifications                        
                    </div>
                    @endforelse
            </li>
            <li class="nav-item user-name-dispaly">
                <a href="{{ route('admin.profile', Auth::user()->id ) }}" class="nav navbar-text">Welcome! {{ auth()->user()->name }}</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-toggle="modal" href="{{ route('admin.logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa fa-fw fa-sign-out"></i>Logout</a>
            </li>
            <form id="logout-form" action="{{ route('admin.logout') }}" method="POST" style="display:none">{{ csrf_field() }}</form>
        </ul>
    </div>
</nav>

