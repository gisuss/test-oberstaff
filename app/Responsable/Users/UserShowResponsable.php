<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\{User};
use Illuminate\Http\Response;
use App\Helpers\StandardResponse;
use App\Http\Resources\CustomerShowResource;
use App\Repositories\Users\UserRepository;

class UserShowResponsable implements Responsable
{
    use StandardResponse;
    protected string $search;
    protected UserRepository $repository;

    public function __construct(string $search, UserRepository $repository = null) {
        $this->repository = $repository ?? new UserRepository(new User());
        $this->search = $search;
    }

    public function toResponse($request) {
        $customer = $this->repository->search($this->search);
        
        if (isset($customer)) {
            return $this->showResponse(CustomerShowResource::make($customer), isset($customer) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        }else{
            return response()->json([
                'message' => 'Registro no existe',
                'success' => false,
                'code' => Response::HTTP_NOT_FOUND
            ], Response::HTTP_NOT_FOUND);
        }
    }
}