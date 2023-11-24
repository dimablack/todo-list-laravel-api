<?php

namespace App\Rules;

use App\Models\Task;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Translation\PotentiallyTranslatedString;

class ParentIdCanBeAssign implements ValidationRule
{
    public function __construct(protected Task $task)
    {
    }

    /**
     * Run the validation rule.
     *
     * @param Closure(string): PotentiallyTranslatedString $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($this->task->checkIfParentAreInChildren($value)) {
            $fail(__('api.message.deny.parent_id.exists'));
        }
    }
}
