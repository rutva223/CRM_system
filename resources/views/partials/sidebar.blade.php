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


<li class="{{ request()->is('roles') ? 'active' : '' }}">
    <a href="{{ route('roles.index') }}" class="">
        <i class="fa-brands fa-critical-role"></i><span>Roles</span>
    </a>
</li>
