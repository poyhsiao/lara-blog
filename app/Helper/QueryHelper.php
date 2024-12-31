<?php

namespace App\Helper;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class QueryHelper
{
    /**
     * Make pagination response easier
     *
     * @param  Paginator|LengthAwarePaginator  $paginator
     * @param  string  $keyName
     * @param  bool  $detail
     * @param  array  $hidden
     * @return array
     */
    public static function easyPaginate(Paginator|LengthAwarePaginator $paginator, string $keyName = 'data', bool $detail = false, ?array $hidden = null): array
    {
        $items = collect($paginator->items())
          ->each(function ($item) use ($detail, $hidden) {
              return $detail ? $item->setHidden($hidden) : $item;
          })
          ->toArray();

        return [
            'meta' => [
                'current_page' => $paginator->currentPage(),
                'total' => $paginator->total(),
                'items_per_page' => $paginator->perPage(),
                'last_page' => $paginator->lastPage(),
                'next_page_url' => $paginator->nextPageUrl(),
                'prev_page_url' => $paginator->previousPageUrl(),
                'last_page_url' => $paginator->url($paginator->lastPage()),
                'options' => $paginator->getOptions(),
            ],
            $keyName => $items,
        ];
    }
}
