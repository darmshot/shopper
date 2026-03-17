<?php

declare(strict_types=1);

namespace App\Services\Tree\Data;

interface Nodeable
{
    public function getId(): string;

    public function getName(): string;

    public function getParentId(): ?string;

    public function getProductsCount(): ?int;
}
