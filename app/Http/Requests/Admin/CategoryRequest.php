<?php

declare(strict_types=1);

namespace App\Http\Requests\Admin;

use App\Http\Controllers\Admin\CategoryController;
use App\Models\Category;
use App\Services\Media\Storage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\File;
use Override;

class CategoryRequest extends FormRequest
{
    #[Override]
    protected function getRedirectUrl(): string
    {
        /** @phpstan-ignore-next-line */
        return match ($this->route()->hasParameter('category')) {
            true => action([CategoryController::class, 'edit'], $this->route('category')),
            false => action([CategoryController::class, 'create']),
        };
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        /** @var Category|null $category */
        $category = $this->route('category');

        return [
            'name' => ['required', 'string', 'min:3', 'max:225'],
            'meta_title' => ['required', 'string', 'min:3', 'max:225'],
            'meta_description' => ['nullable', 'string', 'min:3', 'max:225'],
            'description' => ['nullable', 'string', 'min:3', 'max:65000'],
            'url' => ['required', 'string', 'min:3', 'max:225'],
            'sort' => ['integer', 'min:0', 'max:4000000'],
            'active' => ['boolean'],
            'parent_id' => [
                'nullable',
                'uuid:7',
                'exists:categories,id',
                Rule::notIn([$category?->id]),
            ],
            'deleted_image' => ['boolean'],
            'dropped_image' => [
                File::types(Storage::ALLOWED_IMAGE_EXTENSIONS)
                    ->min(1)
                    ->max(2 * 1024),
            ],
        ];
    }

    public function parentId(): ?string
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('parent_id');
    }

    public function droppedImage(): ?UploadedFile
    {
        /** @phpstan-ignore-next-line */
        return $this->validated('dropped_image');
    }

    public function deleteImage(): bool
    {
        return (bool) $this->validated('deleted_image');
    }
}
