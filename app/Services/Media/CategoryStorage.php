<?php

declare(strict_types=1);

namespace App\Services\Media;

class CategoryStorage extends Storage
{
    use HasImage;

    protected string $folder = 'categories';
}
