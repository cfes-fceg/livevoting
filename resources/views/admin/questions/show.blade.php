@extends('layouts.app')

@section('content')

    <div class="card card-default">
        <div class="card-header clearfix">
            <span>
                <h4 class="mt-4 mb-4">{{ isset($question->title) ? $question->title : 'Question' }}</h4>
            </span>

            <div class="float-left">
                <form method="POST" action="{!! route('questions.question.update', $question->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="PUT" type="hidden">
                    {{ csrf_field() }}
                    @if(! ($question->is_active))
                        <input name="is_active" value="1" type="hidden">
                        <button class="btn btn-success btn-md" type="submit">
                            Activate
                        </button>
                    @else
                        <button class="btn btn-danger btn-md" type="submit">
                            Close
                        </button>
                    @endif
                </form>
            </div>

            <div class="float-right d-inline-block">
                <form method="POST" action="{!! route('questions.question.destroy', $question->id) !!}"
                      accept-charset="UTF-8">
                    <input name="_method" value="DELETE" type="hidden">
                    {{ csrf_field() }}
                    <div class="btn-group btn-group-md" role="group">
                        <a href="{{ route('questions.question.index') }}" class="btn btn-primary"
                           title="Show All Question">
                            Show all
                        </a>

                        <a href="{{ route('questions.question.create') }}" class="btn btn-success"
                           title="Create New Question">
                            New
                        </a>

                        <a href="{{ route('questions.question.edit', $question->id ) }}" class="btn btn-primary"
                           title="Edit Question">
                            Edit
                        </a>

                        <button type="submit" class="btn btn-danger" title="Delete Question"
                                onclick="return confirm('Click Ok to delete Question.?')">
                            Delete
                        </button>
                    </div>
                </form>

            </div>

        </div>

        <div class="card-body">
            <p>Coming soon</p>
        </div>
    </div>

@endsection
