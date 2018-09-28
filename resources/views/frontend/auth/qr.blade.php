@extends('frontend.layout.base')

@section('content')
    <main id="mainContent" class="main-content">
        <div class="page-container ptb-60">
            <div class="container">
                <div class="col-md-6 col-md-offset-3">
                    <section class="sign-area panel p-40">
                        <form method="post" action="{{ route('user.login.2fa.process') }}">
                            {{ csrf_field() }}
                            <h3 class="sign-title">Two factor Auth</h3>
                            @include('frontend.partials.messages')
                            <div class="row row-rl-0">
                                <p>Set up your two factor authentication by scanning the barcode below. Alternatively, you can use the code {{ $secret }}</p>
                                <div>
                                    <label for="secret">Code:</label>
                                    <input type="text" name="secret" id="secret"/>
                                </div>
                                <div class="col-md-12 text-center">
                                    <img src="{{ $QR_Image }}">
                                </div>
                                <p>You must set up your Google Authenticator app before continuing. You will be unable to login otherwise</p>
                                <div>
                                    <button class="btn-primary" type="submit">Submit code</button>
                                </div>
                            </div>
                        </form>
                    </section>
                </div>
            </div>
        </div>


    </main>
@endsection
