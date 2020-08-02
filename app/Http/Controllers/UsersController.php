<?php

namespace App\Http\Controllers;

use App\Role\UserRole;
use App\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $data = $this->getData($request, $user);
        $user->setRoles([$data['role']]);
        unset($data['role']);
        $user->update($data);

        return redirect()->route('admin.users', $user->id)
            ->with('success_message', 'User was successfully updated.');
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user, Request $request)
    {
        try {
            if ($user->id == $request->user()->id) {
                return back()->withInput()
                    ->withErrors(['error' => 'You cannot delete yourself']);
            }
            $user->delete();

            return redirect()->route('admin.users')
                ->with('success_message', 'User was successfully deleted.');
        } catch (Exception $exception) {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.', 'exception' => json_decode($exception)]);
        }
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * @param Request $request
     * @param User $user
     * @return array
     */
    protected function getData(Request $request, User $user)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user)],
            'role' => ['required', 'string']
        ];

        return $request->validate($rules);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLink(Request $request, User $user)
    {
        if ($request->user()->hasRole(UserRole::ROLE_ADMIN)) {
            User::sendWelcomeEmail($user);
            return redirect()->route('admin.users')->with('success_message', 'Reset email sent');
        } else {
            return back()->withInput()
                ->withErrors(['unexpected_error' => 'Unexpected error occurred while trying to process your request.']);
        }
    }

}
