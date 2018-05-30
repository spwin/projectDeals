@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <!-- Page Container -->
        <div class="page-container store-page ptb-60">
            <div class="container">
                <section class="store-header-area panel t-xs-center t-sm-left">
                    <div class="row row-rl-10">
                        <div class="col-sm-3 col-md-2 t-center">
                            <figure class="pt-20 pl-10">
                                @if($logo = $company->logo('200x200', 'resize', false))
                                    <img src="{{ $logo }}" alt="">
                                @endif
                            </figure>
                        </div>
                        <div class="col-sm-9 col-md-6">
                            <div class="store-about ptb-30">
                                <h3 class="mb-10">{{ $company->getAttribute('name') }}</h3>
                                @if($rating = round($company->getAttribute('rating')))
                                    <div class="rating mb-10">
                                        <span class="rating-stars" data-rating="{{ $rating }}">
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                            <i class="fa fa-star-o"></i>
                                        </span>
                                        <span class="rating-reviews">
                                            ( <span class="rating-count">{{ rand(10, 300) }}</span> rates )
                                        </span>
                                    </div>
                                @endif
                                <p class="mb-20">{!! $company->getAttribute('description') !!}</p>
                                <ul class="list-inline social-icons social-icons--colored mt-20 mb-40">
                                    @foreach($company->getAttribute('social') as $slug => $social)
                                        @if($social)
                                            <li class="social-icons__item">
                                                <a href="{{ $social }}" target="_blank"><i class="fa fa-{{ $slug }}"></i></a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-sm-12 col-md-4">
                            <div class="store-splitter-left">
                                <div class="left-splitter-header prl-10 ptb-20 bg-lighter">
                                    <div class="row">
                                        <div class="col-xs-12 t-center">
                                            <h2 class="h-title">Company Details</h2>
                                        </div>
                                    </div>
                                </div>
                                <div class="left-splitter-body prl-20 ptb-20">
                                    <div class="row row-rl-10 row-tb-10">
                                        <ul class="company-details">
                                            <li><i class="fa fa-globe"></i> <a target="_blank" href="{{ fullUrl($company->getAttribute('website')) }}">{{ cleanUrl($company->getAttribute('website')) }}</a></li>
                                            <li><i class="fa fa-envelope"></i> <a href="mailto:{{ $company->getAttribute('email') }}">{{ $company->getAttribute('email') }}</a></li>
                                            <li><i class="fa fa-phone"></i> <a href="tel:{{ $company->getAttribute('phone') }}">{{ $company->getAttribute('phone') }}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

            </div>
        </div>
        <!-- End Page Container -->


    </main>
@endsection