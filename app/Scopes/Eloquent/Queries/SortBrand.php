<?php

declare(strict_types=1);

namespace App\Scopes\Eloquent\Queries;

use App\Enums\Brand\Sort;
use Illuminate\Database\Eloquent\Builder;

readonly class SortBrand extends EloquentQueryScope
{
    public function __construct(
        private ?Sort $sort = Sort::ALPHABET,
    ) {}

    public function __invoke(Builder $query): void
    {
        match ($this->sort ?: Sort::ALPHABET) {
            Sort::NAME => $query->orderBy('name'),
            Sort::ALPHABET => $query->orderByRaw("name REGEXP '^[a-z]' DESC, name"),
        };
    }
}
