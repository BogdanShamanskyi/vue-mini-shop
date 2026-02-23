@extends('layouts.vue')
@section('title', 'Checkout')

@section('content')
    <h1>Checkout</h1>

    <form method="POST" action="{{ route('orders.store') }}" style="display:grid;gap:12px;max-width:420px;">
        @csrf

        <label>
            Name
            <input name="name" value="{{ old('name') }}" />
            @error('name') <div style="color:red;">{{ $message }}</div> @enderror
        </label>

        <label>
            Phone
            <input name="phone" value="{{ old('phone') }}" />
            @error('phone') <div style="color:red;">{{ $message }}</div> @enderror
        </label>

        <label>
            Address
            <input name="address" value="{{ old('address') }}" />
            @error('address') <div style="color:red;">{{ $message }}</div> @enderror
        </label>

        @if(session('checkout_error'))
            <div style="color:red;">{{ session('checkout_error') }}</div>
        @endif

        <button type="submit">Place order</button>
    </form>
@endsection
