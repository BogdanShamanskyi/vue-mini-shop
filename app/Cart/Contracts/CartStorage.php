<?php

declare(strict_types=1);

namespace App\Cart\Contracts;

interface CartStorage
{
    /** @return array<int,int> productId => qty */
    public function all(): array;

    public function set(int $productId, int $qty): void;

    public function remove(int $productId): void;

    public function clear(): void;
}
