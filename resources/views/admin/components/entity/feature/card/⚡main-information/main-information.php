<?php

declare(strict_types=1);

use App\Models\Feature;
use App\Support\Form;
use Livewire\Component;

new class extends Component
{
    public string $name = '';

    public function mount(Feature $feature): void
    {
        $this->name = (string) Form::oldNullOrString('name', $feature->name);
    }
};
