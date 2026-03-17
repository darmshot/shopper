<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Component;

new class extends Component
{
    public ?string $description = null;

    public function mount(Product $product): void
    {
        $this->description = old('description', $product->description);
    }
};
