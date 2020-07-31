<?php

namespace App\Http\Controllers;

use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UsersController extends Controller
{

    public function index()
    {
        $users = User::orderBy('name', 'desc')
            ->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    public function update(Request $request, User $user)
    {
        try {

            $data = $this->getData($request);
            $user->update($data);

            return redirect()->route('admin.users', $user->id)
                ->with('success_message', 'User was successfully updated.');
        } catch (Exception $exception) {
            Log::error($exception);
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    public function destroy(User $user)
    {
        try {
            $user->delete();

            return redirect()->route('admin.users')
                ->with('success_message', 'User was successfully deleted.');
        } catch (Exception $exception) {

            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

    protected function getData(Request $request)
    {
        $rules = [
            'name' => 'string|min:1|max:255|nullable',
            'email' => 'boolean|nullable',
        ];

        $data = $request->validate($rules);

        $data['is_active'] = $request->has('is_active');

        return $data;
    }

}
