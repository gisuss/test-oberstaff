<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use App\Helpers\StandardResponse;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\{Request, Response};

class UserStoreResponsable implements Responsable
{
    use StandardResponse;
    private UserRepository $repository;
    private Request $data;

    public function __construct(UserRepository $repository = null, Request $request) {
        $this->repository = ($repository === null) ? new UserRepository(new User()) : $repository;
        $this->data = $request;
    }

    public function toResponse($request) {
        try {
            DB::beginTransaction();
                $customer = $this->repository->register($this->data);
            DB::commit();
            return $this->storeResponse(CustomerResource::make($customer), isset($customer) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'No se pudo registrar el customer.',
                'data' => $e->getMessage(),
                'success' => false,
                'code' =>  Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}