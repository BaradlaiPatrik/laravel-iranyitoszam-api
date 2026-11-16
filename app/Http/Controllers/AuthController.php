<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @api {post} /login Bejelentkezés (Token kérése)
     * @apiName LoginUser
     * @apiGroup Auth
     *
     * @apiBody {String} email Felhasználó e-mail címe.
     * @apiBody {String} password Jelszó.
     *
     * @apiSuccess {Object} user A bejelentkezett felhasználó adatai.
     * @apiSuccess {String} token Bearer token a védett végpontokhoz.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password',
            ], 401);
        }

        $user->tokens()->delete();
        $token = $user->createToken('access')->plainTextToken;

        return response()->json([
            'user' => $user,
            'token' => $token,
        ]);
    }

    /**
     * @api {post} /logout Kijelentkezés (token törlése)
     * @apiName Logout
     * @apiGroup Auth
     * @apiHeader {String} Authorization Bearer {token}
     * @apiSuccess {String} message Sikeres kijelentkezés üzenet
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Logged out successfully'
        ]);
    }
}