<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use App\Models\Member;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        try {
            $token = JWTAuth::parseToken();
            $payload = $token->getPayload();
            $userId = $payload->get('sub'); // Get user ID from token payload
            $userRole = $payload->get('role');

            Log::info("JWT Token parsed successfully");
            Log::info("User ID: {$userId}");
            Log::info("User role from token: {$userRole}");
        } catch (\Exception $e) {
            Log::error("JWT Token parsing failed: " . $e->getMessage());
            return response()->json(['status' => 'Token is invalid'], 403);
        }

        $member = Member::find($userId);
        if (!$member) {
            return response()->json(['status' => 'User not found'], 403);
        }

        Log::info("Required roles: " . implode(', ', $roles));
        Log::info("Authenticated user: " . ($member ? 'Yes' : 'No'));

        // Check if the user's role is in the allowed roles
        if (!$member || !in_array($userRole, $roles)) {
            return response()->json(['status' => 'Insufficient permissions'], Response::HTTP_FORBIDDEN);
        }

        // If all checks pass, proceed with the request
        return $next($request);
    }
}
