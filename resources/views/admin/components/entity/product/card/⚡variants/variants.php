<?php

declare(strict_types=1);

use Livewire\Component;

new class extends Component
{
    /**
     * @var array<int,array{name:string,sku:string,price:float,old_price:float|null,stock:int}>
     */
    public array $variants = [];

    public bool $showVariantName = false;

    private const array VARIANT_TEMPLATE = [
        'name' => null,
        'sku' => null,
        'price' => null,
        'old_price' => null,
        'stock' => null,
    ];

    public function mount(\App\Models\Product $product): void
    {
        /** @var array $variants */
        $variants = when(old('variants'), fn ($value) => array_reduce($value, function ($carry, $item) {
            $id = uniqid('variant_');
            $item['id'] = $id;
            $carry[$id] = $item;

            return $carry;
        }, []), []);

        /** @var array $variants */
        $variants = when(empty($variants), fn () => $product
            ->variants()
            ->orderBy('sort')
            ->get()->map
            ->only(['id', 'name', 'sku', 'price', 'old_price', 'stock'])
            ->keyBy->id
            ->toArray(), $variants);

        /** @var array $variants */
        $variants = when(empty($variants), fn () => [($new = $this->getVariantTemplate())['id'] => $new], $variants);

        /** @phpstan-ignore-next-line */
        $this->variants = $variants;

        $this->showVariantName = ! empty(array_first($this->variants)['name']);
    }

    public function removeVariant(string $id): void
    {
        // Disable field name
        if (count($this->variants) <= 1) {
            $this->showVariantName = false;
            $this->cleanVariantName();

            return;
        }

        unset($this->variants[$id]);
    }

    public function addVariant(): void
    {
        if ($this->showVariantName === false && count($this->variants) < 2) {
            $this->showVariantName = true;

            return;
        }

        $new = $this->getVariantTemplate();
        $this->variants[$new['id']] = $new;
    }

    public function reorderVariants(array $ids): void
    {
        $variantsById = $this->variants;

        $this->variants = collect($ids)
            ->mapWithKeys(fn ($id) => [$id => $variantsById[$id]])
            ->all();
    }

    private function cleanVariantName(): void
    {
        if (empty($this->variants[0]->name)) {
            return;
        }

        $this->variants[0]->name = null;
    }

    private function getVariantTemplate(): array
    {
        $new = self::VARIANT_TEMPLATE;
        $new['id'] = uniqid('variant_');

        return $new;
    }
};
