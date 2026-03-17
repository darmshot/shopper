<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

class MediaStorageException extends Exception
{
    /**
     * @param  array<string,mixed>  $context
     */
    public function __construct(
        string $message = '',
        int $code = 0,
        ?Throwable $previous = null,
        private readonly array $context = []
    ) {
        parent::__construct($message, $code, $previous);
    }

    public static function putImage(string $entity): self
    {
        return new self(
            message: __('exception.message.put_image', ['entity' => __("$entity.entity_name_genitive")]),
            context: [
                'service' => 'media',
                'product' => $entity,
            ]
        );
    }

    /**
     * @param  array<int,string>  $paths
     */
    public static function deleteImages(string $entity, array $paths): self
    {
        return new self(
            message: __('exception.message.delete_image', ['entity' => __("$entity.entity_name_genitive")]),
            context: [
                'service' => 'media',
                'paths' => $paths,
            ]
        );
    }

    public static function deleteImage(string $entity, string $path): self
    {
        return new self(
            message: __('exception.message.delete_image', ['entity' => __("$entity.entity_name_genitive")]),
            context: [
                'service' => 'media',
                'path' => $path,
            ]
        );
    }

    /**
     * @param  array<int,string>  $allowedExtensions
     */
    public static function imageExtension(
        string $entity,
        string $id,
        array $allowedExtensions,
        string $clientExtension
    ): self {
        return new self(
            message: __('exception.message.allowed_extension', [
                'entity' => __("$entity.entity_name_genitive"),
                'allowed_extensions' => implode(', ', $allowedExtensions),
            ]),
            context: [
                'service' => 'media',
                'entity' => $entity,
                'id' => $id,
                'allowed_extensions' => $allowedExtensions,
                'client_extension' => $clientExtension,
            ]
        );
    }

    /**
     * @return array<string,mixed>
     */
    public function context(): array
    {
        return $this->context;
    }
}
