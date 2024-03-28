<?php

namespace App\Http\Middleware;

use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{DB, Auth};

class SanctumAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        $bool = false;
        $token = $request->bearerToken();
        
        if (!$token) {
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }else{
            $firstChar = substr($token, 0, 1);
            $number = (int) $firstChar;
            $t = DB::table('personal_access_tokens')->where('id', $number)->first();

            if (isset($t)) {
                $authUser = User::where('id', $t->tokenable_id)->first();
            }else{
                return response()->json([
                    'message' => 'Token no válido',
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                ], Response::HTTP_UNAUTHORIZED);
            }
        }

        if (isset($authUser)) {
            if ($authUser->status === 'A') {
                $tokenDB = DB::table('personal_access_tokens')->where('tokenable_id', $authUser->id)->first();
                
                if (isset($tokenDB)) {
                    $difference = Carbon::now()->diffInSeconds($tokenDB->created_at);
                    if ($difference <= 86400) {
                        $bool = true;
                    }
                }
            }else{
                return response()->json([
                    'message' => 'Unauthorized',
                    'success' => false,
                    'code' => Response::HTTP_UNAUTHORIZED,
                ], Response::HTTP_UNAUTHORIZED);
            }
        }else{
            return response()->json([
                'message' => 'Unauthorized',
                'success' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        if (!$bool) {
            return response()->json([
                'message' => 'Token expirado',
                'success' => false,
                'code' => Response::HTTP_UNAUTHORIZED,
            ], Response::HTTP_UNAUTHORIZED);
        }
        
        return $next($request);
    }
}
