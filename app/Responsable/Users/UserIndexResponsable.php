<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\User;
use App\Repositories\Users\UserRepository;
use App\Helpers\StandardResponse;
use App\Http\Resources\CustomerShowResource;

class UserIndexResponsable implements Responsable
{
    use StandardResponse;
    protected UserRepository $repository;

    public function __construct(UserRepository $repository = null) {
        $this->repository = $repository ?? new UserRepository(new User());
    }

    public function toResponse($request) {
        $users = $this->repository->paginate(null, request()->has('limit') ? request('limit') : 20, $request->filters);
        return $this->indexResponse(CustomerShowResource::collection($users));
    }
}
