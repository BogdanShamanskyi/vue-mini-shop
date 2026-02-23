@extends('layouts.vue')
@section('title', $product->title)

@section('content')
    <h1>{{ $product->title }}</h1>
    <p>{{ $product->description }}</p>
    <p><b>Price:</b> {{ $product->price }}</p>
    <p><b>Stock:</b> {{ $product->stock }}</p>

    <div
        data-vue-root="AddToCartButton"
        data-props='@json(["productId" => $product->id])'
    ></div>
@endsection
