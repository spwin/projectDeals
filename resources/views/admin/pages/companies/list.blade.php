@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Companies
    @parent
@stop

@section('content')

    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Companies
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
                            <a class="btn btn-mint" href="{{ route('admin.companies.create') }}"><i class="fa fa-plus-square-o"></i> Add</a>
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
                                    <th>Phone</th>
                                    <th>User</th>
                                    <th>Created</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($companies as $company)
                                    <tr>
                                        <td>{{ $company->getAttribute('id') }}</td>
                                        <td>{{ $company->getAttribute('name') }}</td>
                                        <td>{{ $company->getAttribute('phone') }}</td>
                                        <td>{{ $company->getRelation('user') ? $company->getRelation('user')->getAttribute('email') : '' }}</td>
                                        <td>{{ $company->getAttribute('created_at') }}</td>
                                        <td>
                                            <a href="{{ route('admin.companies.edit', ['id' => $company->getAttribute('id')]) }}" class="text-primary m-2">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="{{ route('admin.companies.delete', ['id' => $company->getAttribute('id')]) }}" class="text-danger m-2">
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
                            {{ $companies->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
