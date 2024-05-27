<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Sail\Console\PublishCommand;

class AuthControllers extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email',
            'password' => 'required|string'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        $token = $user->createToken('apiToken')->plainTextToken;

        $res = [
            'user' => $user,
            'token' => $token
        ];
        return response($res, 201);
    }

    public function login(Request $request)
{
    // Validasi data
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Lakukan proses autentikasi
    if (auth()->attempt($request->only('email', 'password'))) {
        $user = auth()->user();
        
        // Buat token
        $token = $user->createToken('apiToken')->plainTextToken;
        
        return response()->json([
            'message' => 'User signed in successfully',
            'user' => $user,
            'token' => $token,
        ]);
    } else {
        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }


}
    

}
