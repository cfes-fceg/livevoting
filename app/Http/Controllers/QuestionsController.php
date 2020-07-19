<?php

namespace App\Http\Controllers;

use App\Question;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class QuestionsController extends Controller
{

    /**
     * Display a listing of the questions.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $questions = Question::orderBy('is_active', 'desc')
            ->orderBy('updated_at', 'desc')
            ->paginate(25);

        return view('admin.questions.index', compact('questions'));
    }

    /**
     * Show the form for creating a new question.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {


        return view('admin.questions.create');
    }

    /**
     * Store a new question in the storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            Question::create($data);

            return redirect()->route('questions.question.index')
                ->with('success_message', 'Question was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Display the specified question.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $question = Question::findOrFail($id);

        return view('admin.questions.show', compact('question'));
    }

    /**
     * Show the form for editing the specified question.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $question = Question::findOrFail($id);


        return view('admin.questions.edit', compact('question'));
    }

    /**
     * Update the specified question in the storage.
     *
     * @param int $id
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id, Request $request)
    {
        try {

            $data = $this->getData($request);

            $question = Question::findOrFail($id);
            $question->update($data);

            return redirect()->route('questions.question.show', $question->id)
                ->with('success_message', 'Question was successfully updated.');
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified question from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $question = Question::findOrFail($id);
            $question->delete();

            return redirect()->route('questions.question.index')
                ->with('success_message', 'Question was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }


    /**
     * Get the request's data from the request.
     *
     * @param Request $request
     * @return array
     */
    protected function getData(Request $request)
    {
        $rules = [
            'title' => 'string|min:1|max:255|nullable',
            'is_active' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
