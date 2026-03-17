<?php

declare(strict_types=1);

namespace App\Support\FormRequest\Concerns;

use Illuminate\Contracts\Validation\ValidationRule;

trait HasChecked
{
    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    protected function checkedRules(): array
    {
        return [
            'checked' => 'required|array',
            'checked.*' => 'required|uuid:7',
        ];
    }

    /**
     * @return array<int,string>
     */
    public function checked(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('checked');
    }
}
