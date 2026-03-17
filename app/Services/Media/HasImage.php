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
trait HasImage
{
    /**
     * @param  Closure(string $path):void|null  $callback
     *
     * @throws MediaStorageException
     */
    public function putImage(string $entityId, UploadedFile $file, ?Closure $callback = null): void
    {
        $directory = "$this->folder/$entityId";

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

        if ($callback) {
            $callback($newPath);
        }
    }

    /**
     * @throws MediaStorageException
     */
    public function deleteImage(string $path): void
    {
        if (Storage::delete($path) === false) {
            throw MediaStorageException::deleteImage(
                entity: $this->entity,
                path: $path,
            );
        }
    }
}
