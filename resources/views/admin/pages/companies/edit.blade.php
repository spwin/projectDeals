@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Edit Company
    @parent
@stop
{{-- page level styles --}}
@push('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('/assets/vendors/dropify/css/dropify.css')}}">

    <link type="text/css" rel="stylesheet" href="/assets/vendors/inputlimiter/css/jquery.inputlimiter.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/chosen/css/chosen.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/jquery-tagsinput/css/jquery.tagsinput.min.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/multiselect/css/multi-select.css"/>
@endpush
@section('content')
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Edit Company
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <form action="{{ route('admin.companies.save', ['id' => $company->getAttribute('id')]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            Details
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('name')) has-danger @endif">
                                <label for="name">Company Name</label>
                                <input type="text" id="name" class="form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name', $company->getAttribute('name')) }}"/>
                                @if($errors->has('name'))
                                    <small class="help-block">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('phone')) has-danger @endif">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" value="{{ old('phone', $company->getAttribute('phone')) }}"/>
                                @if($errors->has('phone'))
                                    <small class="help-block">{{ $errors->first('phone') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('description')) has-danger @endif">
                                <label for="description">Description</label>
                                <textarea id="description" class="form-control @if($errors->has('description')) is-invalid @endif" name="description">{{ old('description', $company->getAttribute('description')) }}</textarea>
                                @if($errors->has('description'))
                                    <small class="help-block">{{ $errors->first('description') }}</small>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="pull-right">
                                <button type="submit" class="btn btn-mint"><i class="fa fa-save"></i> Save</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header bg-white">
                            Manager
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('user_id')) has-danger @endif">
                                <select class="form-control chzn-select" id="user_id" name="user_id" tabindex="2">
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->getAttribute('id') }}" {{ $manager->getAttribute('id') == $company->getRelation('user')->getAttribute('id') ? 'selected' : '' }}>{{ $manager->getAttribute('email') }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <small class="help-block">{{ $errors->first('user_id') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header bg-white">
                            Logo
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('image')) has-danger @endif">
                                <input type="file" name="image" class="dropify" data-max-file-size="3M" @if($logo = $company->logo()) data-default-file="{{ $logo }}" @endif/>
                                @if($errors->has('image'))
                                    <small class="help-block">{{ $errors->first('image') }}</small>
                                @endif
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

    <script type="text/javascript" src="/assets/vendors/jquery.uniform/js/jquery.uniform.js"></script>
    <script type="text/javascript" src="/assets/vendors/inputlimiter/js/jquery.inputlimiter.js"></script>
    <script type="text/javascript" src="/assets/vendors/chosen/js/chosen.jquery.js"></script>
    <script type="text/javascript" src="/assets/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/jquery-tagsinput/js/jquery.tagsinput.min.js"></script>
    <script type="text/javascript" src="/assets/js/pluginjs/jquery.validVal.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/moment/js/moment.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/daterangepicker/js/daterangepicker.js"></script>
    <script type="text/javascript" src="/assets/vendors/datepicker/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/bootstrap-switch/js/bootstrap-switch.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/autosize/js/jquery.autosize.min.js"></script>
    <script type="text/javascript" src="/assets/vendors/inputmask/js/inputmask.js"></script>
    <script type="text/javascript" src="/assets/vendors/inputmask/js/jquery.inputmask.js"></script>
    <script type="text/javascript" src="/assets/vendors/inputmask/js/inputmask.date.extensions.js"></script>
    <script type="text/javascript" src="/assets/vendors/inputmask/js/inputmask.extensions.js"></script>
    <script type="text/javascript" src="/assets/vendors/multiselect/js/jquery.multi-select.js"></script>

    <script type="text/javascript" src="/assets/js/form.js"></script>
    <script type="text/javascript" src="{{asset('/assets/js/pages/form_elements.js')}}"></script>
    <script>
        $(function(){
            $('.dropify').dropify();
        });
    </script>
@endpush
