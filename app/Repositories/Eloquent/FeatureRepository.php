<?php

declare(strict_types=1);

namespace App\Repositories\Eloquent;

use App\Models\Feature;
use App\Scopes\Eloquent\Queries\FilterFeature;
use App\Scopes\Eloquent\Queries\FilterOption;
use Illuminate\Support\Collection;

class FeatureRepository
{
    /**
     * @return Collection<int, Feature>
     */
    public function featureFilterOptionsForCategory(string $categoryId): Collection
    {
        return Feature::query()
            ->tap(FilterFeature::inFilter()->asTap())
            ->tap(FilterFeature::byCategory($categoryId)->asTap())
            ->withWhereHas('options', static fn ($query) => $query
                ->tap(FilterOption::byCategory($categoryId)->asTap())
                ->select(['feature_id', 'value'])
                ->distinct(),
            )
            ->get();
    }
}
