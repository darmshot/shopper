<?php

declare(strict_types=1);

namespace App\Foundation\Mixins;

use App\Foundation\Events\CurrencyUpdated;
use Illuminate\Foundation\Application;

/**
 * @mixin Application
 */
class CurrencyApplicationMixin
{
    public function getCurrency(): callable
    {
        /**
         * Get the current application currency.
         *
         * @return string
         */
        return /** @var \Illuminate\Foundation\Application $this */
        /** @phpstan-ignore-next-line */
        fn () => $this['config']->get('app.currency');
    }

    public function currentCurrency(): callable
    {
        /**
         * Get the current application currency.
         *
         * @return string
         */
        return /** @var \Illuminate\Foundation\Application $this */
        $this->getCurrency(...);
    }

    public function getFallbackCurrency(): callable
    {
        /**
         * Get the current application fallback currency.
         *
         * @return string
         */
        return /** @var \Illuminate\Foundation\Application $this */
        /** @phpstan-ignore-next-line */
        fn () => $this['config']->get('app.fallback_currency');
    }

    public function setCurrency(): callable
    {
        /**
         * Set the current application currency.
         *
         * @param  string  $currency
         * @return void
         */
        return function ($currency) {
            /** @var \Illuminate\Foundation\Application $this */
            /** @phpstan-ignore-next-line */
            $this['config']->set('app.currency', $currency);

            /** @phpstan-ignore-next-line */
            $this['events']->dispatch(new CurrencyUpdated($currency));
        };
    }

    public function setFallbackCurrency(): callable
    {
        /**
         * Set the current application fallback currency.
         *
         * @param  string  $fallbackCurrency
         * @return void
         */
        return function ($fallbackCurrency) {
            /** @var \Illuminate\Foundation\Application $this */
            /** @phpstan-ignore-next-line */
            $this['config']->set('app.fallback_currency', $fallbackCurrency);
        };
    }

    public function isCurrency(): callable
    {
        /**
         * Determine if the application currency is the given currency.
         *
         * @param  string  $currency
         * @return bool
         */
        return /** @var \Illuminate\Foundation\Application $this */
        fn ($currency) => $this->getCurrency() == $currency;
    }
}
