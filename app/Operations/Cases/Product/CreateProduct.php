<?php

declare(strict_types=1);

namespace App\Operations\Cases\Product;

use Illuminate\Http\UploadedFile;

readonly class CreateProduct
{
    public function __construct(
        public string $newId,
        /**
         * @var array<string, mixed>
         */
        public array $attributes,
        /**
         * @var array<int,string>
         */
        public array $related,
        public ?string $brandId,
        /**
         * @var array<int,array{
         *  sku:string,
         *  name:string|null,
         *  price:float,
         *  old_price:float|null,
         *  stock:int|null,
         *  sort:int|null}>
         */
        public array $variants,
        /**
         * @var array<int,string>
         */
        public array $categories,
        /**
         * @var array<int,array{name:string,value:string}>
         */
        public array $newFeatures,
        public string $firstCategoryId,
        /**
         * @var array<int,array{feature_id:string,value:string}>
         */
        public array $options,
        /**
         * @var array<int, UploadedFile>
         */
        public array $droppedImages,
    ) {}
}
