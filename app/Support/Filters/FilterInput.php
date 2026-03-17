<?php

declare(strict_types=1);

namespace App\Support\Filters;

final class FilterInput
{
    /**
     * @param  array<int|string,mixed>  $value
     * @return array<int, string>
     */
    public static function stringList(array $value): array
    {
        return array_values(array_filter($value, is_string(...)));
    }

    /**
     * @param  array<int|string,mixed>  $value
     * @return array<string, array<int, string>>
     */
    public static function featureMap(array $value): array
    {
        $result = [];

        foreach ($value as $key => $list) {
            if (! is_string($key) || ! is_array($list)) {
                continue;
            }

            $clean = array_values(array_filter($list, is_string(...)));

            if ($clean !== []) {
                $result[$key] = $clean;
            }
        }

        return $result;
    }
}
