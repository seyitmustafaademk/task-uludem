<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register a new user
     *
     * @param RegisterRequest $request
     * @return JsonResponse
     */
    public function register(RegisterRequest $request)
    {
        try {
            $user = User::create([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
                'message' => 'You have successfully registered.',
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to register user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $user = User::where('email', $request->username)
                ->orWhere('username', $request->username)
                ->first();

            if (!$user || !Hash::check($request->password, $user->password)) {
                return response()->json([
                    'message' => 'Invalid username or password. Please try again.',
                ], 401);
            }

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'message' => 'You have successfully logged in.',
                'token' => $token,
                'token_type' => 'Bearer',
                'expires_at' => $user->tokens()->first()->created_at->addMinutes(config('sanctum.expiration')),
                'user' => $user,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to login user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    public function logout()
    {
        try {
            if (!Auth::user())
                return response()->json([
                    'message' => 'You are not logged in.',
                ], 401);

            Auth::user()->tokens()->delete();

            return response()->json([
                'message' => 'You have successfully logged out.',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to logout user',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
