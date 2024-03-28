<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Response;

trait StandardResponse
{
    /**
     *
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    public function indexResponse(JsonResource $resource, int $code = Response::HTTP_OK) : JsonResponse
    {
        return $this->jsonStructure($this->buildMessage(), $resource, $code);
    }

    /**
     *
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    public function indexResponseWithMetas(JsonResource $resource, int $code = Response::HTTP_OK) : JsonResponse
    {
        return $this-> jsonStructureWithMetas($this->buildMessage(), $resource, $code);
    }

    /**
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    public function showResponse(JsonResource $resource, int $code = Response::HTTP_OK) : JsonResponse
    {
        return $this->jsonStructure($this->buildMessage(), $resource, $code);
    }

    /**
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    public function storeResponse(JsonResource $resource, int $code = Response::HTTP_CREATED) : JsonResponse
    {

        return $this->jsonStructure($this->buildMessage('store'), $resource, $code);
    }

    /**
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    public function updateResponse(JsonResource $resource, int $code = Response::HTTP_OK) : JsonResponse
    {
        return $this->jsonStructure($this->buildMessage(), $resource, $code);
    }

    /**
     * @param int $code
     * @return JsonResponse
     */
    public function destroyResponse(int $code = Response::HTTP_OK) : JsonResponse
    {
        return $this->jsonStructure($this->buildMessage('delete'), null, $code);
    }

    /**
     * @param string $verb
     * @return string
     */
    private function buildMessage(string $verb = 'index') : string
    {
        $verbText = '';
        switch ($verb) {
            case 'index':
                $verbText = 'obtenido';
                break;
            case 'update':
                $verbText = 'actualizado';
                break;
            case 'delete':
                $verbText = 'eliminado';
                break;
            case 'store':
                $verbText = 'creado';
                break;
        }

        return 'Recurso '.$verbText.' con éxito!';
    }

    /**
     * @param string $message
     * @param ?JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    private function jsonStructure(
        string $message,
        ?JsonResource $resource,
        int $code
    ) : JsonResponse
    {
        $response = [
            'message' => $message,
            'data' => $resource,
            'success' => ($code === 200) ? true : false,
            'code' => $code,
        ];

        if (request()->has('page')) {
            $response['meta'] = (object)[
                'total'        => $resource->total(),
                'count'        => $resource->count(),
                'lastItem'     => $resource->lastItem(),
                'lastPage'     => $resource->lastPage(),
                'firstItem'    => $resource->firstItem(),
                'currentPage'  => $resource->currentPage(),
                'itemsPerPage' => $resource->perPage(),
                'hasMorePages' => $resource->hasMorePages(),
            ];
        }

        return response()->json($response, $code);
    }

    public function minimalJsonStructure(?JsonResource $resource) {
        $response = [
            'data' => $resource,
        ];

        if (request()->has('page')) {
            $response['meta'] = (object)[
                'total'        => $resource->total(),
                'count'        => $resource->count(),
                'lastItem'     => $resource->lastItem(),
                'lastPage'     => $resource->lastPage(),
                'firstItem'    => $resource->firstItem(),
                'currentPage'  => $resource->currentPage(),
                'itemsPerPage' => $resource->perPage(),
                'hasMorePages' => $resource->hasMorePages(),
            ];
        }

        return $response;
    }

    /**
     * @param string $message
     * @param JsonResource $resource
     * @param int $code
     * @return JsonResponse
     */
    private function jsonStructureWithMetas(
        string $message,
        JsonResource $resource,
        int $code
    ) : JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $resource->resource ?? null,
            'code' => $code
        ], $code);
    }
}
