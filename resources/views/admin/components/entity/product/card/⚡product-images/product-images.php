<?php

declare(strict_types=1);

use App\Models\Product;
use Livewire\Component;

new class extends Component
{
    /**
     * @var array<int,array{name:string,size:string,url:string,path:string}>
     */
    public array $images = [];

    /**
     * @var array{maxFilesize:int,acceptedFiles:string}
     */
    public array $dropzoneConfig = [
        'maxFilesize' => 2,
    ];

    public function mount(Product $product): void
    {
        $this->dropzoneConfig['acceptedFiles'] = '.'.implode(',.',
            \App\Services\Media\Storage::ALLOWED_IMAGE_EXTENSIONS);

        $existsImages = array_filter($product->images,
            fn (string $image) => \Illuminate\Support\Facades\Storage::exists($image));

        $this->images = array_map(static function (string $path) {
            return [
                'name' => pathinfo($path, PATHINFO_BASENAME),
                'size' => \App\Services\Media\Storage::size($path),
                'url' => \App\Services\Media\Storage::url($path),
                'path' => $path,
            ];
        }, $existsImages);
    }
};
