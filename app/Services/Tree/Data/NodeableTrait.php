<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

trait NodeableTrait
{
    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {

        return $this->name;
    }

    public function getParentId(): ?string
    {
        return $this->parent_id;
    }

    public function getProductsCount(): ?int
    {
        return $this->products_count;
    }
}
