<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
      <div class="sidebar-brand-icon">
          <i class="fas fa-school"></i>
      </div>
      <div class="sidebar-brand-text mx-3">{{ config('app.name') }} <sup>0.3</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard')?'active':'' }}">
      <a class="nav-link" href="{{ route('admin.dashboard') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>{{ __('admin.dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
      {{ __('admin.management') }}
    </div>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->routeIs(['admin.users.*','admin.groups.*','admin.permissions.*'])?'active':'' }}">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
        <i class="fas fa-fw fa-users"></i>
        <span>{{ __('admin.user_management') }}</span>
      </a>
      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">{{ __('admin.user_management') }}:</h6>
          
          @can('viewAny', App\User::class)
          <a class="collapse-item {{ request()->routeIs('admin.users.index')?'active':'' }}" href="{{ route('admin.users.index') }}">{{ __('admin.list') }}</a>
          @endcan

          @can('create',App\User::class)
          <a class="collapse-item {{ request()->routeIs('admin.users.create')?'active':'' }}" href="{{ route('admin.users.create') }}">{{ __('admin.user_create') }}</a>
          @endcan

          <div class="collapse-divider"></div>
          <h6 class="collapse-header">{{ __('admin.user_group') }}:</h6>
          
          @can('viewAny', App\Group::class)
          <a class="collapse-item {{ request()->routeIs('admin.groups.index')?'active':'' }}" href="{{ route('admin.groups.index') }}">{{ __('admin.user_group') }}</a>
          @endcan
          
          <a class="collapse-item {{ request()->routeIs('admin.groups.create')?'active':'' }}" href="{{ route('admin.groups.create') }}">{{ __('admin.group_create') }}</a>
          <div class="collapse-divider"></div>
          <h6 class="collapse-header">{{ __('admin.group_permission') }}:</h6>
          <a class="collapse-item {{ request()->routeIs('admin.permissions.index')?'active':'' }}" href="{{ route('admin.permissions.index') }}">{{ __('admin.group_permission') }}</a>
          <a class="collapse-item {{ request()->routeIs('admin.permissions.create')?'active':'' }}" href="{{ route('admin.permissions.create') }}">{{ __('admin.permission_create') }}</a>
          <div class="collapse-divider"></div>
          <h6 class="collapse-header">{{ __('admin.other_task') }}:</h6>
          <a class="collapse-item" href="#">{{ __('admin.send_notification') }}</a>
        </div>
      </div>
    </li>

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
      <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
        <i class="fas fa-fw fa-blog"></i>
        <span>{{ __('admin.blog') }}</span>
      </a>
      <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
        <div class="bg-white py-2 collapse-inner rounded">
          <h6 class="collapse-header">{{ __('admin.post_category') }}:</h6>
          <a class="collapse-item" href="{{ route('admin.categories.index') }}">{{ __('admin.category_list') }}</a>
          <a class="collapse-item" href="{{ route('admin.categories.create') }}">{{ __('admin.category_create') }}</a>

          <h6 class="collapse-header">{{ __('admin.blog') }}:</h6>          
          <a class="collapse-item" href="{{ route('admin.posts.index') }}">{{ __('admin.post_list') }}</a>
          <a class="collapse-item" href="{{ route('admin.posts.create') }}">{{ __('admin.post_create') }}</a>
        </div>
      </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

  </ul>
  <!-- End of Sidebar -->