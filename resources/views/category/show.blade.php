@extends('layouts.vue')

@section('title', 'Catalog')

@section('content')
    <h1>Catalog</h1>

    <div style="display:flex;gap:8px;flex-wrap:wrap;margin:12px 0;">
        @foreach($categories as $item)
            <a
                href="{{ route('category.show', ['id' => $item->id]) }}"
                style="padding:6px 10px;border:1px solid #eee;text-decoration:none;
                    {{ $item->id === $category->id ? 'font-weight:700;' : '' }}"
            >
                {{ $item->title }}
            </a>
        @endforeach
    </div>

    <div
        data-vue-root="CatalogRoot"
        data-props='@json(["categoryId" => $category->id])'
    ></div>
@endsection
