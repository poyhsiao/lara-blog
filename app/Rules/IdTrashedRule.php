<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class IdTrashedRule implements ValidationRule
{
    protected $table;

    protected $column;

    protected $errorMessage;

    public function __construct(string $table, string $column, string $errorMessage)
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
        $result = DB::table($this->table)
            ->where($this->column, $value)
            ->whereNot('deleted_at', null)
            ->count();

        if ($result < 1) {
            $fail($this->errorMessage);
        }
    }
}
