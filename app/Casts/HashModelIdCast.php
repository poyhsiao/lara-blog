<?php

namespace App\Casts;

use App\Foundation\Helper\HashidTools;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;

class HashModelIdCast implements CastsAttributes
{
    protected $hashidTools;

    public function __construct(string $connection = 'alternative')
    {
        $hashidTools = new HashidTools();
        $this->hashidTools = $hashidTools->connection($connection);
    }

    /**
     * Cast the given value.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function get(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->hashidTools->encode($value) ?? null;
    }

    /**
     * Prepare the given value for storage.
     *
     * @param  array<string, mixed>  $attributes
     */
    public function set(Model $model, string $key, mixed $value, array $attributes): mixed
    {
        return $this->hashidTools->decode($value) ?? null;
    }
}
