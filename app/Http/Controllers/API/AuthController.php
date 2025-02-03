<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);

    if (!Auth::attempt($credentials)) {
        return response()->json(['message' => 'Credenciais inválidas'], 401);
    }

    $user = User::where('email', $request->email)->firstOrFail();
    $token = $user->createToken('auth_token')->plainTextToken; // Método do Sanctum

    return response()->json([
        'access_token' => $token,
        'token_type' => 'Bearer',
        'user' => $user
    ]);
}

public function logout(Request $request)
{
    $request->user()->currentAccessToken()->delete(); // Método do Sanctum
    return response()->json(['message' => 'Logout realizado com sucesso']);
}

    public function user(Request $request)
    {
        return response()->json($request->user()->load('profile'));
    }
}