<li class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="">
        <i class="fa fa-dashboard"></i><span>Dashboard</span>
    </a>
</li>

<li class="{{ request()->is('users') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}" class="">
        <i class="fa fa-users"></i><span>Users</span>
    </a>
</li>
    <li class="{{ request()->is('plans') ? 'active' : '' }}">
        <a href="{{ route('plans.index') }}" class="">
            <i class="fa fa-users"></i><span>Plans</span>
        </a>
    </li>

@can('roles manage')
    <li class="{{ request()->is('roles') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="">
            <i class="fa-brands fa-critical-role"></i><span>Roles</span>
        </a>
    </li>
@endcan

<!-- <li class="{{ request()->is('setting') ? 'active' : '' }}">
    <a href="{{ route('setting.index') }}" class="">
        <i class="fa fa-cog"></i><span>Settings</span>
    </a>
</li> -->

<li>
    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
        <i class="fa fa-cog"></i>
        <span class="nav-text">Settings</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('setting.index') }}">Email Settings</a></li>

    </ul>
</li>
