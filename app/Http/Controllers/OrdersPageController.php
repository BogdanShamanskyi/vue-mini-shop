<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

final class OrdersPageController
{
    public function __invoke(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->latest()
            ->get(['id', 'total', 'created_at']);

        return view('orders.index', compact('orders'));
    }
}
