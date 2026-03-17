<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;
use Throwable;

abstract class EntityException extends Exception
{
    /**
     * @param  array<string,mixed>  $context
     */
    public function __construct(
        string $message,
        public array $context = [],
        int $code = 0,
        ?Throwable $previous = null,
    ) {
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return array<string,mixed>
     */
    public function context(): array
    {
        return $this->context;
    }
}
