@if(session()->has('message'))
    <div class="alert alert-{{ session()->get('message-type', 'success') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {!! session()->get('message') !!}
    </div>
@endif