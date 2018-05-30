@extends(('admin.layouts.default'))
{{-- Page title --}}
@section('title')
    Listings
    @parent
@stop

@section('content')

    <header class="head">
        <div class="main-bar">
            <div class="row no-gutters">
                <div class="col-6">
                    <h4 class="m-t-5">
                        <i class="fa fa-home"></i>
                        Listings
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
                            <a class="btn btn-mint" href="{{ route('admin.listings.create') }}"><i class="fa fa-plus-square-o"></i> Add</a>
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
                                    <th>Company</th>
                                    <th>Deal</th>
                                    <th>Premium</th>
                                    <th>Status</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($listings as $listing)
                                    <tr>
                                        <td>{{ $listing->getAttribute('id') }}</td>
                                        <td>{{ $listing->getRelation('deal')->company->getAttribute('name') }}</td>
                                        <td>{{ $listing->getRelation('deal')->getAttribute('name') }}</td>
                                        <td>
                                            {{ $listing->getRelation('sliderImage') ? 'slider' : '' }}
                                            {{ $listing->getRelation('menuImage') ? 'menu' : '' }}
                                        </td>
                                        <td>{{ listingStatuses()[$listing->getAttribute('status')] }}</td>
                                        <td>
                                            <a href="{{ route('admin.listings.edit', ['id' => $listing->getAttribute('id')]) }}" class="text-primary m-2">
                                                <span class="fa fa-pencil"></span>
                                            </a>
                                            <a href="{{ route('admin.listings.delete', ['id' => $listing->getAttribute('id')]) }}" class="text-danger m-2">
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
                            {{ $listings->appends(request()->except('page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
