@extends('layouts.customer')

@section('title', 'Shopping Cart')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold mb-8">Shopping Cart</h1>

    @if(empty($cart) || count($cart) === 0)
        <!-- Empty Cart State -->
        <div class="text-center py-16">
            <svg class="w-24 h-24 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Your cart is empty</h2>
            <p class="text-gray-600 mb-6">Start shopping to add items to your cart.</p>
            <a href="{{ route('products.index') }}" class="btn-primary inline-block">
                Continue Shopping
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Cart Items -->
            <div class="lg:col-span-2 space-y-4">
                @foreach($cart as $productId => $item)
                    <div class="card p-6">
                        <div class="flex gap-6">
                            <!-- Product Image -->
                            <a href="{{ route('products.show', $item['slug']) }}" class="flex-shrink-0">
                                <div class="w-24 h-24 bg-gray-100 rounded-lg overflow-hidden">
                                    @if($item['image'])
                                        <img src="{{ asset('storage/' . $item['image']) }}" 
                                             alt="{{ $item['name'] }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                            </a>

                            <!-- Product Info -->
                            <div class="flex-1 min-w-0">
                                <a href="{{ route('products.show', $item['slug']) }}" class="block">
                                    <h3 class="font-semibold text-gray-900 mb-1 hover:text-primary-900 transition-colors">
                                        {{ $item['name'] }}
                                    </h3>
                                </a>
                                <p class="text-sm text-gray-500 mb-2">{{ $item['store_name'] }}</p>
                                <p class="text-lg font-bold text-primary-900">
                                    Rp {{ number_format($item['price'], 0, ',', '.') }}
                                </p>
                            </div>

                            <!-- Quantity & Actions -->
                            <div class="flex flex-col items-end justify-between">
                                <!-- Quantity Adjuster -->
                                <form action="{{ route('cart.update', $productId) }}" method="POST" class="flex items-center border border-gray-300 rounded-lg">
                                    @csrf
                                    @method('PATCH')
                                    
                                    <button 
                                        type="submit" 
                                        name="quantity" 
                                        value="{{ max(1, $item['quantity'] - 1) }}"
                                        class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/>
                                        </svg>
                                    </button>
                                    
                                    <span class="w-12 text-center font-medium">{{ $item['quantity'] }}</span>
                                    
                                    <button 
                                        type="submit" 
                                        name="quantity" 
                                        value="{{ $item['quantity'] + 1 }}"
                                        class="px-3 py-1 hover:bg-gray-50 transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                        </svg>
                                    </button>
                                </form>

                                <!-- Remove Button -->
                                <form action="{{ route('cart.remove', $productId) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                                        Remove
                                    </button>
                                </form>

                                <!-- Subtotal -->
                                <p class="text-sm text-gray-600 mt-2">
                                    Subtotal: <span class="font-semibold">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach

                <!-- Clear Cart -->
                <form action="{{ route('cart.clear') }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="text-sm text-red-600 hover:text-red-700 transition-colors">
                        Clear All Items
                    </button>
                </form>
            </div>

            <!-- Order Summary -->
            <div class="lg:col-span-1">
                <div class="card p-6 sticky top-24">
                    <h2 class="text-xl font-bold mb-6">Order Summary</h2>
                    
                    <div class="space-y-4 mb-6">
                        <div class="flex justify-between text-gray-600">
                            <span>Subtotal ({{ array_sum(array_column($cart, 'quantity')) }} items)</span>
                            <span class="font-medium">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        
                        <div class="border-t border-gray-200 pt-4">
                            <div class="flex justify-between text-lg font-bold">
                                <span>Total</span>
                                <span class="text-primary-900">Rp {{ number_format($total, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    @auth
                        <a href="{{ route('checkout.index') }}" class="block w-full btn-primary text-center mb-3">
                            Proceed to Checkout
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block w-full btn-primary text-center mb-3">
                            Login to Checkout
                        </a>
                    @endauth

                    <a href="{{ route('products.index') }}" class="block w-full btn-secondary text-center">
                        Continue Shopping
                    </a>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection
