<?php

declare(strict_types=1);

use App\Support\Facades\Money;
use App\Support\Form;

if (! function_exists('dot_name')) {
    /**
     * Return dot name field. Useful for check validation.
     */
    function dot_name(string $name): string
    {
        return Form::dotName($name);
    }
}

if (! function_exists('money')) {
    /**
     * Return dot name field. Useful for check validation.
     */
    function money(float $amount): ?string
    {
        return Money::currencyFormat($amount);
    }
}
