<?php

declare(strict_types=1);

use Livewire\Attributes\Url;
use Livewire\Component;

new class extends Component
{
    use \App\Support\Component\Concerns\DispatchesFieldUpdates;

    #[Url(except: 'all')]
    public ?string $filter = 'all';

    /**
     * @var array<string, string>
     */
    public array $filters = [];

    public function mount(): void
    {
        $this->filters = [
            'all' => __('All products'),
            'feature' => __('Feature'),
            'discounted' => __('Discounted'),
            'active' => __('Active'),
            'inactive' => __('Inactive'),
            'out_of_stock' => __('Out of stock'),
        ];
    }

    public function updatedFilter(): void
    {
        $this->dispatch('apply', filter: $this->filter);
    }
};
