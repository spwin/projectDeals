@extends('frontend.layout.base')

@section('content')
<main id="mainContent" class="main-content">
    <div class="page-container ptb-10">
        <div class="container">
            <div class="section deals-header-area ptb-30">
                <div class="row row-tb-20">
                    <div class="col-xs-12 col-md-4 col-lg-3">
                        <aside>
                            <ul class="nav-coupon-category panel">
                                @foreach($categories as $category)
                                    <li>
                                        <a href="#">
                                            <i class="fa {{ $category->getAttribute('icon') }}"></i>
                                            {{ $category->getAttribute('name') }}
                                            <span>{{ $category->getAttribute('listings_count') }}</span>
                                        </a>
                                    </li>
                                @endforeach
                                <li class="all-cat">
                                    <a class="font-14" href="#">All Categories</a>
                                </li>
                            </ul>
                        </aside>
                    </div>
                    <div class="col-xs-12 col-md-8 col-lg-9">
                        <div class="header-deals-slider flexslider" id="header-deals-slider">
                            <ul class="slides">
                                @foreach($liveListings->where('slider_image', true)->shuffle()->slice(0,10) as $slide)
                                    <li>
                                        <div class="deal-single panel item">
                                            <a href="{{ route('listing', ['id' => $slide->getAttribute('id'), 'slug' => $slide->getRelation('deal')->getAttribute('slug')]) }}">
                                                <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $slide->getSliderImage() ?: 'images/deals/deal_01.jpg' }}">
                                                    <div class="deal-about p-20 pos-a bottom-0 left-0">
                                                        <h3 class="deal-title mb-10 color-light color-h-lighter">
                                                            {{ $slide->getRelation('deal')->getAttribute('name') }}
                                                        </h3>
                                                    </div>
                                                </figure>
                                            </a>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="section explain-process-area ptb-30">
                <div class="row row-rl-10">
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="/images/icons/tablet.png" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">Deals & Coupons</h5>
                                    <p class="color-mid">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure aspernatur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="/images/icons/online-shop-6.png" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">Find Best Offers</h5>
                                    <p class="color-mid">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure aspernatur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="item panel prl-15 ptb-20">
                            <div class="row row-rl-5 row-xs-cell">
                                <div class="col-xs-4 valign-middle">
                                    <img class="pr-10" src="/images/icons/money.png" alt="">
                                </div>
                                <div class="col-xs-8">
                                    <h5 class="mb-10 pt-5">Save Money</h5>
                                    <p class="color-mid">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Iure aspernatur.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <section class="section latest-deals-area ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">Latest Deals</h3>
                    <a class="btn btn-o btn-xs pos-a right-10 pos-tb-center">View All</a>
                </header>

                <div class="row row-masnory row-tb-20">
                    @foreach($liveListings->sortByDesc('id')->slice(0, 15) as $listing)
                        <div class="col-sm-6 col-lg-4">
                            <div class="deal-single panel">
                                <div class="relative">
                                    <a href="{{ route('listing', ['id' => $listing->getAttribute('id'), 'slug' => $listing->getRelation('deal')->getAttribute('slug')]) }}">
                                        <figure class="deal-thumbnail embed-responsive embed-responsive-16by9" data-bg-img="{{ $listing->getRelation('deal')->getImage('360x201') ?: 'images/deals/deal_01.jpg' }}"></figure>
                                    </a>
                                    @if($logo = $listing->getRelation('deal')->company->logo())
                                        <div class="deal-store-logo">
                                            <a href="{{ route('company', ['id' => $listing->getRelation('deal')->company->id, 'slug' => $listing->getRelation('deal')->company->slug]) }}">
                                                <img src="{{ $logo }}" alt="">
                                            </a>
                                        </div>
                                    @endif
                                </div>
                                <div class="bg-white pt-20 pl-20 pr-15">
                                    <div class="pr-md-10">
                                        <h3 class="deal-title mb-10">
                                            <a href="{{ route('listing', ['id' => $listing->getAttribute('id'), 'slug' => $listing->getRelation('deal')->getAttribute('slug')]) }}">{{ $listing->getRelation('deal')->getAttribute('name') }}</a>
                                        </h3>
                                        <ul class="deal-meta list-inline mb-10 color-mid">
                                            <li><i class="ico fa fa-users mr-10"></i>{{ rand(10, 1000) }} Users</li>
                                            <li><i class="ico fa fa-ticket mr-10"></i>{{ $listing->getAttribute('coupons_count') }} Coupons</li>
                                        </ul>
                                        <p class="text-muted mb-20">{{ excerpt($listing->getRelation('deal')->getAttribute('description'), 12) }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="section stores-area stores-area-v1 ptb-30">
                <header class="panel ptb-15 prl-20 pos-r mb-30">
                    <h3 class="section-title font-18">Popular Stores</h3>
                    <a href="stores_01.html" class="btn btn-o btn-xs pos-a right-10 pos-tb-center">All Stores</a>
                </header>
                <div class="popular-stores-slider owl-slider" data-loop="true" data-autoplay="true" data-smart-speed="1000" data-autoplay-timeout="10000" data-margin="20" data-items="2" data-xxs-items="2" data-xs-items="2" data-sm-items="3" data-md-items="5" data-lg-items="6">
                    @foreach($liveListings->unique('deal.company')->pluck('deal.company') as $company)
                        <div class="store-item t-center">
                            <a href="{{ route('company', ['id' => $company->getAttribute('id'), 'slug' => $company->getAttribute('slug')]) }}" class="panel is-block">
                                <div class="embed-responsive embed-responsive-4by3">
                                    <div class="store-logo">
                                        <img src="{{ $company->logo() }}" alt="">
                                    </div>
                                </div>
                                <h6 class="store-name ptb-10">{{ $company->getAttribute('name') }}</h6>
                            </a>
                        </div>
                    @endforeach
                </div>
            </section>

            <section class="section subscribe-area ptb-40 t-center">
                <div class="newsletter-form">
                    <h4 class="mb-20"><i class="fa fa-envelope-o color-green mr-10"></i>Sign up for our weekly email newsletter</h4>
                    <p class="mb-20 color-mid">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quasi animi magni accusantium architecto possimus.</p>
                    <form method="post" action="#">
                        <div class="input-group mb-10">
                            <input type="email" class="form-control bg-white" placeholder="Email Address" required="required">
                            <span class="input-group-btn">
                                    <button class="btn" type="submit">Subscribe</button>
                                </span>
                        </div>
                    </form>
                    <p class="color-muted"><small>We’ll never share your email address with a third-party.</small> </p>
                </div>
            </section>
        </div>
    </div>

</main>
@endsection