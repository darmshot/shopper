<?php

declare(strict_types=1);

namespace App\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static float currency(float $amount)
 * @method static string|null currencyFormat(float $amount)
 *
 * @see \App\Services\Money\Money
 */
class Money extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'money';
    }
}
