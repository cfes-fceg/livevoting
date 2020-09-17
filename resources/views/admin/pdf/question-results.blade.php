@extends('layouts.app', ['excludeHeader' => true])

<div class="container py-5">
    <h1>Results report for question: "{{ $question->title }}"</h1>
    <h6>Created at: {{$question->created_at}}</h6>
    <hr class="mb-5"/>
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
