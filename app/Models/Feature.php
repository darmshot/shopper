<?php

declare(strict_types=1);

namespace App\Models;

use App\Repositories\Eloquent\FeatureRepository;
use App\Support\Eloquent\Attributes\UseRepository;
use App\Support\Eloquent\Concerns\HasRepository;
use Database\Factories\FeatureFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[UseRepository(FeatureRepository::class)]
class Feature extends Model
{
    /** @use HasFactory<FeatureFactory> */
    use HasFactory;

    /** @use HasRepository<FeatureRepository> */
    use HasRepository;

    use HasUuids;

    protected $fillable = [
        'name',
        'sort',
        'in_filter',
    ];

    protected $casts = [
        'sort' => 'int',
        'in_filter' => 'bool',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_feature');
    }

    /**
     * @return HasMany<Option, $this>
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /*
    |--------------------------------------------------------------------------
    | OPERATIONS
    |--------------------------------------------------------------------------
    */

    public function attachCategory(string $categoryId): void
    {
        $this->categories()->attach($categoryId);
    }

    /**
     * @param  array<int,string>  $categories  uuid's
     */
    public function syncCategories(array $categories): void
    {
        $this->categories()->sync($categories);
    }
}
