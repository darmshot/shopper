<?php

declare(strict_types=1);

use App\Support\Form;
use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

new class extends Component
{
    public string $name = '';

    public string $url = '';

    public string $metaTitle = '';

    public ?string $metaDescription = null;

    public ?string $urlPrefix = null;

    public function mount(Model $entity, ?string $urlPrefix): void
    {
        $this->urlPrefix = $urlPrefix;
        $this->name = (string) Form::oldNullOrString('name', $entity->name);
        $this->url = (string) Form::oldNullOrString('url', $entity->url);
        $this->metaTitle = (string) Form::oldNullOrString('meta_title', $entity->meta_title);
        $this->metaDescription = Form::oldNullOrString('meta_description', $entity->meta_description);
    }

    public function updatedName(): void
    {
        if (empty($this->url)) {
            $this->url = \Illuminate\Support\Str::slug($this->name);
        }

        if (empty($this->metaTitle)) {
            $this->metaTitle = $this->name;
        }
    }
};
