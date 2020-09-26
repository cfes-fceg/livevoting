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
    @if($errors->any())
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                <span aria-hidden="true">&times;</span>
            </button>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
                            <th>Email</th>
                            <th>Role</th>
                            <th>Email Verified</th>
                            <th/>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ \App\Role\UserRole::getRoleList()[$user->getRoles()[0]] }}</td>
                                <td>{{ $user->email_verified_at }}</td>
                                <td>
                                    <form method="POST" action="{!! route('admin.users.destroy', $user->id) !!}"
                                          accept-charset="UTF-8">
                                        <input name="_method" value="DELETE" type="hidden">
                                        {{ csrf_field() }}
                                        <div class="btn-group btn-group-xs float-right" role="group">
                                            <a class="btn btn-primary"
                                               href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                            <span
                                                class="d-inline-block p-0 btn btn-danger @if($user->id == Auth::user()->id || $user->votes()->sum('id') != 0) disabled @endif"
                                                tabindex="0"
                                                @if($user->id == Auth::user()->id || $user->votes()->sum('id') != 0)
                                                data-toggle="tooltip" data-placement="top"
                                                title="This user cannot be deleted"
                                                @endif>
                                                <button type="submit"
                                                        class="btn m-0 btn-danger"
                                                        @if($user->id == Auth::user()->id || $user->votes()->sum('id') != 0)
                                                        disabled
                                                        style="pointer-events: none; color: white;"
                                                        @endif
                                                        onclick="return confirm('Click Ok to delete User.')"
                                                >
                                                    Delete
                                                </button>
                                            </span>
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
