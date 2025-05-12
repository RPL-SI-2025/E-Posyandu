<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware to check if the authenticated user has the required role.
 */
class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @param  string  $role
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = $request->user();

        // Log untuk debugging
        Log::info('Checking role for user:', [
            'user_id' => $user?->id,
            'email' => $user?->email,
            'required_role' => $role,
            'user_role' => $user?->role ?? 'No role',
        ]);

        if (!$user || !$this->userHasRole($user, $role)) {
            return $this->handleForbidden($request, $role);
        }

        return $next($request);
    }

    /**
     * Check if the user has the required role.
     *
     * @param  mixed  $user
     * @param  string  $role
     * @return bool
     */
    private function userHasRole($user, string $role): bool
    {
        $hasRole = $user->role === $role;

        // Log hasil pengecekan role
        Log::info('Role check result:', [
            'user_id' => $user->id,
            'email' => $user->email,
            'required_role' => $role,
            'has_role' => $hasRole,
        ]);

        return $hasRole;
    }

    /**
     * Handle a forbidden response when the user lacks the required role.
     *
     * @param  Request  $request
     * @param  string  $role
     * @return Response
     */
    private function handleForbidden(Request $request, string $role): Response
    {
        Log::warning('Forbidden: Insufficient role', [
            'endpoint' => $request->path(),
            'method' => $request->method(),
            'required_role' => $role,
            'user_id' => $request->user()?->id ?? null,
            'email' => $request->user()?->email ?? 'No user',
        ]);

        return redirect('/')->with('error', 'Forbidden: Insufficient role');
    }
}