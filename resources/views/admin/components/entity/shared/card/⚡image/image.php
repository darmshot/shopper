<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Livewire\Component;

new class extends Component
{
    /**
     * @var array{name:string,size:string,url:string,path:string}|null
     */
    public ?array $images = null;

    /**
     * @var array{maxFilesize:int,acceptedFiles:string}
     */
    public array $dropzoneConfig = [
        'maxFilesize' => 2,
    ];

    public function mount(Model $entity): void
    {
        $this->dropzoneConfig['acceptedFiles'] = '.'.implode(',.', \App\Services\Media\Storage::ALLOWED_IMAGE_EXTENSIONS);

        if ($entity->image && Storage::exists($entity->image)) {
            $this->images = [
                [
                    'name' => pathinfo($entity->image, PATHINFO_BASENAME),
                    'size' => \App\Services\Media\Storage::size($entity->image),
                    'url' => \App\Services\Media\Storage::url($entity->image),
                    'path' => $entity->image,
                ],
            ];
        }
    }
};
