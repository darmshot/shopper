<?php

declare(strict_types=1);

namespace App\Services\Media;

class BrandStorage extends Storage
{
    use HasImage;

    protected string $folder = 'brands';
}
