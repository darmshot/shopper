<?php

declare(strict_types=1);

namespace App\Support\Eloquent\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class UseRepository
{
    /**
     * Create a new attribute instance.
     *
     * @param  class-string  $repositoryClass
     */
    public function __construct(public string $repositoryClass) {}
}
