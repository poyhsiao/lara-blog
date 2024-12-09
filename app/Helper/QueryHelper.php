<?php

namespace App\Helper;

class QueryHelper
{
  public static function easyPaginate($paginator, string $keyName = 'data', bool $detail = false, array $hidden = ['password', 'remember_token']): array {

    $items = collect($paginator->items())
      ->each(function ($item) use ($detail, $hidden) {
        return ($detail) ? $item->setHidden($hidden) : $item;
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