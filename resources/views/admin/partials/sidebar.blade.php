<div id="left">
    <div class="menu_scroll">
        <div class="left_media">
            <div class="media user-media">
                <div class="user-media-toggleHover">
                    <span class="fa fa-user"></span>
                </div>
                <div class="user-wrapper">
                    <a class="user-link" href="#">
                        <div class="media-object img-thumbnail user-img rounded-circle admin_img3">
                            @if($avatar = admin()->image)
                                <img alt="User Picture" src="{{ $avatar->displayImage('62x62', 'fit') }}">
                            @endif
                        </div>
                        <p class="user-info menu_hide">{{ admin('first_name') }} {{ admin('last_name') }}</p>
                    </a>
                </div>
            </div>
            <hr/>
        </div>
        <ul id="menu">
            <li {!! (request()->is('admin.dashboard')? 'class="active"':"") !!}>
                <a href="{{ route('admin.dashboard') }} ">
                    <i class="fa fa-tachometer"></i>
                    <span class="link-title menu_hide">&nbsp;Dashboard</span>
                </a>
            </li>

            <li class="dropdown_menu {!! (request()->is('admin/users*') ? 'active':'' ) !!}">
                <a href="javascript:;">
                    <i class="fa fa-users"></i>
                    <span class="link-title menu_hide">&nbsp; Users</span>
                    <span class="fa arrow menu_hide"></span>
                </a>
                <ul>
                    <li {!! (request()->is('admin/users/user*')? 'class="active"':"") !!}>
                        <a href="{{ route('admin.users.list', ['role' => 'user']) }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Website Users
                        </a>
                    </li>
                    <li {!! (request()->is('admin/users/manager*')? 'class="active"':"") !!}>
                        <a href="{{ route('admin.users.list', ['role' => 'manager']) }} ">
                            <i class="fa fa-angle-right"></i>
                            &nbsp; Managers
                        </a>
                    </li>
                    <li {!! (request()->is('admin/users/admin*')? 'class="active"':"") !!}>
                        <a href="{{route('admin.users.list', ['role' => 'admin'])}} ">
                            <i class="fa fa-angle-right"></i>
                            <span class="link-title">&nbsp; Admins </span>
                        </a>
                    </li>
                </ul>
            </li>

            <li {!! (request()->is('admin/companies*')? 'class="active"':"") !!}>
                <a href="{{ route('admin.companies.list') }} ">
                    <i class="fa fa-building"></i>
                    <span class="link-title menu_hide">&nbsp;Companies</span>
                </a>
            </li>

            <li {!! (request()->is('admin/deals*')? 'class="active"':"") !!}>
                <a href="{{ route('admin.deals.list') }} ">
                    <i class="fa fa-ticket"></i>
                    <span class="link-title menu_hide">&nbsp;Deals</span>
                </a>
            </li>

            <li {!! (request()->is('admin/listings*')? 'class="active"':"") !!}>
                <a href="{{ route('admin.listings.list') }} ">
                    <i class="fa fa-money"></i>
                    <span class="link-title menu_hide">&nbsp;Listings</span>
                </a>
            </li>
        </ul>
        <!-- /#menu -->
    </div>
</div>