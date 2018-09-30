<nav class="navbar navbar-static-top">
    <div class="container-fluid m-0">
        <a class="navbar-brand" href="{{ route('admin') }}">
            <h4><img src="{{asset('assets/img/logo1.ico')}}" class="admin_img" alt="logo"> FRIYAY</h4>
        </a>
        <div class="menu mr-sm-auto">
                    <span class="toggle-left" id="menu-toggle">
                        <i class="fa fa-bars"></i>
                    </span>
        </div>
        <div class="topnav dropdown-menu-right">
            <div class="btn-group">
                <div class="user-settings no-bg">
                    <button type="button" class="btn btn-default no-bg micheal_btn" data-toggle="dropdown">
                        <div class="admin_img2 img-thumbnail rounded-circle avatar-img">
                            @if($avatar = admin()->image)
                                <img src="{{ $avatar->displayImage('28x28', 'fit') }}" alt="avatar">
                            @endif
                        </div>
                        <strong>{{ admin('first_name') }}</strong>
                        <span class="fa fa-sort-down white_bg"></span>
                    </button>
                    <div class="dropdown-menu admire_admin">
                        <a class="dropdown-item title" href="#">
                            Friyay Admin</a>
                        <a class="dropdown-item" href="{{ route('admin.users.edit', ['id' => admin('id')]) }}"><i class="fa fa-cogs"></i>
                            Account Settings</a>
                        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="fa fa-sign-out"></i>
                            Log Out</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.container-fluid -->
</nav>
