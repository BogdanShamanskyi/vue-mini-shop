<?php

declare(strict_types=1);

namespace App\Cart;

use App\Cart\Contracts\CartStorage;
use Illuminate\Contracts\Session\Session;

final class SessionCartStorage implements CartStorage
{
    private const KEY = 'cart.items';

    public function __construct(private readonly Session $session) {}

    public function all(): array
    {
        /** @var array<int,int> */
        return $this->session->get(self::KEY, []);
    }

    public function set(int $productId, int $qty): void
    {
        $items = $this->all();
        $items[$productId] = $qty;
        $this->session->put(self::KEY, $items);
    }

    public function remove(int $productId): void
    {
        $items = $this->all();
        unset($items[$productId]);
        $this->session->put(self::KEY, $items);
    }

    public function clear(): void
    {
        $this->session->forget(self::KEY);
    }
}
