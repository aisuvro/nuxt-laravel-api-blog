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
}
