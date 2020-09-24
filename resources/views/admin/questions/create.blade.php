@extends('layouts.app')

@section('content')

    <div class="card card-default">

        <div class="card-header clearfix">

            <span>
                <h4 class="mt-4 mb-4">Create New Question</h4>
            </span>

            <div class="btn-group btn-group-md float-right" role="group">
                <a href="{{ route('admin.questions') }}" class="btn btn-primary" title="Show All Question">
                    Show all
                </a>
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

            <form method="POST" action="{{ route('admin.questions.store') }}" accept-charset="UTF-8"
                  id="create_question_form" name="create_question_form" class="form-horizontal">
                {{ csrf_field() }}
                @include ('admin.questions.form', [
                                            'question' => null,
                                            'title' => $title
                                          ])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Add">
                </div>

            </form>

        </div>
    </div>

@endsection


