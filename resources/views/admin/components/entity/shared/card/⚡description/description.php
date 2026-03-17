<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

new class extends Component
{
    public ?string $description = null;

    public function mount(Model $entity): void
    {
        $this->description = old('description', $entity->description);
    }
};
