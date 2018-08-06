<header id="mainHeader" class="main-header">

    <!-- Top Bar -->
    <div class="top-bar bg-gray">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-md-4 is-hidden-sm-down">
                    <ul class="nav-top nav-top-left list-inline t-left">
                        <li><a href="{{ route('static', ['view' => 'faq']) }}"><i class="fa fa-question-circle"></i>FAQ</a>
                        </li>
                        <li><a href="{{ route('static', ['view' => 'customer-assistance']) }}"><i class="fa fa-support"></i>Customer Assistance</a>
                        </li>
                    </ul>
                </div>
                <div class="col-sm-12 col-md-8">
                    <ul class="nav-top nav-top-right list-inline t-xs-center t-md-right">
                        @auth('user')
                            <li>
                                <a href="{{ route('user') }}">
                                    <i class="fa fa-user"></i>
                                    <strong>{{ Auth::guard('user')->user()->getAttribute('first_name') }}</strong>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.logout') }}"><i class="fa fa-sign-out"></i>Log Out</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('user.login.form') }}"><i class="fa fa-lock"></i>Sign In</a>
                            </li>
                            <li>
                                <a href="{{ route('user.register.form') }}"><i class="fa fa-user"></i>Sign Up</a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Bar -->

    <!-- Header Header -->
    <div class="header-header bg-white">
        <div class="container">
            <div class="row row-rl-0 row-tb-20 row-md-cell">
                <div class="brand col-md-3 t-xs-center t-md-left valign-middle">
                    <a href="{{ route('homepage') }}" class="logo">
                        <img src="{{ asset('/images/logo.svg') }}" alt="" width="100">
                    </a>
                </div>
                <div class="header-search col-md-9">
                    <div class="row row-tb-10 ">
                        <div class="col-sm-9">
                            <form class="search-form">
                                <div class="input-group">
                                    <input type="text" class="form-control input-lg search-input" placeholder="Enter Keywork Here ..." required="required">
                                    <div class="input-group-btn">
                                        <div class="input-group">
                                            <div class="input-group-btn">
                                                <button type="submit" class="btn btn-lg btn-search btn-block">
                                                    <i class="fa fa-search font-16"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-sm-3 t-xs-center t-md-right">
                            <div class="header-wishlist ml-20">
                                <a href="wishlist.html">
                                    <span class="icon lnr lnr-heart font-30"></span>
                                    <span class="title">Wish List</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Header Header -->

    <!-- Header Menu -->
    <div class="header-menu bg-blue">
        <div class="container">
            <nav class="nav-bar">
                <div class="nav-header">
                            <span class="nav-toggle" data-toggle="#header-navbar">
		                        <i></i>
		                        <i></i>
		                        <i></i>
		                    </span>
                </div>
                <div id="header-navbar" class="nav-collapse">
                    <ul class="nav-menu">
                        <li class="active">
                            <a href="index-2.html">Home</a>
                        </li>
                        <li class="dropdown-mega-menu">
                            <a href="deals_grid.html">Deals</a>
                            <div class="mega-menu">
                                <div class="row row-v-10">
                                    <div class="col-md-3">
                                        <ul>
                                            <li><a href="deals_grid.html">All Deals</a>
                                            </li>
                                            <li><a href="deal_single.html">Best Deals</a>
                                            </li>
                                            <li><a href="deals_grid_sidebar.html">Most popular</a>
                                            </li>
                                            <li><a href="deals_list.html">Latest Deals</a>
                                            </li>
                                            <li><a href="deal_single.html">Deals near me</a>
                                            </li>
                                        </ul>
                                    </div>
                                    @foreach($liveListings->where('menu_image', true)->shuffle()->slice(0,3) as $listing)
                                        <div class="col-md-3">
                                            <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="{{ $listing->getMenuImage() ?: 'images/deals/deal_03.jpg' }}">
                                                <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                    <h6 class="deal-title mb-10">
                                                        <a href="deal_single.html" class="color-lighter">{{ $listing->getRelation('deal')->getAttribute('name') }}</a>
                                                    </h6>
                                                </div>
                                            </figure>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </li>
                        <li>
                            <a href="stores_01.html">Stores</a>
                        </li>
                        <li>
                            <a href="contact_us_01.html">Contact Us</a>
                        </li>
                    </ul>
                </div>
                <div class="nav-menu nav-menu-fixed">
                    <a href="#" class="friyay-countdown bg-blue">
                        <div class="color-light font-14 font-lg-16">
                            <i class="ico fa fa-clock-o mr-10"></i>
                            <span class="countdown" data-countdown="{{ date('Y/m/d H:i:s', friyayTime()) }}"></span>
                        </div>
                    </a>
                </div>
            </nav>
        </div>
    </div>
    <!-- End Header Menu -->

</header>