<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class ValidateLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|exists:users,email',
            'password' => 'required|string|min:8|max:16',
        ],[
            'email.required' => 'We need to know your email address!',
            'email.email' => 'The email address has an invalid format',
            'email.max' => 'The email address is too long',
            'email.exists' => 'The email address does not exist',
            'password.required' => 'The password is required',
            'password.min' => 'The password is too short (min 8)',
            'password.max' => 'The password is too long (max 16)',
        ]);
    
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $next($request);
    }
}
