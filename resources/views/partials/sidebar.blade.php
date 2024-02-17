<li class="{{ request()->is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="">
        <i class="fa fa-dashboard"></i><span class="nav-text ">Dashboard</span>
    </a>
</li>

<li class="{{ request()->is('users') ? 'active' : '' }}">
    <a href="{{ route('users.index') }}" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Users</span>
    </a>
</li>
@can('manage roles')
    <li class="{{ request()->is('roles') ? 'active' : '' }}">
        <a href="{{ route('roles.index') }}" class="">
            <i class="fa fa-sitemap"></i><span class="nav-text ">Roles</span>
        </a>
    </li>
@endcan
@can('manage contacts')
<li class="{{ request()->is('contacts') ? 'active' : '' }}">
    <a href="{{ route('contacts.index') }}" class="">
        <i class="fa fa-address-card"></i><span class="nav-text">Contacts</span>
    </a>
</li>
@endcan
<li class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : '' }}" >
    <a class="has-arrow " href="javascript:void(0);" aria-expanded="false">
        <i class="fa fa-store"></i>
        <span class="nav-text">Sales</span>
    </a>
    <ul aria-expanded="false">
        @can('manage deal')
            <li><a href="{{ route('deals.index') }}">Deal</a></li>
        @endcan
        @can('manage leads')
            <li><a href="{{ route('leads.index') }}">Lead</a></li>
        @endcan
        {{-- @can('manage leads') --}}
            <li class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'pipelines.index') ? ' active mm-active' : '' }}">
                <a href="{{ route('labels.index') }}" class="{{ (Request::route()->getName() == 'deal-stages.index' || Request::route()->getName() == 'labels.index' || Request::route()->getName() == 'pipelines.index') ? 'mm-active' : '' }}">Deal/Lead Setting</a>
            </li>
        {{-- @endcan --}}
    </ul>
</li>
{{-- @can('manage deal') --}}
{{-- <li class="{{ request()->is('deals') ? 'active' : '' }}">
    <a href="{{ route('deals.index') }}" class="">
        <i class="fa fa-users"></i><span class="nav-text ">Deal</span>
    </a>
</li> --}}
{{-- @endcan --}}

{{-- @if(Auth::user()->type == 'super admin')
    @can('manage coupon')
        <li class="{{ request()->is('coupons') ? 'active' : '' }}">
            <a href="{{ route('coupons.index') }}" class="">
                <i class="fa fa-users"></i><span class="nav-text ">Coupon</span>
            </a>
        </li>
    @endcan
@endif --}}

<li class="{{ request()->is('plans') ? 'active' : '' }}">
    <a href="{{ route('plans.index') }}" class="">
        <i class="fa fa-check-square-o"></i><span class="nav-text">Plans</span>
    </a>
</li>


{{-- @can('manage leads')
<li class="{{ request()->is('leads') ? 'active' : '' }}">
    <a href="{{ route('leads.index') }}" class="">
        <i class="fa-brands fa-critical-role"></i><span>Leads</span>
    </a>
</li>
@endcan --}}





{{-- <li>
    <a class="has-arrow " href="javascript:void(0);"  wire:aria-expanded="false">
        <i class="fa fa-cog"></i>
        <span class="nav-text">Settings</span>
    </a>
    <ul aria-expanded="false">
        <li><a href="{{ route('setting.index') }}">Email Settings</a></li>

    </ul>
</li> --}}
