<?php

namespace App\Responsable\Logs;

use Illuminate\Contracts\Support\Responsable;
use App\Models\{Log};
use App\Repositories\Logs\LogsRepository;
use Illuminate\Http\Response;
use App\Helpers\StandardResponse;
use App\Http\Resources\LogResource;

class LogsIndexResponsable implements Responsable
{
    use StandardResponse;
    protected LogsRepository $repository;

    public function __construct(LogsRepository $repository = null)
    {
        $this->repository = $repository ?? new LogsRepository(new Log());
    }

    public function toResponse($request)
    {
        try {
            $data = $this->repository->indexLogs($request);
            return $this->indexResponse(LogResource::collection($data), isset($data) ? Response::HTTP_OK : Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Falló al cargar la lista de logs.',
                'data' => $th->getMessage(),
                'success' => false,
                'code' =>  Response::HTTP_INTERNAL_SERVER_ERROR,
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
