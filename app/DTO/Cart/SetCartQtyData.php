<?php

declare(strict_types=1);

namespace App\DTO\Cart;

final class SetCartQtyData
{
    public function __construct(
        public readonly int $productId,
        public readonly int $qty,
    ) {}
}
