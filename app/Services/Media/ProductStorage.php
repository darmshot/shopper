<?php

declare(strict_types=1);

namespace App\Services\Media;

class ProductStorage extends Storage
{
    use HasImages;

    protected string $folder = 'products';
}
