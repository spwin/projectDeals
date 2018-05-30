@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Deals
    @parent
@stop

@section('content')

    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Deals
                    </h4>
                </div>
            </div>
        </div>
    </header>
    <div class="outer">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <div class="pull-left">
                            <a class="btn btn-mint" href="{{ route('admin.deals.create') }}"><i class="fa fa-plus-square-o"></i> Add</a>
                        </div>
                        <div class="pull-right">
                            <form method="get">
                                <div class="input-group">
                                    <input type="search" name="q" value="{{ request()->get('q') }}" class="form-control">
                                    <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">
                                        <span class="glyphicon glyphicon-search" aria-hidden="true">
                                    </span> Search!</button>
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive m-t-35">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($deals as $deal)
                                    <tr>
                                        <td>{{ $deal->getAttribute('id') }}</td>
                                        <td>{{ $deal->getAttribute('name') }}</td>
                                        <td>{{ $deal->getRelation('company') ? $deal->getRelation('company')->getAttribute('name') : '' }}</td>
                                        <td>{{ $deal->getAttribute('created_at') }}</td>
                                        <td>
                                            <a href="{{ route('admin.deals.edit', ['id' => $deal->getAttribute('id')]) }}" class="text-primary m-2">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="{{ route('admin.deals.delete', ['id' => $deal->getAttribute('id')]) }}" class="text-danger m-2">
                                                <span class="fa fa-trash"></span>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                            {{ $deals->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
