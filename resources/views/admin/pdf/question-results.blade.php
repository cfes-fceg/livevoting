@extends('layouts.app', ['excludeHeader' => true, 'triggerPrint' => true])

<div class="container py-5">
    <h1>Results report for question: "{{ $question->title }}"</h1>
    <h6>Created at: {{$question->created_at}} | ID: {{$question->id}}</h6>
    <hr class="mb-4"/>
    <div class="row mb-3">
        <div class="col-6">
            <div class="results-graph" data="{{ json_encode($question->results()) }}"></div>
        </div>
        <div class="col-6 pr-5 pl-3 d-flex align-items-stretch flex-column">
            <div class="flex-fill">
                <div class="d-flex h-100">
                    <ul class="list-group list-group-horizontal align-self-center w-100">
                        <li class="list-group-item list-group-item-success col-4 text-center">
                            <h4 class="mb-0">
                                For<br/>
                                <span class="badge badge-success badge-pill">{{ $question->results()['FOR'] }}</span>
                            </h4>
                        </li>
                        <li class="list-group-item list-group-item-danger col-4 text-center">
                            <h4 class="mb-0">
                                Against<br/>
                                <span class="badge badge-danger badge-pill">{{ $question->results()['AGAINST'] }}</span>
                            </h4>
                        </li>
                        <li class="list-group-item list-group-item-warning col-4 text-center">
                            <h4 class="mb-0">
                                Abstain<br/>
                                <span class="badge badge-warning badge-pill">{{$question->results()['ABSTAIN']}}</span>
                            </h4>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <table class="w-100">
        <tr>
            <th>
                Timestamp
            </th>
            <th>
                Voting user
            </th>
            <th>
                Engineering Society
            </th>
            <th>
                Vote
            </th>
        </tr>
        @foreach($question->votes()->get() as $vote)
            <tr>
                <td>
                    {{ $vote->created_at }}
                </td>
                <td>
                    {{ $vote->voter->name }}
                </td>
                <td>
                    {{ $vote->engSoc->name }}
                </td>
                <td>
                    {{ $vote->vote }}
                </td>
            </tr>
        @endforeach
    </table>
</div>
