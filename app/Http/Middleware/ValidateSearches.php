<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ValidateSearches
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $authUser = Auth::user();

        if ($authUser->status <> 'A') {
            return response()->json([
                'message' => 'No estás habilitado para hacer uso de esta API',
                'success' => false,
                'code' =>  Response::HTTP_FORBIDDEN,
            ], Response::HTTP_FORBIDDEN);
        }

        return $next($request);
    }
}
