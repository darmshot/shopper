<?php

declare(strict_types=1);

namespace App\Foundation\Events;

class CurrencyUpdated
{
    /**
     * Create a new event instance.
     *
     * @param  string  $currency
     */
    public function __construct(
        /**
         * The new region.
         */
        public $currency
    ) {}
}
