<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return User::with('profile')->get();
    }

    public function show(User $user)
    {
        return $user->load('profile');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'profile_id' => 'required|exists:profiles,id'
        ]);

        $data['password'] = bcrypt($data['password']);
        
        return User::create($data);
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'sometimes|required',
            'email' => 'sometimes|email|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:6',
            'profile_id' => 'sometimes|exists:profiles,id'
        ]);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        $user->update($data);
        return $user;
    }

    public function destroy(User $user)
    {
        $user->delete();
        return response()->noContent();
    }

    public function getUsersByProfile(Profile $profile)
    {
        return $profile->users()->with('profile')->get();
    }
}