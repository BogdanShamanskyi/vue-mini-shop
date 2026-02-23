<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\View\View;

final class CatalogPageController
{
    public function __invoke(int $id): View
    {
        $category = Category::query()->findOrFail($id);

        $categories = Category::query()
            ->orderBy('title')
            ->get(['id', 'title']);

        return view('category.show', compact('category', 'categories'));
    }
}
