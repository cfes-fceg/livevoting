<?php

namespace App\Http\Controllers;

use App\Question;
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
            return abort(403, 'User must be the voting member of at least one EngSoc');
        }

    }
}
