@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Create Company
    @parent
@stop
{{-- page level styles --}}
@push('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('/assets/vendors/dropify/css/dropify.css')}}">

    <link type="text/css" rel="stylesheet" media="screen" href="{{ asset('/assets/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/inputlimiter/css/jquery.inputlimiter.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/chosen/css/chosen.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/jquery-tagsinput/css/jquery.tagsinput.min.css"/>
    <link type="text/css" rel="stylesheet" href="/assets/vendors/multiselect/css/multi-select.css"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/css/pages/form_elements.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/vendors/Buttons/css/buttons.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/css/pages/buttons.css') }}"/>
@endpush
@section('content')
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Add New Company
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <form action="{{ route('admin.companies.add') }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="save-button">
                <span class="button-wrap">
                    <button type="submit" class="button button-circle button-success button-wrapper">Save</button>
                </span>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Details
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('name')) has-danger @endif">
                                <label for="name">Company Name</label>
                                <input type="text" id="name" class="slug-source form-control @if($errors->has('name')) is-invalid @endif" name="name" value="{{ old('name') }}"/>
                                @if($errors->has('name'))
                                    <small class="help-block">{{ $errors->first('name') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('slug')) has-danger @endif">
                                <label for="slug">Slug</label>
                                <input type="text" id="slug" class="slug form-control @if($errors->has('slug')) is-invalid @endif" name="slug" value="{{ old('slug') }}"/>
                                @if($errors->has('slug'))
                                    <small class="help-block">{{ $errors->first('slug') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('phone')) has-danger @endif">
                                <label for="phone">Phone</label>
                                <input type="text" id="phone" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" value="{{ old('phone') }}"/>
                                @if($errors->has('phone'))
                                    <small class="help-block">{{ $errors->first('phone') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('email')) has-danger @endif">
                                <label for="email">Email</label>
                                <input type="email" id="email" class="form-control @if($errors->has('email')) is-invalid @endif" name="email" value="{{ old('email') }}"/>
                                @if($errors->has('email'))
                                    <small class="help-block">{{ $errors->first('email') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('website')) has-danger @endif">
                                <label for="phone">Website</label>
                                <input type="text" id="website" class="form-control @if($errors->has('website')) is-invalid @endif" name="website" value="{{ old('website') }}"/>
                                @if($errors->has('website'))
                                    <small class="help-block">{{ $errors->first('website') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Manager
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('user_id')) has-danger @endif">
                                <select class="form-control chzn-select" id="user_id" name="user_id" tabindex="2">
                                    <option disabled selected>Choose a Manager</option>
                                    @foreach($managers as $manager)
                                        <option value="{{ $manager->getAttribute('id') }}">{{ $manager->getAttribute('email') }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('user_id'))
                                    <small class="help-block">{{ $errors->first('user_id') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Logo
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('image')) has-danger @endif">
                                <input type="file" name="image" class="dropify" data-max-file-size="3M"/>
                                @if($errors->has('image'))
                                    <small class="help-block">{{ $errors->first('image') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card summer_note_display summer_note_btn">
                        <div class="card-header">
                            Description
                            <div class="float-right box-tools"></div>
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('description')) has-danger @endif">
                                <textarea id="description" class="textarea form_editors_textarea_wysihtml form-control @if($errors->has('description')) is-invalid @endif" name="description">{{ old('description') }}</textarea>
                                @if($errors->has('description'))
                                    <small class="help-block">{{ $errors->first('description') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Social
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('social.facebook')) has-danger @endif">
                                <label for="social-facebook">Facebook</label>
                                <input type="text" id="social-facebook" name="social[facebook]" class="form-control @if($errors->has('social.facebook')) is-invalid @endif" value="{{ old('social.facebook') }}"/>
                                @if($errors->has('social.facebook'))
                                    <small class="help-block">{{ $errors->first('social.facebook') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('social.twitter')) has-danger @endif">
                                <label for="social-twitter">Twitter</label>
                                <input type="text" id="social-twitter" name="social[twitter]" class="form-control @if($errors->has('social.twitter')) is-invalid @endif" value="{{ old('social.twitter') }}"/>
                                @if($errors->has('social.twitter'))
                                    <small class="help-block">{{ $errors->first('social.twitter') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('social.instagram')) has-danger @endif">
                                <label for="social-instagram">Instagram</label>
                                <input type="text" id="social-instagram" name="social[instagram]" class="form-control @if($errors->has('social.instagram')) is-invalid @endif" value="{{ old('social.instagram') }}"/>
                                @if($errors->has('social.instagram'))
                                    <small class="help-block">{{ $errors->first('social.instagram') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('social.pinterest')) has-danger @endif">
                                <label for="social-pinterest">Pinterest</label>
                                <input type="text" id="social-pinterest" name="social[pinterest]" class="form-control @if($errors->has('social.pinterest')) is-invalid @endif" value="{{ old('social.pinterest') }}"/>
                                @if($errors->has('social.pinterest'))
                                    <small class="help-block">{{ $errors->first('social.pinterest') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('social.google')) has-danger @endif">
                                <label for="social-google">Google</label>
                                <input type="text" id="social-google" name="social[google]" class="form-control @if($errors->has('social.google')) is-invalid @endif" value="{{ old('social.google') }}"/>
                                @if($errors->has('social.google'))
                                    <small class="help-block">{{ $errors->first('social.google') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            SEO
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('seo.title')) has-danger @endif">
                                <label for="seo-title">Title</label>
                                <input type="text" id="seo-title" class="form-control @if($errors->has('seo.title')) is-invalid @endif" name="seo[title]" value="{{ old('seo.title') }}"/>
                                @if($errors->has('seo.title'))
                                    <small class="help-block">{{ $errors->first('seo.title') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('seo.description')) has-danger @endif">
                                <label for="seo-description">Description</label>
                                <textarea id="seo-description" class="form-control @if($errors->has('seo.description')) is-invalid @endif" name="seo[description]">{{ old('seo.description') }}</textarea>
                                @if($errors->has('seo.description'))
                                    <small class="help-block">{{ $errors->first('seo.description') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('seo.keywords')) has-danger @endif">
                                <label for="seo-keywords">Keywords</label>
                                <textarea id="seo-keywords" class="form-control @if($errors->has('seo.keywords')) is-invalid @endif" name="seo[keywords]">{{ old('seo.keywords') }}</textarea>
                                @if($errors->has('seo.keywords'))
                                    <small class="help-block">{{ $errors->first('seo.keywords') }}</small>
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
    <script type="text/javascript" src="{{ asset('/assets/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <script type="text/javascript" src="/assets/js/form.js"></script>
    <script type="text/javascript" src="{{asset('/assets/js/pages/form_elements.js')}}"></script>
    <script type="text/javascript" src="{{asset('/assets/js/pages/form_editors.js')}}"></script>
    <script>
        function slugify(text)
        {
            return text.toString().toLowerCase()
                .replace(/\s+/g, '-')           // Replace spaces with -
                .replace(/[^\w\-]+/g, '')       // Remove all non-word chars
                .replace(/\-\-+/g, '-')         // Replace multiple - with single -
                .replace(/^-+/, '')             // Trim - from start of text
                .replace(/-+$/, '');            // Trim - from end of text
        }

        $(function(){
            $('.dropify').dropify();
            $('.slug-source').on('change paste keyup', function(){
                $('.slug').val(slugify($(this).val()));
            });
        });
    </script>
@endpush
