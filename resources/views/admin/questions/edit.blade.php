@extends('layouts.app')

@section('content')

    <div class="card card-default">

        <div class="card-header clearfix">

            <div class="pull-left">
                <h4 class="mt-4 mb-4">{{ !empty($question->title) ? $question->title : 'Question' }}</h4>
            </div>
            <div class="btn-group btn-group-md float-right" role="group">

                <a href="{{ route('questions.question.index') }}" class="btn btn-primary" title="Show All Question">
                    Show all
                </a>

                <a href="{{ route('questions.question.create') }}" class="btn btn-success" title="Create New Question">
                    New
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

            <form method="POST" action="{{ route('questions.question.update', $question->id) }}" id="edit_question_form"
                  name="edit_question_form" accept-charset="UTF-8" class="form-horizontal">
                {{ csrf_field() }}
                <input name="_method" type="hidden" value="PUT">
                @include ('admin.questions.form', [
                                            'question' => $question,
                                          ])

                <div class="form-group">
                    <input class="btn btn-primary" type="submit" value="Update">
                </div>
            </form>

        </div>
    </div>

@endsection
