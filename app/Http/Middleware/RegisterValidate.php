<?php

namespace App\Http\Middleware;

use App\Models\Commune;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class RegisterValidate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:16',
            'name' => 'required|string|min:2|max:45|regex:/^[a-zA-ZáéíóúüñÑ]+$/',
            'last_name' => 'required|string|min:2|max:45|regex:/^[a-zA-ZáéíóúüñÑ]+$/',
            'dni' => 'required|string|max:45|regex:/^[0-9]+$/',
            'address' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9\s\p{L}\p{P}\p{S}\p{Z}]+$/u',
            'id_reg' => 'required|numeric|exists:regions,id',
            'id_com' => 'required|numeric|exists:communes,id',
        ],[
            'email.required' => 'We need to know your email address!',
            'email.email' => 'The email address has an invalid format',
            'email.max' => 'The email address is too long',
            'email.unique' => 'The email address must be unique',
            'password.required' => 'The password is required',
            'password.min' => 'The password is too short (min 8)',
            'password.max' => 'The password is too long (max 16)',
            'name.required' => 'The name is required',
            'name.regex' => 'The name only allows letters.',
            'name.min' => 'The name is too short (min 2)',
            'name.max' => 'The name is too long (max 45)',
            'last_name.required' => 'The last name is required',
            'last_name.regex' => 'The last name only allows letters.',
            'last_name.min' => 'The last name is too short (min 2)',
            'last_name.max' => 'The last name is too long (max 45)',
            'dni.required' => 'The dni number is required',
            'dni.regex' => 'The dni only allows numbers.',
            'dni.max' => 'The dni number is too long (max 45)',
            'address.max' => 'The address is too long (max 255)',
            'address.regex' => 'The address only allows letters, numbers, white spaces and special characters',
            'id_reg.required' => 'The región is required',
            'id_reg.numeric' => 'The región must be numeric',
            'id_reg.exists' => 'The región does not exists',
            'id_com.required' => 'The communa is required',
            'id_com.numeric' => 'The communa must be numeric',
            'id_com.exists' => 'The communa does not exists',
        ]);

        $validator->after(function ($validator) use($request) {
            $commune = Commune::find($request->id_com);
            $communeRegions = $commune->region;

            if ($communeRegions->id <> $request->id_reg) {
                $validator->errors()->add(
                    'id_com', 'La comuna no está relacionada con la region suministrada'
                );
            }
        });
    
        if ($validator->fails()) {
            throw new ValidationException($validator);
        }

        return $next($request);
    }
}
