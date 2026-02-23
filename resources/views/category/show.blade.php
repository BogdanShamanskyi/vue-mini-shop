@extends('layouts.vue')

@section('title', 'Catalog')

@section('content')
    <div
        data-vue-root="CatalogRoot"
        data-props='@json(["categoryId" => $category->id])'
    ></div>
@endsection
