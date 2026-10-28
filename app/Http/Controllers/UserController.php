<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /** Profiles can only be changed by the signed-in owner. */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit($id)
    {
        $user = $this->ownProfile($id);

        return view('user.editUser')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $user = $this->ownProfile($id);

        $data = $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:1999',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];

        // The old file name comes from the database, never from the form.
        if ($request->hasFile('avatar')) {
            if ($user->avatar && $user->avatar !== 'default.png' && $user->avatar === basename($user->avatar)) {
                Storage::disk('public')->delete('avatars/' . $user->avatar);
            }
            $user->avatar = basename($request->file('avatar')->store('avatars', 'public'));
        }
        $user->save();

        return redirect('/home')->with('success', 'Profile updated!');
    }

    private function ownProfile($id): User
    {
        abort_unless((int) $id === (int) Auth::id(), 403, 'You can only edit your own profile.');

        return Auth::user();
    }
}
