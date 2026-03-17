<?php

declare(strict_types=1);

namespace App\Support\Eloquent\Scopes\Concerns;

use Closure;

trait HasTapSupport
{
    public function asTap(): Closure
    {
        /** @phpstan-ignore-next-line  */
        return fn ($query) => $this($query);
    }
}
