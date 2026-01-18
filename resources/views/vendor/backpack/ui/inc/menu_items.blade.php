{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item">
    <a class="nav-link" href="{{ backpack_url('dashboard') }}">
        <i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}
    </a>
</li>
<x-backpack::menu-dropdown title="System" icon="la la-cog">
    <x-backpack::menu-dropdown-item title="Countries" icon="la la-globe" :link="backpack_url('countries')"/>
    <x-backpack::menu-dropdown-item title="Cities" icon="la la-globe" :link="backpack_url('cities')"/>
    <x-backpack::menu-dropdown-item title="Airports" icon="la la-plane" :link="backpack_url('airport')"/>
    <x-backpack::menu-item title="Room types" icon="la la-home" :link="backpack_url('room-type')"/>
    <x-backpack::menu-item title="Room services" icon="la la-home" :link="backpack_url('room-service')"/>
    <x-backpack::menu-dropdown-item title="Hotels" icon="la la-home" :link="backpack_url('hotel')"/>
    <x-backpack::menu-dropdown-item title="Tours" icon="la la-home" :link="backpack_url('tour')"/>
</x-backpack::menu-dropdown>

