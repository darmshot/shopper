<?php

declare(strict_types=1);

namespace App\Support\Eloquent\Concerns;

use App\Support\Eloquent\Attributes\UseRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

/**
 * Add repository support to Eloquent models.
 *
 * Flexible way to associate a repository with a model using an attribute or static property.
 *
 * @template TRepository
 *
 * @mixin Model
 */
trait HasRepository
{
    /**
     * Create a new repository instance for the model.
     *
     * @return TRepository
     */
    public static function repository()
    {
        /** @phpstan-ignore-next-line  */
        if (isset(static::$repository)) {
            /** @phpstan-ignore-next-line  */
            return resolve(static::$repository);
        }

        $repository = static::getUseRepositoryAttribute();

        if (empty($repository)) {
            throw new Exception("Repository attribute '{$repository}' not found.");
        }

        return $repository;
    }

    /**
     * Get the repository from the UseRepository class attribute.
     *
     * @return TRepository|null
     */
    protected static function getUseRepositoryAttribute(): mixed
    {
        $attributes = new ReflectionClass(static::class)
            ->getAttributes(UseRepository::class);

        if ($attributes !== []) {
            $useRepository = $attributes[0]->newInstance();

            /** @phpstan-ignore-next-line  */
            return resolve($useRepository->repositoryClass);
        }

        return null;
    }
}
