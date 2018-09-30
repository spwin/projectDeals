@extends('frontend.layout.base')

@section('wrapper')
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->
    @include('frontend.layout.header')
    <!-- –––––––––––––––[ HEADER ]––––––––––––––– -->

    @yield('content')

    @include('frontend.layout.bottom')
    <!-- –––––––––––––––[ FOOTER ]––––––––––––––– -->
    @include('frontend.layout.footer')
    <!-- –––––––––––––––[ END FOOTER ]––––––––––––––– -->
@endsection
