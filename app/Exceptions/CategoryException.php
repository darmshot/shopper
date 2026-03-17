<?php

declare(strict_types=1);

namespace App\Exceptions;

class CategoryException extends EntityException
{
    public static function selfParentId(string $id): self
    {
        return new self(
            message: __('exception.message.self_parent_id', ['entity' => __('category.entity_name_genitive')]),
            context: [
                'entity' => 'category',
                'id' => $id,
            ]);
    }
}
