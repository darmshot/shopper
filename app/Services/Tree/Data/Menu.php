<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

use Illuminate\Support\Collection;

/**
 * @template TEntity of Nodeable
 */
readonly class Menu
{
    /**
     * @param  Collection<int, Node<TEntity>>  $firstLevel
     * @param  Collection<int, Node<TEntity>>  $secondLevel
     */
    public function __construct(
        public Collection $firstLevel,
        public Collection $secondLevel,
    ) {}
}
