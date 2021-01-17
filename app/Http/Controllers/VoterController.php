<?php

namespace App\Http\Controllers;

use App\Question;
use App\Role\UserRole;
use App\Vote;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class VoterController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $engSocs = $request->user()->engSocs->all();

        return view('home', compact('engSocs'));
    }

    public function getActiveQuestions(Request $request)
    {
        $engSocs = $request->user()->engSocs->all();
        if (count($engSocs) > 0) {
            $questions = Question::whereDoesntHave('votes', function (Builder $query) use ($engSocs) {
                $query->whereIn('eng_soc_id', array_map(function ($engSoc) {
                    return $engSoc->id;
                }, $engSocs));
            })->where('is_active', true)->get();
            return response()->json($questions, 200);
        } else {
            abort(403, 'You must be the voting member of at least one EngSoc');
            return null;
        }
    }

    public function castBallot(Request $request, Question $question)
    {
        $user = $request->user();
        $usersEngSocs = $user->engSocs->all();

        if (!$user->hasRole(UserRole::ROLE_VOTER)) {
            abort(403, 'User must be of ROLE_ADMIN');
        }

        if (!$question) {
            abort(404);
        }

        $rules = [
            'votes' => 'required|array|size:' . count($usersEngSocs),
        ];

        $votes = $request->validate($rules)['votes'];
        $validatedVotes = [];

        foreach ($usersEngSocs as $engSoc) {
            $vote = $votes[$engSoc->id];
            if (!in_array($vote["value"], Vote::OPTIONS)) {
                abort(422, 'EngSoc '.$engSoc->name.' is missing its vote');
            } else {
                $voteObj = new Vote();
                $voteObj->vote = $vote["value"];
                $voteObj->noted = $vote["noted"];
                $voteObj->voter()->associate($user);
                $voteObj->engSoc()->associate($engSoc);
                array_push($validatedVotes, $voteObj);
            }
        }

        foreach ($validatedVotes as $validatedVote) {
            $question->votes()->save($validatedVote);
            $validatedVote->save();
        }

        return response()->noContent('201');
    }
}
