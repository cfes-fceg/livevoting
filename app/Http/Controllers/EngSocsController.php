<?php

namespace App\Http\Controllers;

use App\Models\EngSoc;
use Exception;
use Illuminate\Http\Request;

class EngSocsController extends Controller
{

    /**
     * Display a listing of the eng socs.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $engSocs = EngSoc::paginate(25);

        return view('admin.eng_socs.index', compact('engSocs'));
    }

    /**
     * Show the form for creating a new eng soc.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {


        return view('admin.eng_socs.create');
    }

    /**
     * Store a new eng soc in the storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        try {

            $data = $this->getData($request);

            EngSoc::create($data);

            return redirect()->route('eng_socs.eng_soc.index')
                ->with('success_message', 'Eng Soc was successfully added.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

//    /**
//     * Display the specified eng soc.
//     *
//     * @param int $id
//     *
//     * @return Illuminate\View\View
//     */
//    public function show($id)
//    {
//        $engSoc = EngSoc::findOrFail($id);
//
//        return view('admin.eng_socs.show', compact('engSoc'));
//    }

    /**
     * Show the form for editing the specified eng soc.
     *
     * @param int $id
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $engSoc = EngSoc::findOrFail($id);


        return view('admin.eng_socs.edit', compact('engSoc'));
    }

    /**
     * Update the specified eng soc in the storage.
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

            $engSoc = EngSoc::findOrFail($id);
            $engSoc->update($data);

            return redirect()->route('eng_socs.eng_soc.index')
                ->with('success_message', 'Eng Soc was successfully updated.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    /**
     * Remove the specified eng soc from the storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        try {
            $engSoc = EngSoc::findOrFail($id);
            $engSoc->delete();

            return redirect()->route('eng_socs.eng_soc.index')
                ->with('success_message', 'Eng Soc was successfully deleted.');
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
            'name' => 'string|min:1|max:255|nullable',
            'location' => 'string|min:1|nullable',
            'votingRepresentative' => 'string|min:1|nullable',
        ];

        $data = $request->validate($rules);


        return $data;
    }

}
