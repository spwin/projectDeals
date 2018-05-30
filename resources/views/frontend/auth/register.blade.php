@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <section class="sign-area panel p-40">
                    <h3 class="sign-title">Sign Up <small>Or <a href="{{ route('user.login.form') }}" class="color-green">Sign In</a></small></h3>
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40" action="{{ route('user.register.process') }}" method="post">
                                {{ csrf_field() }}
                                <div class="form-group @if($errors->has('first_name')) has-error @endif">
                                    <label class="sr-only">First Name</label>
                                    <input type="text" class="form-control input-lg" name="first_name" value="{{ old('first_name') }}" placeholder="First Name">
                                    @if($errors->has('first_name'))<span class="text-danger">{{ $errors->first('first_name') }}</span>@endif
                                </div>
                                <div class="form-group @if($errors->has('last_name')) has-error @endif">
                                    <label class="sr-only">Last Name</label>
                                    <input type="text" class="form-control input-lg" name="last_name" value="{{ old('last_name') }}" placeholder="Last Name">
                                    @if($errors->has('last_name'))<span class="text-danger">{{ $errors->first('last_name') }}</span>@endif
                                </div>
                                <div class="form-group @if($errors->has('email')) has-error @endif">
                                    <label class="sr-only">Email</label>
                                    <input type="email" class="form-control input-lg" name="email" value="{{ old('email') }}" placeholder="Email">
                                    @if($errors->has('email'))<span class="text-danger">{{ $errors->first('email') }}</span>@endif
                                </div>
                                <div class="form-group @if($errors->has('password')) has-error @endif">
                                    <label class="sr-only">Password</label>
                                    <input type="password" class="form-control input-lg" name="password" placeholder="Password">
                                    @if($errors->has('password'))<span class="text-danger">{{ $errors->first('password') }}</span>@endif
                                </div>
                                <div class="form-group @if($errors->has('password_confirmation')) has-error @endif">
                                    <label class="sr-only">Confirm Password</label>
                                    <input type="password" class="form-control input-lg" name="password_confirmation" placeholder="Confirm Password">
                                    @if($errors->has('password_confirmation'))<span class="text-danger">{{ $errors->first('password_confirmation') }}</span>@endif
                                </div>
                                <div class="custom-checkbox mb-20 @if($errors->has('terms_of_use')) has-error @endif">
                                    <input type="checkbox" id="agree_terms" name="terms_of_use">
                                    <label class="checkbox color-mid" for="agree_terms">I agree to the <a href="{{ route('static', ['view' => 'terms-and-conditions']) }}" class="color-green">Terms of Use</a> and <a href="{{ route('static', ['view' => 'privacy-policy']) }}" class="color-green">Privacy Statement</a>.</label>
                                    @if($errors->has('terms_of_use'))<span class="text-danger inline-block">{{ $errors->first('terms_of_use') }}</span>@endif
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">Sign Up</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>Sign Up with Facebook</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>Sign Up with Twitter</button>
                                </div>
                                <div class="mb-20">
                                    <button class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>Sign Up with Google</button>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="remember_social" checked>
                                    <label class="color-mid" for="remember_social">Keep me signed in on this computer.</label>
                                </div>
                                <div class="text-center color-mid">
                                    Already have an Account ? <a href="{{ route('user.login.form') }}" class="color-green">Login</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection