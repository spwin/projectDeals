@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Create User
    @parent
@stop
{{-- page level styles --}}
@push('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('/assets/vendors/dropify/css/dropify.css')}}">
@endpush
@section('content')
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Create User ({{ $role }})
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <form action="{{ route('admin.users.add', ['role' => $role]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            Details
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('first_name')) has-danger @endif">
                                <label for="first_name">First Name</label>
                                <input type="text" id="first_name" class="form-control @if($errors->has('first_name')) is-invalid @endif" name="first_name" value="{{ old('first_name') }}"/>
                                @if($errors->has('first_name'))
                                    <small class="help-block">{{ $errors->first('first_name') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('last_name')) has-danger @endif">
                                <label for="last_name">Last Name</label>
                                <input type="text" id="last_name" class="form-control @if($errors->has('last_name')) is-invalid @endif" name="last_name" value="{{ old('last_name') }}"/>
                                @if($errors->has('last_name'))
                                    <small class="help-block">{{ $errors->first('last_name') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('email')) has-danger @endif">
                                <label for="email">Email</label>
                                <input type="text" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}"/>
                                @if($errors->has('email'))
                                    <small class="help-block">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-mint"><i class="fa fa-save"></i> Create</button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            Image
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('image')) has-danger @endif">
                                <input type="file" name="image" class="dropify" data-min-height="100" data-min-width="400" data-max-file-size="3M"/>
                                @if($errors->has('image'))
                                    <small class="help-block">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header bg-white">
                            Password
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('password')) has-danger @endif">
                                <label for="password">Password</label>
                                <input type="password" id="password" class="form-control @if($errors->has('password')) is-invalid @endif" name="password" value=""/>
                                @if($errors->has('password'))
                                    <small class="help-block">{{ $errors->first('password') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('password_confirmation')) has-danger @endif">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" value=""/>
                                @if($errors->has('password_confirmation'))
                                    <small class="help-block">{{ $errors->first('password_confirmation') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-mint"><i class="fa fa-save"></i> Create</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('/assets/vendors/dropify/js/dropify.js')}}"></script>
    <script>
        $(function(){
            $('.dropify').dropify();
        });
    </script>
@endpush
