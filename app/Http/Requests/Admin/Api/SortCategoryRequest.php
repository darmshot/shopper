<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin\Api;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @phpstan-type SortItem array{id:string, parent_id:string|null, sort:int}
 * @phpstan-type SortItems array<string, SortItem>
 */
class SortCategoryRequest extends FormRequest
{
    /**
     * @var SortItems
     */
    private array $items;

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'items' => ['required', 'array'],
            'items.*.id' => ['required', 'uuid:7'],
            'items.*.parent_id' => ['nullable', 'uuid:7'],
            'items.*.sort' => ['integer', 'min:0', 'max:1000'],
        ];
    }

    /**
     * @return SortItems
     */
    public function items(): array
    {
        $items = $this->validated('items');

        /** @phpstan-ignore-next-line */
        return $this->items ??= array_combine(array_column($items, 'id'), $items);
    }

    /**
     * @return array<int,string>
     */
    public function getItemIds(): array
    {
        return array_keys($this->items());
    }

    /**
     * @return SortItem|null
     */
    public function getItem(string $id): ?array
    {
        return $this->items()[$id] ?? null;
    }
}
