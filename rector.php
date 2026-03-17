<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\LevelSetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $config): void {
    // PHP upgrades (up to 8.4)
    $config->sets([
        LevelSetList::UP_TO_PHP_84,
    ]);

    // Laravel upgrades + code quality
    $config->sets([
        LaravelSetList::LARAVEL_120,        // Laravel 12 rules
        LaravelSetList::LARAVEL_CODE_QUALITY,
    ]);

    $config->skip([
        Rector\Php81\Rector\Array_\ArrayToFirstClassCallableRector::class => [
            __DIR__.'/app/Http/Controllers/*',
        ],
    ]);

    // Auto-import classes
    $config->importNames();
    $config->importShortClasses();

    // Project paths
    $config->paths([
        __DIR__.'/app',
    ]);

    // Skip folders that should never be modified
    $config->skip([
        __DIR__.'/storage',
        __DIR__.'/bootstrap',
        __DIR__.'/vendor',
        __DIR__.'/tests', // Pest tests stay untouched
    ]);
};
