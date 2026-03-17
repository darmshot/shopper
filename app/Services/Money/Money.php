<?php

declare(strict_types=1);

namespace App\Services\Money;

use Illuminate\Support\Number;

readonly class Money
{
    public function __construct(
        private string $currency,
        private string $locale,
    ) {}

    public function currency(float $amount): float
    {
        return $amount;
    }

    public function currencyFormat(float $amount): ?string
    {
        return Number::currency(
            number: $this->currency($amount),
            in: $this->currency,
            locale: $this->locale,
        ) ?: null;
    }
}
