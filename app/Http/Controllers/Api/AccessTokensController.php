<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AccessTokensController extends Controller
{
    public function index()
    {
        $user = Auth::guard('sanctum')->user();
        return $user->tokens;
    }

    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', '=', $request->post('email'))->first();
        if ($user && Hash::check($request->password, $user->password)) {
            // Create Access Token and return it in response
            $token = $user->createToken( $request->userAgent(), [
                'products.create', 'products.read'
            ] );

            return response([
                'token' => $token->plainTextToken,
                'user' => $user,
            ], 201);
        }

        return response()->json([
            'message' => 'Invalid credentials',
        ], 401);
    }

    public function destroy($token = null)
    {
        $user = Auth::guard('sanctum')->user();

        if ($token) {
            $user->tokens()->findOrFail($token)->delete();
        } else {
            // Logout from current device
            //$user->currentAccessToken()->delete();
            $user->currentAccessToken()->update([
                'expires_at' => now(),
            ]);
        }
        // logout from all devices
        // $user->tokens()->delete();

        return [
            'message' => 'Token deleted!',
        ];
    }
}
