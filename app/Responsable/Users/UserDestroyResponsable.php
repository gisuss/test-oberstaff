<?php

namespace App\Responsable\Users;

use Illuminate\Contracts\Support\Responsable;
use App\Models\User;
use Illuminate\Support\Facades\{DB};
use Illuminate\Http\Response;
use App\Repositories\Users\UserRepository;

class UserDestroyResponsable implements Responsable
{
    private string $search;
	private UserRepository $repository;

    public function __construct(string $search, UserRepository $repository = null) {
		$this->repository = ($repository === null) ? new UserRepository(new User()) : $repository;
        $this->search = $search;
    }

    public function toResponse($request) {
        try {
            DB::beginTransaction();
                $res = $this->repository->eliminarUser($this->search, $request);
            DB::commit();
            
			return response()->json([
                'message' => $res ? 'Customer eliminado con éxito.' : 'Registro no existe',
                'success' => $res,
                'code' => $res ? Response::HTTP_OK : Response::HTTP_NOT_FOUND
            ]);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}