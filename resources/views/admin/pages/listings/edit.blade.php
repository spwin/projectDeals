@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Edit Listing
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
                        Edit Listing
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <form action="{{ route('admin.listings.save', ['id' => $listing->getAttribute('id')]) }}" method="post" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            Deal
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('deal_id')) has-danger @endif">
                                <select class="form-control chzn-select" id="deal_id" name="deal_id" tabindex="2">
                                    <option disabled selected>Choose a Deal</option>
                                    @foreach($deals as $deal)
                                        <option value="{{ $deal->getAttribute('id') }}" @if($deal->getAttribute('id') == old('deal_id', $listing->getAttribute('deal_id'))) selected @endif>{{ $deal->getAttribute('name') }}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('deal_id'))
                                    <small class="help-block">{{ $errors->first('deal_id') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Details
                        </div>
                        <div class="card-body row">
                            <div class="col-lg-12 input_field_sections @if($errors->has('weeks')) has-danger @endif">
                                <label for="weeks">Total weeks</label>
                                <input type="number" id="weeks" class="form-control @if($errors->has('weeks')) is-invalid @endif" name="weeks" value="{{ old('weeks', $listing->getAttribute('weeks')) }}"/>
                                @if($errors->has('weeks'))
                                    <small class="help-block">{{ $errors->first('weeks') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('coupons_count')) has-danger @endif">
                                <label for="count">Coupons to draw (per week)</label>
                                <input type="number" id="count" class="form-control @if($errors->has('coupons_count')) is-invalid @endif" name="coupons_count" value="{{ old('coupons_count', $listing->getAttribute('coupons_count')) }}"/>
                                @if($errors->has('coupons_count'))
                                    <small class="help-block">{{ $errors->first('coupons_count') }}</small>
                                @endif
                            </div>
                            <div class="col-lg-12 input_field_sections @if($errors->has('status')) has-danger @endif">
                                <label for="status">Status</label>
                                <select class="form-control" id="status" name="status">
                                    @foreach(listingStatuses() as $id => $status)
                                        <option value="{{ $id }}" @if(old('status', $listing->getAttribute('status')) == $id) selected @endif>{{ $status}}</option>
                                    @endforeach
                                </select>
                                @if($errors->has('status'))
                                    <small class="help-block">{{ $errors->first('status') }}</small>
                                @endif
                            </div>
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="valid" value="1" @if(old('valid', $listing->getAttribute('valid'))) checked @endif>
                                <span class="checkbox">Valid listing (display on frontend)</span>
                            </label>
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
                        <div class="card-header">
                            Homepage Slider
                        </div>
                        <div class="card-body row">
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="slider_image" value="1" @if(old('slider_image', $listing->getAttribute('slider_image'))) checked @endif>
                                <span class="checkbox">List on homepage slider</span>
                            </label>
                            <div class="col-lg-12 input_field_sections @if($errors->has('slider_image_file')) has-danger @endif">
                                <input type="file" name="slider_image_file" class="dropify" data-max-file-size="3M" @if($image = $listing->getSliderImage()) data-default-file="{{ $image }}" @endif/>
                                @if($errors->has('slider_image_file'))
                                    <small class="help-block">{{ $errors->first('slider_image_file') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Deals Menu Image
                        </div>
                        <div class="card-body row">
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="menu_image" value="1" @if(old('menu_image', $listing->getAttribute('menu_image'))) checked @endif>
                                <span class="checkbox">List on Deals Dropdown Menu</span>
                            </label>
                            <div class="col-lg-12 input_field_sections @if($errors->has('menu_image_file')) has-danger @endif">
                                <input type="file" name="menu_image_file" class="dropify" data-max-file-size="3M" @if($image = $listing->getMenuImage()) data-default-file="{{ $image }}" @endif/>
                                @if($errors->has('menu_image_file'))
                                    <small class="help-block">{{ $errors->first('menu_image_file') }}</small>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            Other Premium
                        </div>
                        <div class="card-body row">
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="best_deals" value="1" @if(old('best_deals', $listing->getAttribute('best_deals'))) checked @endif>
                                <span class="checkbox">List in Best Deals</span>
                            </label>
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="category_featured" value="1" @if(old('category_featured', $listing->getAttribute('category_featured'))) checked @endif>
                                <span class="checkbox">List in Category Featured</span>
                            </label>
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="follow_link" value="1" @if(old('follow_link', $listing->getAttribute('follow_link'))) checked @endif>
                                <span class="checkbox">Use follow link to Deal</span>
                            </label>
                            <label class="custom-control mt-4">
                                <input type="checkbox" name="newsletter" value="1" @if(old('newsletter', $listing->getAttribute('newsletter'))) checked @endif>
                                <span class="checkbox">List in Newsletter</span>
                            </label>
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
