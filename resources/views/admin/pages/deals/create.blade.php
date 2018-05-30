@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Create Deal
    @parent
@stop
{{-- page level styles --}}
@push('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('/assets/vendors/dropify/css/dropify.css')}}">

    <link type="text/css" rel="stylesheet" media="screen" href="{{ asset('/assets/vendors/bootstrap3-wysihtml5-bower/css/bootstrap3-wysihtml5.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/vendors/inputlimiter/css/jquery.inputlimiter.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/vendors/chosen/css/chosen.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/vendors/jquery-tagsinput/css/jquery.tagsinput.min.css') }}"/>
    <link type="text/css" rel="stylesheet" href="{{ asset('/assets/vendors/multiselect/css/multi-select.css') }}"/>
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
                        New Deal
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <form action="{{ route('admin.deals.add') }}" method="post" enctype="multipart/form-data">
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
                                <label for="name">Deal Title</label>
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
                            <div class="col-lg-12 input_field_sections @if($errors->has('link')) has-danger @endif">
                                <label for="link">Link</label>
                                <input type="text" id="link" class="form-control @if($errors->has('link')) is-invalid @endif" name="link" value="{{ old('link') }}"/>
                                @if($errors->has('link'))
                                    <small class="help-block">{{ $errors->first('link') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('price')) has-danger @endif">
                                <label for="price">Price</label>
                                <input type="number" id="price" class="form-control @if($errors->has('price')) is-invalid @endif" name="price" value="{{ old('price') }}"/>
                                @if($errors->has('price'))
                                    <small class="help-block">{{ $errors->first('price') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Company
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('company_id')) has-danger @endif">
                                <select class="form-control chzn-select" id="company_id" name="company_id" tabindex="2">
                                    <option disabled selected>Choose a Company</option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->getAttribute('id') }}" @if($company->getAttribute('id') == old('company_id')) selected @endif>{{ $company->getAttribute('name') }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('company_id'))
                                    <small class="help-block">{{ $errors->first('company_id') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Deal image
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
                <div class="col-md-12">
                    <div class="card summer_note_display summer_note_btn">
                        <div class="card-header">
                            Terms & Conditions
                            <div class="float-right box-tools"></div>
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('terms_and_conditions')) has-danger @endif">
                                <textarea id="terms_and_conditions" class="textarea form_editors_textarea_wysihtml form-control @if($errors->has('terms_and_conditions')) is-invalid @endif" name="terms_and_conditions">{{ old('terms_and_conditions') }}</textarea>
                                @if($errors->has('terms_and_conditions'))
                                    <small class="help-block">{{ $errors->first('terms_and_conditions') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            Gallery
                        </div>
                        <div class="card-body row @if($errors->has('gallery')) has-danger @endif">
                            <div class="col-lg-6 input_field_sections">
                                <input type="file" name="gallery[]" class="dropify" data-max-file-size="3M"/>
                            </div>
                            <div class="col-lg-6 input_field_sections">
                                <input type="file" name="gallery[]" class="dropify" data-max-file-size="3M"/>
                            </div>
                            <div class="col-lg-6 input_field_sections">
                                <input type="file" name="gallery[]" class="dropify" data-max-file-size="3M"/>
                            </div>
                            <div class="col-lg-6 input_field_sections">
                                <input type="file" name="gallery[]" class="dropify" data-max-file-size="3M"/>
                            </div>
                            @if($errors->has('gallery'))
                                <small class="help-block">{{ $errors->first('gallery') }}</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Location
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-6 input_field_sections @if($errors->has('location.lat')) has-danger @endif">
                                <label for="location-lat">Latitude</label>
                                <input type="text" id="location-lat" class="form-control @if($errors->has('location.lat')) is-invalid @endif" name="location[lat]" value="{{ old('location.lat') }}"/>
                                @if($errors->has('location.lat'))
                                    <small class="help-block">{{ $errors->first('location.lat') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-6 input_field_sections @if($errors->has('location.lon')) has-danger @endif">
                                <label for="location-lon">Longitude</label>
                                <input type="text" id="location-lon" class="form-control @if($errors->has('location.lon')) is-invalid @endif" name="location[lon]" value="{{ old('location.lon') }}"/>
                                @if($errors->has('location.lon'))
                                    <small class="help-block">{{ $errors->first('location.lon') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('maps_link')) has-danger @endif">
                                <label for="maps-link">Maps link</label>
                                <input type="text" id="maps-link" class="form-control @if($errors->has('maps_link')) is-invalid @endif" name="maps_link" value="{{ old('maps_link') }}"/>
                                @if($errors->has('maps_link'))
                                    <small class="help-block">{{ $errors->first('maps_link') }}</small>
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

    <script type="text/javascript" src="{{ asset('/assets/vendors/jquery.uniform/js/jquery.uniform.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/inputlimiter/js/jquery.inputlimiter.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/chosen/js/chosen.jquery.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/jquery-tagsinput/js/jquery.tagsinput.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/js/pluginjs/jquery.validVal.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/moment/js/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/daterangepicker/js/daterangepicker.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/datepicker/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/bootstrap-switch/js/bootstrap-switch.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/autosize/js/jquery.autosize.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/inputmask/js/inputmask.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/inputmask/js/jquery.inputmask.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/inputmask/js/inputmask.date.extensions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/inputmask/js/inputmask.extensions.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/multiselect/js/jquery.multi-select.js') }}"></script>
    <script type="text/javascript" src="{{ asset('/assets/vendors/bootstrap3-wysihtml5-bower/js/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <script type="text/javascript" src="{{ asset('/assets/js/form.js') }}"></script>
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
