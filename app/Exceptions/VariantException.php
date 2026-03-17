<?php

declare(strict_types=1);

namespace App\Exceptions;

class VariantException extends EntityException
{
    public static function oldPrice(?string $sku, ?float $price, ?string $id, ?float $oldPrice): self
    {
        return new self(
            message: __('exception.message.old_price', ['sku' => $sku, 'entity' => __('variant.entity_name_genitive')]),
            context: [
                'entity' => 'variant',
                'id' => $id,
                'sku' => $sku,
                'price' => $price,
                'old_price' => $oldPrice,
            ]);
    }
}
