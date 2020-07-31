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
            <h4 class="mt-4 mb-4">Users</h4>
        </div>

    </div>

    @if(count($users) == 0)
    <div class="card-body text-center">
        <h4>No Users Available.</h4>
    </div>
    @else
    <div class="card-body p-0">
        <div class="table-responsive" style="overflow-x: unset">

            <table class="table table-striped ">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th/>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <form method="POST" action="{!! route('admin.users.destroy', $user->id) !!}"
                              accept-charset="UTF-8">
                            <input name="_method" value="DELETE" type="hidden">
                            {{ csrf_field() }}

                            <div class="btn-group btn-group-xs float-right" role="group">
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
        {!! $users->render() !!}
    </div>

    @endif

</div>

@endsection
