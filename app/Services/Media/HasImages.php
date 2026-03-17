<?php

declare(strict_types=1);

namespace App\Services\Media;

use App\Exceptions\MediaStorageException;
use Closure;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * @mixin Storage
 */
trait HasImages
{
    /**
     * @param  array<int, UploadedFile>  $files
     * @param  Closure(array<int, string> $paths):void|null  $callback
     *
     * @throws MediaStorageException
     */
    public function putImages(string $entityId, array $files, ?Closure $callback = null): void
    {
        $directory = "$this->folder/$entityId";

        $newPaths = [];
        foreach ($files as $file) {
            if (! in_array($file->clientExtension(), self::ALLOWED_IMAGE_EXTENSIONS)) {
                throw MediaStorageException::imageExtension(
                    entity: $this->entity,
                    id: $entityId,
                    allowedExtensions: self::ALLOWED_IMAGE_EXTENSIONS,
                    clientExtension: $file->clientExtension());
            }

            $newPath = Storage::putFile($directory, $file);

            if ($newPath === false) {
                throw MediaStorageException::putImage(
                    entity: $this->entity,
                );
            }

            $newPaths[] = $newPath;
        }

        if ($callback) {
            $callback($newPaths);
        }
    }

    /**
     * @param  array<int, string>  $paths
     *
     * @throws MediaStorageException
     */
    public function deleteImages(array $paths): void
    {
        if (Storage::delete($paths) === false) {
            throw MediaStorageException::deleteImages(
                entity: $this->entity,
                paths: $paths,
            );
        }
    }
}
