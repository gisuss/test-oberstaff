<?php

namespace App\Repositories\Logs;

use App\Models\{Log};
use Illuminate\Support\Collection;
use Illuminate\Pagination\{LengthAwarePaginator, Paginator};
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

class LogsRepository extends \App\Repositories\Repository
{
    public function __construct(Log $model, array $relations = [])
    {
        parent::__construct($model, $relations);
    }

    public function indexLogs(Request $request)
    {
        $data = [];
        $logs = $this->model->orderBy('id', 'desc')->get();
        foreach ($logs as $log) {
            $data[] = [
                'id' => $log->id,
                'action' => $log->action,
                'description' => $log->description,
                'ip' => $log->ip,
                'user' => $log->user->name . ' ' . $log->user->last_name
            ];
        }

        $collection = collect($data);
        $lists = $this->pagination($collection, $request->perPage === null ? 15 : $request->perPage, $request->page === null ? 1 : $request->page);
        return $lists;
    }

    /**
     * Funcion para paginar collecciones
     */
    public function pagination(Collection $data, $perPage, $currentPage = null)
    {
        $items = $data->forPage($currentPage, $perPage);
        $totalResults = $data->count();
        $currentPage = $currentPage != null ? (Paginator::resolveCurrentPage() ?: 1) : 1;

        return new LengthAwarePaginator(
            $items,
            $totalResults,
            $perPage,
            $currentPage,
            [
                'path' => url()->current(),
                'pageName' => 'page',
            ]
        );
    }
}
