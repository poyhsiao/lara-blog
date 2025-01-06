<?php

namespace App\Validators;

use App\Foundation\Helper\HashidTools;
use Illuminate\Database\Eloquent\Model;

abstract class BaseValidator
{
    protected $model;

    protected $hashConnection;

    protected const INVALID_DATA_ERROR = 'invalid data';

    protected const NOT_AUTHORIZED_ERROR = 'You are note authorized to perform this action';

    protected const UPDATE_FAILED_ERROR = 'Update failed';

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function getModel(): Model
    {
        return $this->model;
    }

    public function getHashConnection(): ?string
    {
        return $this->hashConnection;
    }

    protected function setHashConnection(string $connection = 'alternative'): void
    {
        $this->hashConnection = $connection;
    }

    /**
     * Decodes a hash id back to the original integer value.
     *
     * @param string $hash The hash to decode.
     * @param string|null $connection The hash connection to use. If null, the
     *     value stored in $this->hashConnection is used. If that is also null, the
     *     "alternative" connection is used.
     *
     * @return int|null The decoded id, or null if the hash could not be decoded.
     */
    protected function hashToId(string $hash, ?string $connection = null): ?int
    {
        $connectionName = $connection ?? $this->getHashConnection();

        if (!$connectionName) {
            $connectionName = 'alternative';
        }

        $hashids = (new HashidTools())->connection($connectionName);

        $decoded = $hashids->decode($hash);

        return $decoded ? $decoded[0] : null;
    }
}
