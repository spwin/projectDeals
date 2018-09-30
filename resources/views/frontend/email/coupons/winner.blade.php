@extends('frontend.email.coupons.layout')

@section('content')
    <h1>Code: {{ $coupon }}</h1>

    <h2>Listing details</h2>
    <pre>
        {{ print_r($listing->deal->attributesToArray()) }}
    </pre>
    <h2>User details</h2>
    <pre>
        {{ print_r($user->attributesToArray()) }}
    </pre>

    <p>Terms and conditions</p>
@endsection
