<?php

declare(strict_types=1);

namespace App\Services\Media;

abstract class Storage
{
    public const array ALLOWED_IMAGE_EXTENSIONS = [
        'jpg', 'jpeg', 'webp',
    ];

    protected string $folder;

    protected string $entity;

    public function duplicate(string $from, string $to): void
    {
        $directoryFrom = "$this->folder/$from";
        $directoryTo = "$this->folder/$to";

        if (! \Illuminate\Support\Facades\Storage::exists($directoryFrom)) {
            return;
        }

        foreach ($this->allFiles($from) as $file) {
            $name = pathinfo($file, PATHINFO_BASENAME);
            \Illuminate\Support\Facades\Storage::copy($file, "$directoryTo/$name");
        }
    }

    /**
     * @return array<int, string>
     */
    public function allFiles(string $entity): array
    {
        $directory = "$this->folder/$entity";

        /** @phpstan-ignore-next-line  */
        return \Illuminate\Support\Facades\Storage::allFiles($directory);
    }

    public static function size(string $path): int
    {
        return \Illuminate\Support\Facades\Storage::size($path);
    }

    public static function url(string $path): string
    {
        return \Illuminate\Support\Facades\Storage::url($path);
    }
}
