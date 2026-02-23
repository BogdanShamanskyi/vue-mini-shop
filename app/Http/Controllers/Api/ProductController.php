<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

final class ProductController extends Controller
{
    public function index(Request $request, int $id): JsonResponse
    {
        $data = $request->validate([
            'min_price' => ['nullable', 'numeric', 'min:0'],
            'max_price' => ['nullable', 'numeric', 'min:0'],
        ]);

        $query = Product::query()->where('category_id', $id);

        if (isset($data['min_price'])) $query->where('price', '>=', $data['min_price']);
        if (isset($data['max_price'])) $query->where('price', '<=', $data['max_price']);

        $pagination = $query->orderBy('id')->paginate(12);

        return response()->json([
            'data' => $pagination->items(),
            'meta' => [
                'current_page' => $pagination->currentPage(),
                'last_page' => $pagination->lastPage(),
                'per_page' => $pagination->perPage(),
                'total' => $pagination->total(),
            ],
        ]);
    }
}
