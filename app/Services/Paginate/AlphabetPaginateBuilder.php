<?php

declare(strict_types=1);

namespace App\Services\Paginate;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @template TValue
 */
readonly class AlphabetPaginateBuilder
{
    /**
     * @param  LengthAwarePaginator<int, TValue>  $paginator
     */
    public function __construct(
        private LengthAwarePaginator $paginator,
    ) {}

    /**
     * @return LengthAwarePaginator<int, object{symbol: string, items: Collection<int, TValue>}>
     */
    public function build(
        string $symbolColumn = 'name',
    ): LengthAwarePaginator {
        $items = $this->paginator
            /** @phpstan-ignore-next-line */
            ->getCollection()
            /** @phpstan-ignore-next-line */
            ->groupBy(static function (Model $item) use ($symbolColumn): string {
                $value = $item->getAttribute($symbolColumn);

                if (! is_string($value)) {
                    $value = '';
                }

                return strtoupper(substr($value, 0, 1));
            })
            /** @phpstan-ignore-next-line */
            ->map(static fn (Collection $items, string $key) => (object) [
                'symbol' => $key,
                'items' => $items,
            /** @phpstan-ignore-next-line */
            ])->values();

        /** @phpstan-ignore-next-line */
        $this->paginator->setCollection($items);

        /** @phpstan-ignore-next-line */
        return $this->paginator;
    }
}
