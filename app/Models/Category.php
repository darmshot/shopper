<?php

declare(strict_types=1);

namespace App\Models;

use App\Contracts\Repositories\CategoryRepository;
use App\Exceptions\CategoryException;
use App\Services\Tree\Data\Nodeable;
use App\Services\Tree\Data\NodeableTrait;
use App\Support\Eloquent\Attributes\UseRepository;
use App\Support\Eloquent\Concerns\HasRepository;
use Database\Factories\CategoryFactory;
use Exception;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Override;

/**
 * @property string $id
 * @property string|null $parent_id
 * @property string|null $image
 */
#[UseRepository(CategoryRepository::class)]
class Category extends Model implements Nodeable
{
    /** @use HasFactory<CategoryFactory> */
    use HasFactory;

    /** @use HasRepository<CategoryRepository> */
    use HasRepository;

    use HasUuids;
    use NodeableTrait;

    protected $fillable = [
        'name',
        'meta_title',
        'meta_description',
        'description',
        'url',
        'sort',
        'active',
    ];

    protected $casts = [
        'sort' => 'int',
        'active' => 'bool',
    ];

    protected $attributes = [
        'active' => true,
    ];

    /**
     * All the relationships to be touched.
     *
     * @var array<int,string>
     */
    protected $touches = ['parent'];

    #[Override]
    protected static function booted(): void
    {
        static::saving(static function (self $category) {
            if ($category->id && $category->parent_id == $category->id) {
                throw new Exception('Category cannot be its own parent.');
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /**
     * @return BelongsTo<self, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(self::class, 'parent_id');
    }

    /**
     * @return HasMany<self, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(self::class, foreignKey: 'parent_id', localKey: 'id');
    }

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    /*
    |--------------------------------------------------------------------------
    | OPERATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @param  array<string,mixed>  $attributes
     */
    public function attachProduct(string $productId, array $attributes = []): void
    {
        $this->products()->attach($productId, $attributes);
        $this->touch();
    }

    public function detachProduct(string $productId): void
    {
        $this->products()->detach($productId);
        $this->touch();
    }

    /**
     * @throws CategoryException
     */
    public function assignParent(?string $parentId): void
    {
        if ($parentId === $this->id) {
            throw CategoryException::selfParentId($this->id);
        }

        $this->parent_id = $parentId;

        $this->save();
    }

    public function putImage(string $path): void
    {
        $this->image = $path;

        $this->save();
    }

    public function deleteImage(): void
    {
        if (empty($this->image)) {
            return;
        }

        $this->image = null;

        $this->save();
    }
}
