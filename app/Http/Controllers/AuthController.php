<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller {
    public function register(Request $request) {
        $request->validate([
            'nombre_completo' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'telefono' => 'nullable|string',
            'pais' => 'nullable|string',
            'rol' => 'in:admin,cliente'
        ]);

        $user = User::create([
            'nombre_completo' => $request->nombre_completo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'telefono' => $request->telefono,
            'pais' => $request->pais,
            'rol' => $request->rol ?? 'cliente',
        ]);

        $token = $user->createToken('api_token')->plainTextToken;

        return response()->json(['message' => 'registro exitoso', 'user' => $user, 'token' => $token], 201);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('token_name')->plainTextToken;

            return response()->json(['token' => $token]);
        }

        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function logout(Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Sesión cerrada']);
    }
}

