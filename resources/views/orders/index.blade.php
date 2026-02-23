@extends('layouts.vue')
@section('title', 'My Orders')

@section('content')
    <h1>My Orders</h1>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->created_at }}</td>
                <td>{{ $order->total }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
