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
                <h4 class="mt-5 mb-5">Questions</h4>
            </div>

            <div class="btn-group btn-group-sm pull-right" role="group">
                <a href="{{ route('questions.question.create') }}" class="btn btn-success" title="Create New Question">
                    Create New Question
                </a>
            </div>

        </div>

        @if(count($questions) == 0)
            <div class="panel-body text-center">
                <h4>No Questions Available.</h4>
            </div>
        @else
        <div class="panel-body panel-body-with-table">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Is Active</th>

                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->title }}</td>
                            <td>{{ ($question->is_active) ? 'Yes' : 'No' }}</td>

                            <td>

                                <form method="POST" action="{!! route('questions.question.destroy', $question->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs pull-right" role="group">
                                        <a href="{{ route('questions.question.show', $question->id ) }}" class="btn btn-info" title="Show Question">
                                            <span class="glyphicon glyphicon-open" aria-hidden="true"></span>Show
                                        </a>
                                        <a href="{{ route('questions.question.edit', $question->id ) }}" class="btn btn-primary" title="Edit Question">
                                            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>Edit
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Question" onclick="return confirm(&quot;Click Ok to delete Question.&quot;)">
                                            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>Delete
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
            {!! $questions->render() !!}
        </div>

        @endif

    </div>
@endsection
