<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthenticationController extends Controller
{
    public function login_member(Request $request)
    {
        // Validate the request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Fetch member by email
        $member = Member::where('email', $request->email)->first();

        // Check if member exists and the password is correct
        if (!$member || !Hash::check($request->password, $member->password)) {
            return response()->json(['error' => 'Invalid credentials!'], 401);
        }

        $customClaims = [
            'email' => $member->email,
            'id' => $member->id,  // Use 'sub' as the standard claim for user ID
            'role' => 'member', // Assuming all users logging in through this endpoint are members
        ];

        // Generate new token with custom claims
        try {
            $token = JWTAuth::claims($customClaims)->fromUser($member);
            Log::info("JWT Token generated successfully for user: {$member->email}");
        } catch (\Exception $e) {
            Log::error("Failed to generate JWT token: " . $e->getMessage());
            return response()->json(['error' => 'Could not create token'], 500);
        }

        return $this->respondWithToken($token);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ]);
    }

    public function logout_member(Request $request)
    {
        try {
            auth()->logout();
            Log::info("User successfully logged out");
            return response()->json(['message' => 'Successfully logged out']);
        } catch (\Exception $e) {
            Log::error("Failed to logout user: " . $e->getMessage());
            return response()->json(['error' => 'Could not log out'], 500);
        }
    }

    public function person(Request $request)
    {
        try {
            $user = auth()->user();
            Log::info("Authenticated user retrieved: " . json_encode($user));
            return response()->json($user);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve authenticated user: " . $e->getMessage());
            return response()->json(['error' => 'Could not retrieve user'], 500);
        }
    }
}
