<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class CheckoutService
{
    public function checkout(int $userId, array $customer, array $cartItems): Order
    {
        return DB::transaction(function () use ($userId, $customer, $cartItems) {
            if (empty($cartItems)) {
                throw ValidationException::withMessages([
                    'cart' => ['Cart is empty'],
                ]);
            }

            $ids = array_keys($cartItems);

            $products = Product::query()
                ->whereIn('id', $ids)
                ->lockForUpdate()
                ->get(['id', 'price', 'stock', 'title'])
                ->keyBy('id');

            $total = 0;

            foreach ($cartItems as $pid => $qty) {
                $product = $products->get((int)$pid);
                if (!$product) {
                    throw ValidationException::withMessages(['cart' => ['Invalid product in cart']]);
                }
                if ($product->stock < $qty) {
                    throw ValidationException::withMessages([
                        'stock' => ["Not enough stock for product {$product->id}"],
                    ]);
                }
                $total += (float)$product->price * (int)$qty;
            }

            $order = Order::query()->create([
                'user_id' => $userId,
                'name' => $customer['name'],
                'phone' => $customer['phone'],
                'address' => $customer['address'],
                'total' => $total,
            ]);

            foreach ($cartItems as $pid => $qty) {
                $product = $products->get((int)$pid);

                OrderItem::query()->create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'price' => (float)$product->price,
                    'qty' => (int)$qty,
                    'line_total' => (float)$product->price * (int)$qty,
                ]);

                Product::query()->whereKey($product->id)->update([
                    'stock' => $product->stock - (int)$qty,
                ]);
            }

            return $order;
        });
    }
}
