<!DOCTYPE html>
<!--[if lt IE 9 ]> <html lang="zxx" dir="ltr" class="no-js ie-old"> <![endif]-->
<!--[if IE 9 ]> <html lang="zxx" dir="ltr" class="no-js ie9"> <![endif]-->
<!--[if IE 10 ]> <html lang="zxx" dir="ltr" class="no-js ie10"> <![endif]-->
<!--[if (gt IE 10)|!(IE)]><!-->
<html lang="zxx" dir="ltr" class="no-js">
<!--<![endif]-->

<head>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- META TAGS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta charset="utf-8">
    <!-- Always force latest IE rendering engine -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Mobile specific meta -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE TITLE                                -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <title>FRIYAY | Coupons, Deals, Discounts and Promo codes Template</title>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- SEO METAS                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <meta name="description" content="brief description here">
    <meta name="keywords" content="insert, keywords, here">
    @if(env('APP_DEBUG'))
        <meta name="robots" content="noindex, nofollow">
    @else
        <meta name="robots" content="index, follow">
    @endif

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PAGE FAVICON                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link rel="apple-touch-icon" href="{{ asset('images/favicon/apple-touch-icon.png') }}">
    <link rel="icon" href="{{ asset('images/favicon/favicon.ico') }}">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- GOOGLE FONTS                              -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,500,600" rel="stylesheet">

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Include CSS Filess                        -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->

    <!-- Font Awesome -->
    <link href="{{ asset('vendors/font-awesome/css/font-awesome.min.css') }}" rel="stylesheet">

    <!-- Linearicons -->
    <link href="{{ asset('vendors/linearicons/css/linearicons.css') }}" rel="stylesheet">

    <!-- Owl Carousel -->
    <link href="{{ asset('vendors/owl-carousel/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendors/owl-carousel/owl.theme.min.css') }}" rel="stylesheet">

    <!-- Flex Slider -->
    <link href="{{ asset('vendors/flexslider/flexslider.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    @stack('styles')

</head>

<body id="body" class="wide-layout preloader-active">

    <!--[if lt IE 9]>
    <p class="browserupgrade alert-error">
        You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.
    </p>
    <![endif]-->

    <noscript>
        <div class="noscript alert-error">
            For full functionality of this site it is necessary to enable JavaScript. Here are the <a href="http://www.enable-javascript.com/" target="_blank">
                instructions how to enable JavaScript in your web browser</a>.
        </div>
    </noscript>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- PRELOADER                                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Preloader -->
    <div id="preloader" class="preloader">
        <div class="loader-cube">
            <div class="loader-cube__item1 loader-cube__item"></div>
            <div class="loader-cube__item2 loader-cube__item"></div>
            <div class="loader-cube__item4 loader-cube__item"></div>
            <div class="loader-cube__item3 loader-cube__item"></div>
        </div>
    </div>
    <!-- End Preloader -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- WRAPPER                                   -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <div id="pageWrapper" class="page-wrapper">
        <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->
        @include('frontend.layout.header')
        <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

        @yield('content')

        @include('frontend.layout.bottom')
        <!-- –––––––––––––––[ FOOTER ]––––––––––––––– -->
        @include('frontend.layout.footer')
        <!-- –––––––––––––––[ END FOOTER ]––––––––––––––– -->

    </div>
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- END WRAPPER                               -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->


    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- BACK TO TOP                               -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <div id="backTop" class="back-top is-hidden-sm-down">
        <i class="fa fa-angle-up" aria-hidden="true"></i>
    </div>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Initialize jQuery library                 -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <script src="{{ asset('js/jquery-1.12.3.min.js') }}"></script>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Latest compiled and minified Bootstrap    -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <script type="text/javascript" src="{{ asset('js/bootstrap.min.js') }}"></script>

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- JavaScript Plugins                        -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- (!) Include all compiled plugins (below), or include individual files as needed -->

    <!-- Modernizer JS -->
    <script src="{{ asset('vendors/modernizr/modernizr-2.6.2.min.js') }}"></script>

    <!-- Owl Carousel -->
    <script type="text/javascript" src="{{ asset('vendors/owl-carousel/owl.carousel.min.js') }}"></script>

    <!-- FlexSlider -->
    <script type="text/javascript" src="{{ asset('vendors/flexslider/jquery.flexslider-min.js') }}"></script>

    <!-- Coutdown -->
    <script type="text/javascript" src="{{ asset('vendors/countdown/jquery.countdown.js') }}"></script>

    {{--<script>
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '{{ env('FACEBOOK_ID') }}',
                cookie     : true,
                xfbml      : true,
                version    : 'v3.0'
            });

            FB.AppEvents.logPageView();

        };

        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "https://connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));
    </script>--}}

    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <!-- Custom Template JavaScript                -->
    <!-- ––––––––––––––––––––––––––––––––––––––––– -->
    <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>

    @stack('scripts')

</body>

</html>