@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <section class="sign-area panel p-40">
                        <h3 class="sign-title">Sign In <small>Or <a href="{{ route('user.register.form') }}" class="color-green">Sign Up</a></small></h3>
                        @include('frontend.partials.messages')
                        <div class="row row-rl-0">
                            <div class="col-md-12">
                                <form class="p-20" action="{{ route('user.login.process') }}" method="post">
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
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>
@endsection