<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

final class ProductPageController
{
    public function __invoke(int $id): View
    {
        $product = Product::query()->with('category')->findOrFail($id);

        return view('products.show', compact('product'));
    }
}
