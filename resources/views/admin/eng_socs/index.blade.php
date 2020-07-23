@extends('layouts.app')

@section('content')
@if(Session::has('success_message'))
<div class="alert alert-success">
    {!! session('success_message') !!}

    <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>

</div>
@endif

<div class="card">

    <div class="card-header clearfix">

        <div>
            <h4 class="mt-4 mb-4">Engineering Societies</h4>
        </div>

        <div class="btn-group btn-group-md float-right" role="group">
            <a href="{{ route('admin.engsocs.create') }}" class="btn btn-success" title="Create New Eng Soc">
                Create new EngSoc
            </a>
        </div>

    </div>

    @if(count($engSocs) == 0)
    <div class="card-body text-center">
        <h4>No Engineering Societies Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: unset">

            <table class="table table-striped ">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Voting Representative</th>

                    <th> </th>
                </tr>
                </thead>
                <tbody>
                @foreach($engSocs as $engSoc)
                <tr>
                    <td>{{ $engSoc->name }}</td>
                    <td>{{ $engSoc->location }}</td>
                    <td>
                        <div class="voter-select" id="{{ 'voter-select'.$engSoc->id }}" data="{{ json_encode([ "engSoc" => $engSoc, "options" => $voters, "selected" => $engSoc->voter ]) }}"></div>
                    </td>
                    <td>
                        <form method="POST" action="{!! route('admin.engsocs.destroy', $engSoc->id) !!}"
                              accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}

                            <div class="btn-group btn-group-xs pull-right" role="group">
                                <a href="{{ route('admin.engsocs.edit', $engSoc->id ) }}" class="btn btn-primary"
                                   title="Edit Eng Soc">
                                    Edit
                                </a>

                                <button type="submit" class="btn btn-danger" title="Delete Eng Soc"
                                        onclick="return confirm('Click Ok to delete Eng Soc.')">
                                    Delete
                                </button>
                            </div>

                        </form>

                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>

        </div>
    </div>

    <div class="panel-footer pl-4">
        {!! $engSocs->render() !!}
    </div>

    @endif

</div>

@endsection
