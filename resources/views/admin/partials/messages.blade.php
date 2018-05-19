@if(session()->has('message'))
    <div class="alert alert-{{ session()->get('message-type', 'success') }} alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{--@if(session()->get('message-type', 'success') == 'success')
            <h4><i class="icon fa fa-check"></i> Success!</h4>
        @elseif(session()->get('message-type') == 'warning')
            <h4><i class="icon fa fa-warning"></i> Warning!</h4>
        @elseif(session()->get('message-type') == 'danger')
            <h4><i class="icon fa fa-ban"></i> Danger!</h4>
        @else
            <h4><i class="icon fa fa-info"></i> Info!</h4>
        @endif--}}
        {{ session()->get('message') }}
    </div>
@elseif(isset($errors) && !$errors->isEmpty())
    <div class="alert alert-danger alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{--<h4><i class="icon fa fa-ban"></i> Validation Error!</h4>--}}
        Please fix all the errors in the form
    </div>
@endif