<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class IdAvailable implements ValidationRule
{
    protected $table;

    protected $column;

    protected $errorMessage;

    public function __construct($table, $column, $errorMessage)
    {
        $this->table = $table;
        $this->column = $column;
        $this->errorMessage = $errorMessage;
    }

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        try {
            $value = (int) $value;

            $exists = DB::table($this->table)
                ->where($this->column, $value)
                ->where('deleted_at', null)
                ->exists();

            if (!$exists) {
                $fail($this->errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('IdAvailable validation', [
                'table' => $this->table,
                'column' => $this->column,
                'value' => $value,
                'message' => $e->getMessage(),
            ]);
            $fail($this->errorMessage);
        }
    }
}
