<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\DB;

class ExistInDb implements ValidationRule
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
    public function validate(string $attribute, mixed $values, Closure $fail): void
    {
        if (is_string($values)) {
            $values = explode(',', $values);
        }

        $count = DB::table($this->table)
            ->whereIn($this->column, $values)
            ->where('deleted_at', null)
            ->count();

        if (count($values) !== $count) {
            $fail($this->errorMessage);
        }
    }
}
