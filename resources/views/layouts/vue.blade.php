<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Shop')</title>
    @vite('resources/js/app.js')
</head>
    <body>
        <header style="display:flex;justify-content:space-between;align-items:center;padding:16px;border-bottom:1px solid #eee;">
            <nav style="display:flex;gap:12px;">
                <a href="{{ route('category.show', ['id' => 1]) }}">Catalog</a>
                @auth
                    <a href="{{ route('checkout.show') }}">Checkout</a>
                    <a href="{{ route('orders.index') }}">My Orders</a>
                @endauth
            </nav>

            <div data-vue-root="MiniCart" data-props="{}"></div>
        </header>

        <main style="padding:16px;">
            @yield('content')
        </main>
    </body>
</html>
