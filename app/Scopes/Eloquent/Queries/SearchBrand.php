<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use Illuminate\Database\Eloquent\Builder;

readonly class SearchBrand extends EloquentQueryScope
{
    public function __construct(
        private ?string $keywords = null,
    ) {}

    public function __invoke(Builder $query): void
    {
        $query->when($this->keywords, static function (Builder $query, string $value) {
            $value = '%'.$value.'%';

            $query->where('name', 'like', '%'.$value.'%');
        });
    }
}
