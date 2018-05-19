@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Dashboard
    @parent
@stop
{{-- page level styles --}}
@push('styles')
    <link type="text/css" rel="stylesheet" href="{{asset('assets/css/pages/index.css')}}">
@endpush
@section('content')
    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">

    </div>
@stop
@push('scripts')
    <script type="text/javascript" src="{{asset('assets/js/pages/index.js')}}"></script>
@endpush
