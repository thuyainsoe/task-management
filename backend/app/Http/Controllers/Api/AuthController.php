<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $email = $request->email ?? null;
        $password = $request->password ?? null;

        $crenditials = [
            'email' => $email,
            'password' => $password,
        ];

        $user = User::where('email', $email)->first();
        if(!$user) {
            return response(['message' => 'User Not Found'], 404);
        }

        if(!Auth::attempt($crenditials)) {
            return response(['message' => 'Password Incorrect Please Try Again'], 400);
        }

        $token = $user->createToken('test_token');

        return response([
            'token' => $token->plainTextToken,
            'user' => $user,
            ]);
    }

    public function register (Request $request) {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
            'username' => 'required',
            'role' => 'required',
            'department_id' => 'required',
        ]);

        if(User::where('email', $request->email)->exists()) {
            return response()->json(['message' => 'email already registered . Please login'],  400 );
        }

        $data = $request->toArray();

        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }
}
