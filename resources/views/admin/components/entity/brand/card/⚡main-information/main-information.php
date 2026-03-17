<?php

declare(strict_types=1);

use App\Models\Brand;
use App\Support\Form;
use Livewire\Component;

new class extends Component
{
    use \App\Support\Component\Concerns\DispatchesFieldUpdates;

    public string $name = '';

    public function mount(Brand $brand): void
    {
        $this->name = (string) Form::oldNullOrString('name', $brand->name);
    }
};
