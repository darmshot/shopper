<?php

declare(strict_types=1);

namespace App\Support\Component\Concerns;

trait DispatchesFieldUpdates
{
    public function bootDispatchesFieldUpdates(): void
    {
        // Fires when component is mounted
        $this->js('console.log("mounted: '.$this->getName().'")');
    }

    public function updated($name, $value): void
    {
        // Dynamic event name based on component name + property
        $event = "{$this->getName()}.{$name}.updated";

        $this->dispatch($event, ...[$name => $value]);
    }
}
