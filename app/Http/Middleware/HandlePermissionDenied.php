<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Spatie\Permission\Exceptions\UnauthorizedException;

class HandlePermissionDenied
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        try {
            return $next($request);
        } catch (UnauthorizedException $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'You do not have the required permissions to access this resource.',
                ], Response::HTTP_FORBIDDEN);
            }

            // Log the unauthorized access attempt
            \Log::warning('Permission denied', [
                'user' => Auth::user() ? Auth::user()->id : 'guest',
                'url' => $request->url(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            // Redirect to custom 403 page
            return response()->view('errors.403', [
                'exception' => $e,
            ], Response::HTTP_FORBIDDEN);
        }
    }
}
