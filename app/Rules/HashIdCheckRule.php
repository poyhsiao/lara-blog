<?php

namespace App\Rules;

use App\Foundation\Helper\HashidTools;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;
use Throwable;

class HashIdCheckRule implements ValidationRule
{
    protected $type;

    protected $errorMessage;

    protected $hashIds;

    public function __construct(string $connection, string $type, string $errorMessage)
    {
        $hashIds = new HashidTools();

        $this->type = $type;
        $this->errorMessage = $errorMessage;
        $this->hashIds = $hashIds->connection($connection);
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $id = $this->hashIds->decode($value);

            if (!$id || !count($id)) {
                $fail($this->errorMessage);
            }

            if ('user' === $this->type && !$this->checkUserId($id[0])) {
                $fail($this->errorMessage);
            }
        } catch (Throwable $e) {
            Log::error('HashIdCheckRule validation', [
                'type' => $this->type,
                'hash' => $value,
                'error' => $e->getMessage(),
            ]);
            $fail($this->errorMessage);
        }
    }

    private function checkUserId(int $id): bool
    {
        return (bool)User::findOrFail($id);
    }
}
