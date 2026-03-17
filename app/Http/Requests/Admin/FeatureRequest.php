<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Http\Controllers\Admin\FeatureController;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Override;

class FeatureRequest extends FormRequest
{
    #[Override]
    protected function getRedirectUrl(): string
    {
        /** @phpstan-ignore-next-line */
        return match ($this->route()->hasParameter('feature')) {
            true => action([FeatureController::class, 'edit'], $this->route('feature')),
            false => action([FeatureController::class, 'create']),
        };
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:225'],
            'sort' => ['integer', 'min:0', 'max:4000000'],
            'in_filter' => ['boolean'],
            'categories' => ['array', 'min:1'],
            'categories.*' => ['required', 'uuid:7', 'exists:categories,id'],
        ];
    }

    /**
     * @return array<int,string>
     */
    public function categories(): array
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('categories', []);
    }
}
