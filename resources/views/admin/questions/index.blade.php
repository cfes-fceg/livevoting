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

    <div class="card card-default">

        <div class="card-header clearfix">

            <div>
                <h4 class="mt-4 mb-4">Questions</h4>
            </div>

            <div class="btn-group btn-group-md float-right" role="group">
                <a href="{{ route('admin.questions.create') }}" class="btn btn-success" title="Create New Question">
                    Create New Question
                </a>
            </div>

        </div>

        @if(count($questions) == 0)
            <div class="card-body text-center">
                <h4>No Questions Available.</h4>
            </div>
        @else
        <div class="card-body p-0">
            <div class="table-responsive">

                <table class="table table-striped ">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Status</th>

                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->title }}</td>
                            <td>
                                @if($question->is_active)
                                    <h4><span class="badge badge-success badge-pill">Active</span></h4>
                                @else
                                    <h4><span class="badge badge-secondary badge-pill">Closed</span></h4>
                                @endif
                            </td>

                            <td>

                                <form method="POST" action="{!! route('admin.questions.destroy', $question->id) !!}" accept-charset="UTF-8">
                                <input name="_method" value="DELETE" type="hidden">
                                {{ csrf_field() }}

                                    <div class="btn-group btn-group-xs float-right" role="group">
                                        <a href="{{ route('admin.questions.show', $question->id ) }}" class="btn btn-info" title="Show Question">
                                            Show
                                        </a>
                                        <a href="{{ route('admin.questions.edit', $question->id ) }}" class="btn btn-primary" title="Edit Question">
                                            Edit
                                        </a>

                                        <button type="submit" class="btn btn-danger" title="Delete Question" onclick="return confirm('Click Ok to delete Question.')">
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
            {!! $questions->render() !!}
        </div>

        @endif

    </div>
@endsection
