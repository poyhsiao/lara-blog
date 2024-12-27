<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

abstract class BaseRepository
{
    protected $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    protected function getModel(): Model
    {
        return $this->model;
    }

    /**
     * Generate a pagination
     *
     * @param  Request  $request
     * @param  Model  $model
     * @return LengthAwarePaginator
     */
    protected function paginate(Request $request, Model $model): LengthAwarePaginator
    {
        $items = $model::all();

        $currentPage = (int) $request->input('page', 1);

        $perPage = (int) $request->input('limit', 15);

        $total = $items->count();

        $offset = ($currentPage - 1) * $perPage;

        $itemsForPage = $items->slice($offset, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $itemsForPage,
            $total,
            $perPage,
            $currentPage,
            [
                'path' => $request->url(),
                'query' => $request->query(),
            ],
        );

        return $paginator;
    }
}
