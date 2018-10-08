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
                            @if($avatar = manager()->image)
                                <img alt="User Picture" src="{{ $avatar->displayImage('62x62', 'fit') }}">
                            @endif
                        </div>
                        <p class="user-info menu_hide">{{ manager('first_name') }} {{ manager('last_name') }}</p>
                    </a>
                </div>
            </div>
            <hr/>
        </div>
        <ul id="menu">
            <li {!! (request()->is('manager')? 'class="active"':"") !!}>
                <a href="{{ route('manager') }} ">
                    <i class="fa fa-tachometer"></i>
                    <span class="link-title menu_hide">&nbsp;Dashboard</span>
                </a>
            </li>
        </ul>
        <!-- /#menu -->
    </div>
</div>
