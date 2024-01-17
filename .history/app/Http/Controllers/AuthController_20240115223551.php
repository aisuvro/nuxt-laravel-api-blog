<?php
namespace App\Http\Controllers;

use App\Models\User;

class AuthController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);
        $user = User::where('email', $request->email)->first();
        if (!$user || !\Illuminate\Support\Facades\Hash::check($request->password, $user->password)) {
            return \Illuminate\Support\Facades\Response::json([
                'message' => 'The provided credentials are incorrect.',
            ], 401);
        }
        return $user->createToken($request->email)->plainTextToken;
    }

    public function logout(\Illuminate\Http\Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return \Illuminate\Support\Facades\Response::json([
            'message' => 'Token deleted.',
        ], 200);
    }

    public function register(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
        ]);
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        return $user->createToken($request->email)->plainTextToken;
    }
}
