<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\DTO\Cart\AddToCartData;
use App\DTO\Cart\SetCartQtyData;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\SetQtyRequest;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;

final class CartController extends Controller
{
    public function show(CartService $cart): JsonResponse
    {
        return response()->json($cart->payload());
    }

    public function add(AddToCartRequest $request, CartService $cart): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(
            $cart->add(new AddToCartData(
                productId: (int) $validated['product_id'],
                qty: (int) ($validated['qty'] ?? 1),
            ))
        );
    }

    public function setQty(int $product, SetQtyRequest $request, CartService $cart): JsonResponse
    {
        $validated = $request->validated();

        return response()->json(
            $cart->setQty(new SetCartQtyData(
                productId: $product,
                qty: (int) $validated['qty'],
            ))
        );
    }

    public function remove(int $product, CartService $cart): JsonResponse
    {
        return response()->json($cart->remove($product));
    }
}
