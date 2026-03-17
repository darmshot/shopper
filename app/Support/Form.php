<?php

declare(strict_types=1);

namespace App\Support;

class Form
{
    /**
     * Replace field name to dot name
     */
    public static function dotName(string $fieldName): string
    {
        return str_replace(['[', ']'], ['.', ''], $fieldName);
    }

    public static function oldNullOrString(string $key, ?string $default = null): ?string
    {
        $value = old($key, $default);

        return is_array($value) ? null : $value;
    }

    public static function oldBool(string $key, ?bool $default = null): bool
    {
        $value = old($key, $default ? '1' : '0');

        return (bool) $value;
    }

    /**
     * @param  array<int|string, mixed>  $default
     * @return array<int|string, mixed>
     */
    public static function oldArray(string $key, ?array $default = null): array
    {
        $value = old($key, $default);

        return is_array($value) ? $value : [$value];
    }
}
