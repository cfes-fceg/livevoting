@extends('layouts.app')

@section('content')
    <h1 class="display-4 my-5 text-center">Hello, {{ Auth::user()->name }}</h1>
    <ul class="btn-group row w-100">
        <a class="btn col-4 btn-outline-secondary" href="{{ route("admin.engsocs") }}">Manage Engineering Societies</a>
        <a class="btn col-4 btn-outline-primary" href="{{ route("admin.questions.create") }}">Create new Question</a>
        <a class="btn col-4 btn-outline-secondary" href="{{ route("admin.questions") }}">Manage questions</a>
    </ul>
    <h3 class="mt-4">Recent questions:</h3>
    <div class="row">
        @foreach(\App\Question::whereHas('votes')->orderByDesc('created_at')->take(3)->get() as $question)
            <div class="col-md-4 py-3">
                <div class="card h-100">
                    <div class="card-img-top pt-2">
                        <div class="results-graph" data="{{ json_encode($question->results()) }}">
                        </div>
                    </div>
                    {{--                <img src="..." class="card-img-top" alt="...">--}}
                    <div class="card-body">
                        <h5 class="card-title">#{{ $question->id }}: {{ $question->title }}</h5>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">Last updated: {{ $question->updated_at }}</small>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
