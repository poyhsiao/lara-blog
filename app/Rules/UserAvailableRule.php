<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

class UserAvailableRule implements ValidationRule
{
    protected $errorMessage = 'User not found';

    public function __construct(string $errorMessage)
    {
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
            if (!User::where('id', $value)->isValidated()) {
                $fail($this->errorMessage);
            }
        } catch (\Exception $e) {
            Log::error('User not found', [
                'id' => $value,
                'message' => $e->getMessage(),
            ]);
            $fail($this->errorMessage);
        }
    }
}
