<?php

declare(strict_types=1);

use App\Models\Feature;
use App\Support\Form;
use Livewire\Component;

new class extends Component
{
    public bool $inFilter = false;

    public function mount(Feature $feature): void
    {
        $this->inFilter = Form::oldBool('in_filter', (bool) $feature->in_filter);
    }
};
