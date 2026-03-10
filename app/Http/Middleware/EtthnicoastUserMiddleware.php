<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EtthnicoastUserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    // Check frontend guard specifically
        if (!Auth::guard('frontend')->check()) {
            return redirect()->route('frontend.login')
                ->with('error', 'Please login to continue.');
        }

        $user = Auth::guard('frontend')->user();

        // Wrong role
        if ($user->role_name !== 'ethnicoast_user') {
            Auth::guard('frontend')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('frontend.login')
                ->with('error', 'Access denied.');
        }

        // Inactive account
        if (isset($user->status) && $user->status !== 'active') {
            Auth::guard('frontend')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('frontend.login')
                ->with('error', 'Your account has been deactivated.');
        }


        if (!Auth::guard('frontend')->check()) {
        // ── Handle AJAX / fetch requests ──────────────────────
        if ($request->expectsJson()) {
            return response()->json([
                'success'  => false,
                'redirect' => route('frontend.login'),
            ], 401);
        }
        return redirect()->route('frontend.login');
    }

    $user = Auth::guard('frontend')->user();

    if ($user->role_name !== 'etthnicoast_user') {
        Auth::guard('frontend')->logout();
        if ($request->expectsJson()) {
            return response()->json(['success' => false, 'redirect' => route('frontend.login')], 403);
        }
        return redirect()->route('frontend.login')->with('error', 'Access denied.');
    }

    return $next($request);

        return $next($request);
    }
}
