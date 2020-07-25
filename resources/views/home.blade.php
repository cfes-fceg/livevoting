@extends('layouts.app')

@section('content')
    <div id="voting-booth" data="{{ json_encode([ 'engSocs' => $engSocs, 'user' => Auth::user() ]) }}">
    </div>
@endsection
