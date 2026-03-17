<?php

declare(strict_types=1);

namespace App\Models;

use Closure;
use Database\Factories\ProductFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Override;
use Str;

/**
 * @property string|null $brand_id
 * @property array<int,string> $images
 */
class Product extends Model
{
    /** @use HasFactory<ProductFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'url',
        'name',
        'annotation',
        'description',
        'active',
        'meta_title',
        'meta_description',
        'featured',
    ];

    protected $attributes = [
        'images' => '[]',
        'active' => true,
    ];

    protected $casts = [
        'active' => 'bool',
        'featured' => 'bool',
        'sort' => 'float',
        'images' => 'array',
    ];

    #[Override]
    protected static function booted()
    {
        //
    }

    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */
    /**
     * @return Attribute<string|null, never>
     */
    protected function image(): Attribute
    {
        return Attribute::get(static function (mixed $value, array $attributes) {
            /** @var string $images */
            $images = $attributes['images'] ?? '';

            $decoded = json_decode($images, true);
            if (! is_array($decoded) || $decoded === []) {
                return null;
            }

            $first = reset($decoded);

            return is_string($first) ? $first : null;
        });
    }

    /**
     * @return Attribute<float|null, never>
     */
    protected function price(): Attribute
    {
        $price = $this->variant?->price;

        return Attribute::get(static fn () => $price);
    }

    /**
     * @return Attribute<float|null, never>
     */
    protected function oldPrice(): Attribute
    {
        $oldPrice = $this->variant?->old_price;

        return Attribute::get(static fn () => $oldPrice);
    }

    /**
     * @return Attribute<string|null, never>
     */
    protected function categoryId(): Attribute
    {
        $categoryId = $this
            ->categories
            ->sortBy(
                /** @phpstan-ignore-next-line  */
                static fn ($category) => $category?->pivot->sort)
            ->first()?->id;

        return Attribute::get(static fn () => $categoryId);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsToMany<Product, $this>
     */
    public function related(): BelongsToMany
    {
        return $this->belongsToMany(
            related: self::class,
            table: 'product_related',
            foreignPivotKey: 'product_id',
            relatedPivotKey: 'related_id',
        );
    }

    /**
     * @return HasMany<Variant, $this>
     */
    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class)->orderBy('sort');
    }

    /**
     * @return HasOne<Variant, $this>
     */
    public function variant(): HasOne
    {
        return $this->variants()->one();
    }

    /**
     * @return HasMany<Option, $this>
     */
    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }

    /**
     * @return BelongsTo<Brand, $this>
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * @return BelongsToMany<Category, $this>
     */
    public function categories(): BelongsToMany
    {
        return $this
            ->belongsToMany(Category::class)
            ->withPivot('sort')
            ->orderBy('pivot_sort');
    }

    /*
    |--------------------------------------------------------------------------
    | OPERATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateVariant(string $variantId, array $attributes): void
    {
        $this->variants()->findOrFail($variantId)->update($attributes);

        $this->touch();
    }

    public function assignBrand(?string $brandId): void
    {
        $this->brand_id = $brandId;

        $this->save();
    }

    /**
     * @param  array<int, string>  $related  id's
     */
    public function syncRelated(array $related): void
    {
        $sync = [];
        foreach ($related as $index => $id) {
            $sync[$id] = ['sort' => $index + 1];
        }

        $this->related()->sync($sync);

        $this->touch();
    }

    public function attachRelated(string $id): void
    {
        $this->related()->attach($id);
    }

    /**
     * @param  array<int,array{
     *  sku:string,
     *  name:string|null,
     *  price:float,
     *  old_price:float|null,
     *  stock:int|null}>  $variants
     */
    public function saveVariants(array $variants): void
    {
        foreach ($variants as $index => &$variant) {
            $variant['sort'] = $index + 1;
        }

        $this->variants()->saveMany(array_map(
            fn (array $item) => new Variant($item),
            $variants,
        ));

        $this->touch();
    }

    /**
     * @param  array<string,array{value:string}>  $options  Key - is feature id, Value - array is data of pivot table options
     */
    public function saveOptions(array $options): void
    {
        $this->options()->createMany($options);

        $this->touch();
    }

    /**
     * @param  array<int,array{
     *  feature_id:string,
     *  value:string}>  $options
     */
    public function syncOptions(array $options): void
    {
        // Filter if option without values
        $options = array_filter($options, fn (array $item) => ! empty($item['value']));

        $values = array_map(fn (array $variant) => [
            'product_id' => $this->id,
            'feature_id' => $variant['feature_id'],
            'value' => $variant['value'],
        ], $options);

        $this->options()->upsert(
            values: $values,
            uniqueBy: ['product_id', 'feature_id'],
            update: [
                'value',
            ],
        );

        /** @var array<int,string> $optionValues */
        $optionValues = array_column($options, 'value');
        $this
            ->options()
            ->whereNotIn('value', $optionValues)
            ->delete();

        $this->touch();
    }

    /**
     * @param  array<int,array{
     *  sku:string,
     *  name:string|null,
     *  price:float,
     *  old_price:float|null,
     *  stock:int|null,
     *  sort:int|null}>  $variants
     */
    public function syncVariants(array $variants): void
    {
        $skus = array_column($variants, 'sku');

        // Delete removed variants (fires events)
        $this
            ->variants()
            ->whereNotIn('sku', $skus)
            ->get()
            ->each
            ->delete();

        foreach ($variants as $variant) {
            $model = $this
                ->variants()
                ->where('sku', $variant['sku'])
                ->first();

            if (! $model) {
                // Create new variant (fires creating/created)
                $model = $this->variants()->make([
                    'sku' => $variant['sku'],
                ]);
            }

            // Update fields (fires saving/updating/updated)
            $model->fill([
                'name' => $variant['name'] ?? null,
                'price' => $variant['price'],
                'old_price' => $variant['old_price'] ?? null,
                'stock' => $variant['stock'] ?? null,
                'sort' => $variant['sort'] ?? 0,
            ]);

            $model->save(); // ← events fire here
        }

        $this->touch();
    }

    /**
     * @param  array<int, string>  $paths
     */
    public function putImages(array $paths): void
    {
        $this->images = [...$this->images, ...$paths];

        $this->save();
    }

    /**
     * @param  array<int,string>  $deletePaths
     */
    public function deleteImages(array $deletePaths): void
    {
        $paths = array_diff($this->images, $deletePaths);

        $this->images = $paths;

        $this->save();
    }

    /**
     * @param  Closure(Product $replica):void|null  $success
     */
    public function duplicate(?Closure $success = null): void
    {
        $copy = $this->replicate();

        $copy->name = $this->name.' (Copy)';
        $copy->url = $this->url.'-'.Str::random(5);
        $copy->featured = false;
        $copy->active = false;
        $copy->images = [];

        $copy->save();

        $copy->categories()->sync($this->categories->pluck('id')->all());

        $copy->related()->sync(
            $this->related->pluck('id')->all(),
        );

        foreach ($this->options as $option) {
            $copy->options()->create([
                'feature_id' => $option->feature_id,
                'value' => $option->value,
            ]);
        }

        foreach ($this->variants as $variant) {
            $newVariant = $variant->replicate();
            $newVariant->product_id = $copy->id;
            $newVariant->sku = $variant->sku.' (Copy)';
            $newVariant->save();
        }

        if ($success) {
            $success($copy);
        }
    }
}
