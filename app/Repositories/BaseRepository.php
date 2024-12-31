<?php

namespace App\Repositories;

use App\Helper\QueryHelper;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection as SupportCollection;

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
     * @return array
     */
    protected function paginateModel(Request $request, Model $model, string $keyName): array
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

        return QueryHelper::easyPaginate($paginator, $keyName, true, []);
    }

    /**
     * Generate a pagination from a collection
     *
     * @param  Request  $request
     * @param  Collection|SupportCollection  $collection
     * @param  string  $keyName
     * @return array
     */
    protected function paginateCollect(Request $request, Collection|SupportCollection $collection, string $keyName): array
    {
        $currentPage = (int) $request->input('page', 1);

        $perPage = (int) $request->input('limit', 15);

        $total = $collection->count();

        $offset = ($currentPage - 1) * $perPage;

        $itemsForPage = $collection->slice($offset, $perPage)->values();

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

        return QueryHelper::easyPaginate($paginator, $keyName, true, []);
    }

    /**
     * Generate a pagination from an array
     *
     * @param  Request  $request
     * @param  array  $items
     * @param  string  $keyName
     * @return array
     */
    protected function paginateArray(Request $request, array $items, string $keyName): array
    {
        $currentPage = (int) $request->input('page', 1);

        $perPage = (int) $request->input('limit', 15);

        $total = count($items);

        $offset = ($currentPage - 1) * $perPage;

        $itemsForPage = array_slice($items, $offset, $perPage);

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

        return QueryHelper::easyPaginate($paginator, $keyName);
    }
}
