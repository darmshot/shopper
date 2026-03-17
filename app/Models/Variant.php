<?php

declare(strict_types=1);

namespace App\Models;

use App\Exceptions\VariantException;
use Database\Factories\VariantFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Override;

class Variant extends Model
{
    /** @use HasFactory<VariantFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'sku',
        'name',
        'price',
        'old_price',
        'stock',
        'sort',
    ];

    protected $casts = [
        'price' => 'float',
        'old_price' => 'float',
        'stock' => 'int',
        'sort' => 'int',
    ];

    #[Override]
    protected static function booted(): void
    {
        static::saving(static function (self $variant) {
            if ($variant->old_price && $variant->price >= $variant->old_price) {
                throw VariantException::oldPrice(
                    sku: $variant->sku,
                    price: $variant->price,
                    id: $variant->id,
                    oldPrice: $variant->old_price,
                );
            }
        });
    }
    /*
    |--------------------------------------------------------------------------
    | ATTRIBUTES
    |--------------------------------------------------------------------------
    */

    /**
     * @return Attribute<bool, never>
     */
    protected function outOfStock(): Attribute
    {
        return Attribute::get(static fn (
            mixed $value,
            array $attributes,
        ) => $attributes['stock'] === 0);
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    /**
     * @return BelongsTo<Product, $this>
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
