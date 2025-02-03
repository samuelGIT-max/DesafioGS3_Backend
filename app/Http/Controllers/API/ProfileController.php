<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        return Profile::with('users')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|unique:profiles'
        ]);

        return Profile::create($data);
    }

    public function update(Request $request, Profile $profile)
    {
        $data = $request->validate([
            'name' => 'required|unique:profiles,name,'.$profile->id
        ]);

        $profile->update($data);
        return $profile;
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();
        return response()->noContent();
    }
}