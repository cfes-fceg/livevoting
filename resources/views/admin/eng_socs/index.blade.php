@extends('layouts.app')

@section('content')
@if(Session::has('success_message'))
<div class="alert alert-success">
    <span class="glyphicon glyphicon-ok"></span>
    {!! session('success_message') !!}

    <button type="button" class="close" data-dismiss="alert" aria-label="close">
        <span aria-hidden="true">&times;</span>
    </button>

</div>
@endif

<div class="panel panel-default">

    <div class="panel-heading clearfix">

        <div class="pull-left">
            <h4 class="mt-5 mb-5">Engineering Societies</h4>
        </div>

        <div class="btn-group btn-group-sm pull-right" role="group">
            <a href="{{ route('eng_socs.eng_soc.create') }}" class="btn btn-success" title="Create New Eng Soc">
                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>Create new EngSoc
            </a>
        </div>

    </div>

    @if(count($engSocs) == 0)
    <div class="panel-body text-center">
        <h4>No Engineering Societies Available.</h4>
    </div>
    @else
    <div class="panel-body panel-body-with-table">
        <div class="table-responsive">

            <table class="table table-striped ">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Voting Representative</th>

                    <th></th>
                </tr>
                </thead>
                <tbody>
                @foreach($engSocs as $engSoc)
                <tr>
                    <td>{{ $engSoc->name }}</td>
                    <td>{{ $engSoc->location }}</td>
                    <td>{{ $engSoc->votingRepresentative }}</td>

                    <td>

                        <form method="POST" action="{!! route('eng_socs.eng_soc.destroy', $engSoc->id) !!}"
                              accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}

                            <div class="btn-group btn-group-xs pull-right" role="group">
                                <a href="{{ route('eng_socs.eng_soc.edit', $engSoc->id ) }}" class="btn btn-primary"
                                   title="Edit Eng Soc">
                                    Edit
                                </a>

                                <button type="submit" class="btn btn-danger" title="Delete Eng Soc"
                                        onclick="return confirm(&quot;Click Ok to delete Eng Soc.&quot;)">
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

    <div class="panel-footer">
        {!! $engSocs->render() !!}
    </div>

    @endif

</div>

@endsection
