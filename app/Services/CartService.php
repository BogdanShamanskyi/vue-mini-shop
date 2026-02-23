<?php

declare(strict_types=1);

namespace App\Services;

use App\Cart\Contracts\CartStorage;
use App\DTO\Cart\AddToCartData;
use App\DTO\Cart\SetCartQtyData;
use App\Models\Product;
use Illuminate\Validation\ValidationException;

final class CartService
{
    public function __construct(private readonly CartStorage $storage) {}

    public function payload(): array
    {
        $items = $this->storage->all();
        if (!$items) {
            return ['items' => [], 'summary' => ['items_count' => 0, 'total' => 0]];
        }

        $products = Product::query()
            ->whereIn('id', array_keys($items))
            ->get(['id', 'title', 'price'])
            ->keyBy('id');

        $rows = [];
        $count = 0;
        $total = 0.0;

        foreach ($items as $pid => $qty) {
            $p = $products->get((int) $pid);
            if (!$p) continue;

            $line = (float) $p->price * (int) $qty;

            $rows[] = [
                'product' => ['id' => $p->id, 'title' => $p->title, 'price' => (float) $p->price],
                'qty' => (int) $qty,
                'line_total' => $line,
            ];

            $count += (int) $qty;
            $total += $line;
        }

        return ['items' => $rows, 'summary' => ['items_count' => $count, 'total' => $total]];
    }

    public function add(AddToCartData $data): array
    {
        $product = Product::query()->findOrFail($data->productId);

        $items = $this->storage->all();
        $currentQty = (int) ($items[$data->productId] ?? 0);
        $nextQty = $currentQty + $data->qty;

        $this->assertStock($product, $nextQty);

        $this->storage->set($data->productId, $nextQty);

        return $this->payload();
    }

    public function setQty(SetCartQtyData $data): array
    {
        $product = Product::query()->findOrFail($data->productId);

        $this->assertStock($product, $data->qty);

        $this->storage->set($data->productId, $data->qty);

        return $this->payload();
    }

    public function remove(int $productId): array
    {
        $this->storage->remove($productId);

        return $this->payload();
    }

    private function assertStock(Product $product, int $nextQty): void
    {
        if ($nextQty > (int) $product->stock) {
            throw ValidationException::withMessages([
                'stock' => ["Not enough stock. Available: {$product->stock}"],
            ]);
        }
    }
}
