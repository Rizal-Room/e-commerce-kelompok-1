@extends('layouts.customer')

@section('title', 'Order Details')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Back Button -->
        <a href="{{ route('transactions.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-primary-900 mb-6">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Orders
        </a>

        <h1 class="text-3xl font-bold mb-8">Order Details</h1>

        <!-- Order Status Card -->
        <div class="card p-6 mb-6">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Order Number</p>
                    <p class="font-mono font-bold text-xl">{{ $transaction->code }}</p>
                </div>
                <span class="px-4 py-2 rounded-full text-sm font-medium
                    {{ $transaction->payment_status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                    {{ $transaction->payment_status === 'shipped' ? 'bg-blue-100 text-blue-800' : '' }}
                    {{ $transaction->payment_status === 'paid' ? 'bg-purple-100 text-purple-800' : '' }}
                    {{ $transaction->payment_status === 'pending' ? 'bg-yellow-100 text-yellow-800' : '' }}">
                    {{ ucfirst($transaction->payment_status) }}
                </span>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-600 mb-1">Order Date</p>
                    <p class="font-medium">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                </div>
                <div>
                    <p class="text-gray-600 mb-1">Store</p>
                    <p class="font-medium">{{ $transaction->store->name ?? 'XIV Shop' }}</p>
                </div>
                @if($transaction->tracking_number)
                    <div class="col-span-2">
                        <p class="text-gray-600 mb-1">Tracking Number</p>
                        <p class="font-mono font-medium">{{ $transaction->tracking_number }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Shipping Address -->
        <div class="card p-6 mb-6">
            <h2 class="font-semibold mb-3">Shipping Address</h2>
            <p class="text-gray-700">
                {{ $transaction->address }}<br>
                {{ $transaction->city }}, {{ $transaction->postal_code }}
            </p>
            <p class="text-sm text-gray-600 mt-2">
                Shipping: <span class="font-medium capitalize">{{ str_replace('_', ' ', $transaction->shipping_type) }}</span>
            </p>
        </div>

        <!-- Order Items -->
        <div class="card p-6 mb-6">
            <h2 class="font-semibold mb-4">Order Items</h2>
            <div class="space-y-4">
                @foreach($transaction->transactionDetails as $detail)
                    <div class="flex gap-4 pb-4 {{ !$loop->last ? 'border-b border-gray-200' : '' }}">
                        <div class="w-20 h-20 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                            @if($detail->product->productImages->count() > 0)
                                <img src="{{ asset('storage/' . $detail->product->productImages->first()->image) }}" 
                                     alt="{{ $detail->product->name }}"
                                     class="w-full h-full object-cover">
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="font-semibold mb-1">{{ $detail->product->name }}</h3>
                            <p class="text-sm text-gray-600 mb-2">
                                Quantity: {{ $detail->qty }} × Rp {{ number_format($detail->product->price, 0, ',', '.') }}
                            </p>
                            <p class="font-semibold text-primary-900">
                                Rp {{ number_format($detail->subtotal, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Order Summary -->
        <div class="card p-6">
            <h2 class="font-semibold mb-4">Order Summary</h2>
            <div class="space-y-2">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Subtotal</span>
                    <span class="font-medium">
                        Rp {{ number_format($transaction->transactionDetails->sum('subtotal'), 0, ',', '.') }}
                    </span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Shipping</span>
                    <span class="font-medium">Rp {{ number_format($transaction->shipping_cost, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-600">Tax</span>
                    <span class="font-medium">Rp {{ number_format($transaction->tax, 0, ',', '.') }}</span>
                </div>
                <div class="flex justify-between text-lg font-bold pt-3 border-t border-gray-200">
                    <span>Total</span>
                    <span class="text-primary-900">Rp {{ number_format($transaction->grand_total, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
