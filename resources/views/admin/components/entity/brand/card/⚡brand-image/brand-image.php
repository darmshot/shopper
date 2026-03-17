<?php

declare(strict_types=1);

use App\Models\Brand;
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

    public function mount(Brand $brand): void
    {
        $this->dropzoneConfig['acceptedFiles'] = '.'.implode(',.', \App\Services\Media\Storage::ALLOWED_IMAGE_EXTENSIONS);

        if ($brand->image && \Illuminate\Support\Facades\Storage::exists($brand->image)) {
            $this->images = [
                [
                    'name' => pathinfo($brand->image, PATHINFO_BASENAME),
                    'size' => \App\Services\Media\Storage::size($brand->image),
                    'url' => \App\Services\Media\Storage::url($brand->image),
                    'path' => $brand->image,
                ],
            ];
        }
    }
};
