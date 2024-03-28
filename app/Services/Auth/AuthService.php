<?php

namespace App\Services\Auth;

use Illuminate\Http\{Request, Response};
use Illuminate\Support\Facades\{Auth};
use App\Models\{Log, User};
use Carbon\Carbon;

class AuthService
{
    private User $userModel;

    public function __construct(User $user) {
        $this->userModel = $user;
    }

    /**
     * login method.
     * 
     * @param Request $data
     * @return array
     */
    public function login(Request $data) : array {
        $array = [];
        
        if (Auth::attempt(array('email' => $data->email, 'password' => $data->password))) {
            $user = User::where('email', $data->email,)->first();

            if ($user === null) {
                $array = [
                    'success' => false,
                    'message' => 'Las credenciales suministradas son inválidas.',
                    'code' => Response::HTTP_NOT_FOUND
                ];
            }else{
                if ($user->status === 'A') {
                    $user->tokens()->delete();
                    
                    $token = $user->createToken($user->email . '-' . Carbon::now()->format('d/m/Y-H:i'));
        
                    $now = Carbon::now();
                    $expires_at = Carbon::parse($token->accessToken->expires_at);
                    $expires_in = $expires_at->diffInRealHours($now);
                    
                    $array = [
                        'message' => 'Inicio de sesión exitoso.',
                        'token' => $token->plainTextToken,
                        'success' => true,
                        'expiresIn' => $expires_in . " horas",
                        'code' => Response::HTTP_OK
                    ];
                    
                    Log::create([
                        'user_id' => $user->id,
                        'action' => 'Login',
                        'description' => 'Inicio de sesión',
                        'ip' => request()->getClientIp(),
                    ]);
                }else{
                    $array = [
                        'success' => false,
                        'message' => 'No estás habilitado para hacer inicio de sesión (INACTIVE).',
                        'code' => Response::HTTP_FORBIDDEN
                    ];
                }
            }
        }else{
            $array = [
                'success' => false,
                'message' => 'Las credenciales suministradas son inválidas.',
                'code' => Response::HTTP_BAD_REQUEST
            ];
        }
        return $array;
    }

    /**
     * logout method.
     * 
     * @return array
     */
    public function logout() {
        $id = auth()->id();
        $array = [];

        if (isset($id)) {
            $user = $this->userModel->find($id);
            $user->tokens()->delete();
            $user->remember_token = null;
            $user->update();

            $varENV = config('app.env');

            if ($varENV === 'local') {
                Log::create([
                    'user_id' => $user->id,
                    'action' => 'Logout',
                    'description' => 'Cierre de sesión',
                    'ip' => request()->getClientIp(),
                ]);
            }

            $array = [
                'success' => true,
                'message' => 'Logout exitoso.',
                'code' => Response::HTTP_OK
            ];
        }else{
            $array = [
                'success' => false,
                'message' => 'Error al hacer logout.',
                'code' => Response::HTTP_NOT_FOUND
            ];
        }

        return $array;
    }
}
