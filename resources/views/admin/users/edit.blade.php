@extends('layouts.app')

@section('content')

    <div class="card">

        <div class="card-header clearfix">

            <div>
                <h4 class="mt-4 mb-4">{{ !empty($user->name) ? $user->name : 'User' }}</h4>
            </div>
            <div class="btn-group btn-group-md float-right" role="group">

                <a href="{{ route('admin.users') }}" class="btn btn-primary" title="Show All Users">
                    Show All
                </a>

                {{--                <a href="{{ route('admin.users.sendResetLink', $user->id) }}" class="btn btn-primary" title="Send Password Reset Email">--}}
                {{--                    Send Password Reset Email--}}
                {{--                </a>--}}

            </div>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <ul class="alert alert-danger">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            @endif

            <form method="POST" action="{{ route('admin.users.update', $user->id) }}" id="edit_user_form"
                  name="edit_user_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('admin.users.form', [
                                            'user' => $user,
                                          ])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
