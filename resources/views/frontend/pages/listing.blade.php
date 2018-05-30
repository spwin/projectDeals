@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container ptb-60">
            <div class="container">
                <div class="row row-rl-10 row-tb-20">
                    <div class="page-content col-xs-12 col-sm-7 col-md-8">
                        <div class="row row-tb-20">
                            <div class="col-xs-12">
                                <div class="deal-deatails panel">
                                    <div class="deal-slider">

                                        <div class="deal-slider">
                                            <div id="product_slider" class="flexslider">
                                                <ul class="slides">
                                                    <li>
                                                        <img alt="" src="{{ $listing->getRelation('deal')->getImage('760x500') }}">
                                                    </li>
                                                    @foreach($listing->getRelation('deal')->gallery as $image)
                                                        <li>
                                                            <img alt="" src="{{ $image->displayImage('760x500', 'resize', false) }}">
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                            @if($listing->getRelation('deal')->gallery->count() > 0)
                                                <div id="product_slider_nav" class="flexslider flexslider-nav">
                                                    <ul class="slides">
                                                        <li>
                                                            <img alt="" src="{{ $listing->getRelation('deal')->getImage('360x250') }}">
                                                        </li>
                                                        @foreach($listing->getRelation('deal')->gallery as $image)
                                                            <li>
                                                                <img alt="" src="{{ $image->displayImage('360x250', 'resize', false) }}">
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endif
                                        </div>

                                    </div>
                                    <div class="deal-body p-20">
                                        <h3 class="mb-10">{{ $listing->getRelation('deal')->getAttribute('name') }}</h3>
                                        @if($rating = round($listing->getRelation('deal')->getAttribute('rating')))
                                            <div class="rating mb-10">
                                                <span class="rating-stars" data-rating="{{ $rating }}">
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                    <i class="fa fa-star-o"></i>
                                                </span>
                                            </div>
                                        @endif
                                        <p class="mb-20">{!! $listing->getRelation('deal')->getAttribute('description') !!}</p>
                                    </div>
                                </div>
                            </div>


                            @if($terms_and_conditions = $listing->getRelation('deal')->getAttribute('terms_and_conditions'))
                                <div class="col-xs-12">
                                    <div class="panel p-20">
                                        <h3 class="h-title">Terms & Conditions</h3>
                                        <div class="terms-and-conditions mt-20 mb-20">
                                            {!! $terms_and_conditions !!}
                                        </div>
                                    </div>
                                </div>
                            @endif


                            <div class="col-xs-12">
                                <div class="posted-review panel p-30">
                                    <h3 class="h-title">Latest Reviews <small><a href="#" class="color-green">show all</a></small></h3>
                                    @foreach($listing->getRelation('deal')->reviews->sortByDesc('pivot.date')->slice(0, 5) as $review)
                                        <div class="review-single pt-30">
                                            <div class="media">
                                                <div class="media-left">
                                                    <img class="media-object mr-10 radius-4" src="{{ $review->avatar('150x150') ?: '/images/avatars/avatar_01.jpg' }}" width="90" alt="">
                                                </div>
                                                <div class="media-body">
                                                    <div class="review-wrapper clearfix">
                                                        <ul class="list-inline">
                                                            <li>
                                                                <span class="review-holder-name h5">{{ $review->getAttribute('first_name') }} {{ $review->getAttribute('last_name') }}</span>
                                                            </li>
                                                            <li>
                                                                <div class="rating">
                                                                    <span class="rating-stars" data-rating="{{ $review->pivot->rating }}">
                                                                        @for($i = 5; $i > 0; $i--)
                                                                            <i class="fa {{ $i }} fa-star-o @if($review->pivot->rating == $i) star-active @endif"></i>
                                                                        @endfor
                                                                    </span>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                        <p class="review-date mb-5">{{ date('F d, Y', strtotime($review->pivot->date)) }}</p>
                                                        <p class="copy">{{ $review->pivot->review }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="post-review panel p-20">
                                    @auth('user')
                                        @if($review = $listing->getRelation('deal')->reviews->where('id', Auth::guard('user')->user()->id)->first())
                                            <h3 class="h-title">Your Review</h3>
                                            <div class="row row-v-10">
                                                <div class="col-xs-12 mb-20">
                                                    <div class="rating mt-20">
                                                        <span class="rating-stars" data-rating="{{ $review->pivot->rating }}">
                                                            @for($i = 5; $i > 0; $i--)
                                                                <i class="fa {{ $i }} fa-star-o @if($review->pivot->rating == $i) star-active @endif"></i>
                                                            @endfor
                                                        </span>
                                                    </div>
                                                    <p class="review-date mb-20">{{ date('F d, Y', strtotime($review->pivot->date)) }}</p>
                                                    <p>{{ $review->pivot->review }}</p>
                                                </div>
                                            </div>
                                        @else
                                            <h3 class="h-title">Leave Review</h3>
                                            <form class="horizontal-form pt-30" action="{{ route('deal.rate', ['id' => $listing->getAttribute('id')]) }}" method="post">
                                                {{ csrf_field() }}
                                                <div class="row row-v-10">
                                                    <div class="col-xs-12">
                                                        <div class="rating mb-20">
                                                            <input name="rating" type="hidden" value="3" />
                                                            <span class="rating-stars rate-allow" data-rating="3">
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o star-active"></i>
                                                                <i class="fa fa-star-o"></i>
                                                                <i class="fa fa-star-o"></i>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-xs-12 @if($errors->has('review')) has-error @endif">
                                                        <textarea class="form-control" name="review" placeholder="Your Review" rows="6"></textarea>
                                                        @if($errors->has('review'))<span class="text-danger">{{ $errors->first('review') }}</span>@endif
                                                    </div>
                                                    <div class="col-xs-12 text-right">
                                                        <button type="submit" class="btn mt-20">Submit review</button>
                                                    </div>
                                                </div>
                                            </form>
                                        @endif
                                    @else
                                        <h3 class="h-title">Leave Review</h3>
                                        <div class="row row-v-10">
                                            <div class="col-xs-12 mt-30 mb-20">
                                                <h3 class="text-center"><b><a href="{{ route('user.login.form') }}">Sign In</a></b> to leave a review</h3>
                                            </div>
                                        </div>
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="page-sidebar col-md-4 col-sm-5 col-xs-12">
                        <!-- Blog Sidebar -->
                        <aside class="sidebar blog-sidebar">
                            <div class="row row-tb-10">
                                <div class="col-xs-12">
                                    <div class="widget single-deal-widget panel ptb-30 prl-20">
                                        <div class="widget-body text-center">
                                            <h2 class="mb-10 h3">
                                                Participation
                                            </h2>
                                            <ul class="deal-meta list-inline mb-20 color-mid">
                                                <li><i class="ico fa fa-users mr-10"></i>{{ rand(10, 1000) }} Users</li>
                                                <li><i class="ico fa fa-ticket mr-10"></i>{{ $listing->getAttribute('coupons_count') }} Coupons</li>
                                            </ul>
                                            @auth('user')
                                                <ul class="list-inline social-icons social-icons--colored t-center mt-20 mb-40">
                                                    <li class="social-icons__item">
                                                        <a href="#"><i class="fa fa-facebook"></i></a>
                                                    </li>
                                                    <li class="social-icons__item">
                                                        <a href="#"><i class="fa fa-twitter"></i></a>
                                                    </li>
                                                    <li class="social-icons__item">
                                                        <a href="#"><i class="fa fa-pinterest"></i></a>
                                                    </li>
                                                    <li class="social-icons__item">
                                                        <a href="#"><i class="fa fa-linkedin"></i></a>
                                                    </li>
                                                    <li class="social-icons__item">
                                                        <a href="#"><i class="fa fa-google-plus"></i></a>
                                                    </li>
                                                </ul>
                                                <p class="color-muted mb-40">
                                                    Please choose a platform to share this deal using one of the button above in order to enter this participation.
                                                </p>
                                                <div class="buy-now">
                                                    <a href="#" target="_blank" class="btn btn-block btn-disabled btn-lg">
                                                        <i class="fa fa-shopping-cart font-16 mr-10"></i> Participate
                                                    </a>
                                                </div>
                                            @else
                                                <h3 class="widget-title h-title">Sign In <small>Or <a href="{{ route('user.register.form') }}" class="color-green">Sign Up</a></small></h3>
                                                <form class="pt-20" action="{{ route('user.login.process') }}" method="post">
                                                    {{ csrf_field() }}
                                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                                        <label class="sr-only">Email</label>
                                                        <input type="text" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Email">
                                                        @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                                                    </div>
                                                    <div class="form-group @if($errors->has('email')) has-error @endif">
                                                        <label class="sr-only">Password</label>
                                                        <input type="password" class="form-control input-lg" name="password" placeholder="Password">
                                                        @if($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
                                                    </div>
                                                    <div class="mb-20">
                                                        <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>Sign In with Facebook</a>
                                                    </div>
                                                    <div class="mb-20">
                                                        <a class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>Sign In with Twitter</a>
                                                    </div>
                                                    <div class="mb-20">
                                                        <a class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>Sign In with Google</a>
                                                    </div>
                                                    <div class="form-group">
                                                        <a href="#" class="forgot-pass-link color-green">Forget Youe Password ?</a>
                                                    </div>
                                                    <div class="custom-checkbox mb-20">
                                                        <input type="checkbox" name="remember" id="remember_account" checked>
                                                        <label class="color-mid" for="remember_account">Keep me signed in on this computer.</label>
                                                    </div>
                                                    <button type="submit" class="btn btn-block btn-lg">Sign In</button>
                                                </form>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                                @if($map = $listing->getRelation('deal')->getRelation('map'))
                                    <div class="col-xs-12">
                                        <!-- Recent Posts -->
                                        <div class="widget about-seller-widget panel ptb-30 prl-20">
                                            <h3 class="widget-title h-title">Location</h3>
                                            <div class="widget-body t-center map-preview">
                                                @if($maps_link = $listing->getRelation('deal')->getAttribute('maps_link'))
                                                    <a target="_blank" href="{{ $maps_link }}">
                                                        <img src="{{ $map->displayImage('370x300', 'resize', false) }}"/>
                                                    </a>
                                                @else
                                                    <img src="{{ $map->displayImage('370x300', 'resize', false) }}"/>
                                                @endif
                                            </div>
                                        </div>
                                        <!-- End Recent Posts -->
                                    </div>
                                @endif
                                <div class="col-xs-12">
                                    <!-- Recent Posts -->
                                    <div class="widget about-seller-widget panel ptb-30 prl-20">
                                        <h3 class="widget-title h-title">About Seller</h3>
                                        <div class="widget-body t-center">
                                            @if($image = $listing->getRelation('deal')->company->logo('200x100'))
                                                <a href="{{ route('company', ['id' => $listing->getRelation('deal')->company->getAttribute('id'), 'slug' => $listing->getRelation('deal')->company->getAttribute('slug')]) }}">
                                                    <figure class="mt-20 pb-10">
                                                        <img src="{{ $image }}" alt="">
                                                    </figure>
                                                </a>
                                            @endif
                                            <div class="store-about mb-20">
                                                <h3 class="mb-10">
                                                    <a href="{{ route('company', ['id' => $listing->getRelation('deal')->company->getAttribute('id'), 'slug' => $listing->getRelation('deal')->company->getAttribute('slug')]) }}">
                                                        {{ $listing->getRelation('deal')->company->getAttribute('name') }}
                                                    </a>
                                                </h3>
                                                <div class="rating mb-10">
                                                    <span class="rating-stars" data-rating="3">
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o star-active"></i>
                                                        <i class="fa fa-star-o"></i>
                                                        <i class="fa fa-star-o"></i>
                                                    </span>
                                                    <span class="rating-reviews">
                                                      ( <span class="rating-count">205</span> rates )
                                                    </span>
                                                </div>
                                                <p class="mb-15">{{ $listing->getRelation('deal')->company->getAttribute('description') }}</p>
                                                <a href="{{ $listing->getRelation('deal')->getAttribute('link') }}" class="btn btn-info">WEBSITE</a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Recent Posts -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Latest Deals Widegt -->
                                    <div class="widget latest-deals-widget panel prl-20">
                                        <div class="widget-body ptb-20">
                                            <div class="owl-slider" data-loop="true" data-autoplay="true" data-autoplay-timeout="10000" data-smart-speed="1000" data-nav-speed="false" data-nav="true" data-xxs-items="1" data-xxs-nav="true" data-xs-items="1" data-xs-nav="true" data-sm-items="1" data-sm-nav="true" data-md-items="1" data-md-nav="true" data-lg-items="1" data-lg-nav="true">

                                                @foreach($liveListings->where('deal.category.id', $listing->getRelation('deal')->getAttribute('category_id'))->shuffle()->slice(0,6) as $similar)
                                                <div class="latest-deals__item item">
                                                    <figure class="deal-thumbnail embed-responsive embed-responsive-4by3" data-bg-img="{{ $similar->getAttribute('deal')->getImage('327x245') }}">
                                                        <div class="deal-about p-10 pos-a bottom-0 left-0">
                                                            @if($rating = round($similar->getRelation('deal')->getAttribute('rating')))
                                                                <div class="rating mb-10">
                                                                    <span class="rating-stars" data-rating="{{ $rating }}">
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    </span>
                                                                    <span class="rating-reviews color-lighter">
                                                                        (<span class="rating-count">{{ $similar->getRelation('deal')->reviews->count() }}</span> Reviews)
                                                                    </span>
                                                                </div>
                                                            @endif
                                                            <h5 class="deal-title mb-10">
                                                                <a href="{{ route('listing', ['id' => $similar->getAttribute('id'), 'slug' => $similar->getRelation('deal')->getAttribute('slug')]) }}" class="color-lighter">
                                                                    {{ $similar->getRelation('deal')->getAttribute('name') }}
                                                                </a>
                                                            </h5>
                                                        </div>
                                                    </figure>
                                                </div>
                                                @endforeach

                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Latest Deals Widegt -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Subscribe Widget -->
                                    <div class="widget subscribe-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Subscribe to mail</h3>
                                        <div class="widget-content ptb-30">

                                            <p class="color-mid mb-20">Get our Daily email newsletter with Special Services, Updates, Offers and more!</p>
                                            <form method="post" action="#">
                                                <div class="input-group">
                                                    <input type="email" class="form-control" placeholder="Your Email Address" required="required">
                                                    <span class="input-group-btn">
                                        		        	<button class="btn" type="submit">Sign Up</button>
                                        		    	</span>
                                                </div>
                                            </form>

                                        </div>
                                    </div>
                                    <!-- End Subscribe Widget -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Best Rated Deals -->
                                    <div class="widget best-rated-deals panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Best Rated Deals</h3>
                                        <div class="widget-body ptb-30">

                                            @foreach($liveListings->where('deal.rating', '!=', null)->sortByDesc('deal.rating')->slice(0, 5) as $best_rated_listing)
                                                <div class="media">
                                                    <div class="media-left">
                                                        <a href="{{ route('listing', ['id' => $best_rated_listing->getAttribute('id'), 'slug' => $best_rated_listing->getRelation('deal')->getAttribute('slug')]) }}">
                                                            <img class="media-object" src="{{ $best_rated_listing->getRelation('deal')->getImage('150x150') }}" alt="Thumb" width="80">
                                                        </a>
                                                    </div>
                                                    <div class="media-body">
                                                        <div class="mb-5">
                                                            @if($rating = round($best_rated_listing->getRelation('deal')->getAttribute('rating')))
                                                                <span class="rating">
                                                                    <span class="rating-stars" data-rating="{{ $rating }}">
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                        <i class="fa fa-star-o"></i>
                                                                    </span>
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <h6 class="mb-5">
                                                            <a href="{{ route('listing', ['id' => $best_rated_listing->getAttribute('id'), 'slug' => $best_rated_listing->getRelation('deal')->getAttribute('slug')]) }}">
                                                                {{ $best_rated_listing->getRelation('deal')->getAttribute('name') }}
                                                            </a>
                                                        </h6>
                                                    </div>
                                                </div>
                                            @endforeach
                                            
                                        </div>
                                    </div>
                                    <!-- Best Rated Deals -->
                                </div>
                                <div class="col-xs-12">
                                    <!-- Contact Us Widget -->
                                    <div class="widget contact-us-widget panel pt-20 prl-20">
                                        <h3 class="widget-title h-title">Got any questions?</h3>
                                        <div class="widget-body ptb-30">
                                            <p class="mb-20 color-mid">If you are having any questions, please feel free to ask.</p>
                                            <a href="contact_us_01.html" class="btn btn-block"><i class="mr-10 font-15 fa fa-envelope-o"></i>Drop Us a Line</a>
                                        </div>
                                    </div>
                                    <!-- End Contact Us Widget -->
                                </div>
                            </div>
                        </aside>
                        <!-- End Blog Sidebar -->
                    </div>
                </div>
            </div>
        </div>
        <!-- End Page Container -->
    </main>
@endsection