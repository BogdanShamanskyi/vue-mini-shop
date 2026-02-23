<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CheckoutService;
use Illuminate\Http\RedirectResponse;

final class OrderController
{
    private const CART_KEY = 'cart.items';

    public function __invoke(CheckoutRequest $request, CheckoutService $service): RedirectResponse
    {
        $cart = $request->session()->get(self::CART_KEY, []);

        try {
            $service->checkout(
                userId: (int)$request->user()->id,
                customer: $request->validated(),
                cartItems: $cart,
            );
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()
                ->withErrors($e->errors())
                ->with('checkout_error', 'Checkout failed');
        }

        $request->session()->forget(self::CART_KEY);

        return redirect()->route('orders.index');
    }
}
