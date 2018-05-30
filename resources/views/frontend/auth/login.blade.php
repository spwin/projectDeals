@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <section class="sign-area panel p-40">
                    <h3 class="sign-title">Sign In <small>Or <a href="{{ route('user.register.form') }}" class="color-green">Sign Up</a></small></h3>
                    @include('frontend.partials.messages')
                    <div class="row row-rl-0">
                        <div class="col-sm-6 col-md-7 col-left">
                            <form class="p-40" action="{{ route('user.login.process') }}" method="post">
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
                                <div class="form-group">
                                    <a href="#" class="forgot-pass-link color-green">Forget Youe Password ?</a>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" name="remember" id="remember_account" checked>
                                    <label class="color-mid" for="remember_account">Keep me signed in on this computer.</label>
                                </div>
                                <button type="submit" class="btn btn-block btn-lg">Sign In</button>
                            </form>
                            <span class="or">Or</span>
                        </div>
                        <div class="col-sm-6 col-md-5 col-right">
                            <div class="social-login p-40">
                                <div class="mb-20">
                                    <a href="{{ route('social.login', ['provider' => 'facebook']) }}" class="btn btn-lg btn-block btn-social btn-facebook"><i class="fa fa-facebook-square"></i>Sign In with Facebook</a>
                                </div>
                                <div class="mb-20">
                                    <a class="btn btn-lg btn-block btn-social btn-twitter"><i class="fa fa-twitter"></i>Sign In with Twitter</a>
                                </div>
                                <div class="mb-20">
                                    <a class="btn btn-lg btn-block btn-social btn-google-plus"><i class="fa fa-google-plus"></i>Sign In with Google</a>
                                </div>
                                <div class="custom-checkbox mb-20">
                                    <input type="checkbox" id="remember_social" checked>
                                    <label class="color-mid" for="remember_social">Keep me signed in on this computer.</label>
                                </div>
                                <div class="text-center color-mid">
                                    Need an Account ? <a href="{{ route('user.register.form') }}" class="color-green">Create Account</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>


    </main>
@endsection