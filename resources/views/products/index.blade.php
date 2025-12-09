@extends('layouts.customer')

@section('title', 'Shop - All Products')

@section('content')
{{-- Page Header --}}
<div class="bg-gray-50 py-8 border-b border-gray-200">
    <div class="container-custom">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-bold" style="color: #252B42;">Shop</h1>
                <p class="text-sm text-gray-600">Showing all {{ $products->total() }} results</p>
            </div>
            <nav class="text-sm text-gray-600">
                <a href="{{ route('home') }}" class="hover:text-primary-500">Home</a> / 
                <span class="font-bold">Shop</span>
            </nav>
        </div>
    </div>
</div>

<div class="container-custom py-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        {{-- Sidebar Filters --}}
        <aside class="space-y-6">
            {{-- Categories --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-bold mb-4" style="color: #252B42;">Categories</h3>
                <div class="space-y-2">
                    <a href="{{ route('products.index') }}" 
                       class="block py-2 text-sm {{ !request('category') ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                        All Products
                    </a>
                    @foreach($categories->whereNull('parent_id') as $parent)
                        <div class="mb-3">
                            <p class="font-bold text-sm text-gray-800 mb-2">{{ $parent->name }}</p>
                            @foreach($parent->children as $child)
                                <a href="{{ route('products.index', ['category' => $child->id]) }}" 
                                   class="block py-1 pl-4 text-sm {{ request('category') == $child->id ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                                    {{ $child->name }} 
                                    @if($child->products_count > 0)
                                        <span class="text-xs text-gray-400">({{ $child->products_count }})</span>
                                    @endif
                                </a>
                            @endforeach
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Price Filter --}}
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h3 class="font-bold mb-4" style="color: #252B42;">Filter by Price</h3>
                <form id="priceFilterForm" action="{{ route('products.index') }}" method="GET">
                    {{-- Preserve other query parameters --}}
                    <input type="hidden" name="category" value="{{ request('category') }}">
                    <input type="hidden" name="search" value="{{ request('search') }}">
                    <input type="hidden" name="sort" value="{{ request('sort') }}">
                    
                    <div class="space-y-3">
                        @php
                            $selectedRanges = request('price_ranges', []);
                            if (!is_array($selectedRanges)) {
                                $selectedRanges = [$selectedRanges];
                            }
                            
                            $priceRanges = [
                                ['value' => '0-200000', 'label' => 'Rp 0 - Rp 200.000'],
                                ['value' => '200000-500000', 'label' => 'Rp 200.000 - Rp 500.000'],
                                ['value' => '500000-1000000', 'label' => 'Rp 500.000 - Rp 1.000.000'],
                                ['value' => '1000000-0', 'label' => 'Rp 1.000.000 - Rp 5.000.000'],
                            ];
                        @endphp
                        
                        {{-- Clear all filters option --}}
                        <div class="pb-2 border-b border-gray-200">
                            <a href="{{ route('products.index', request()->except(['price_ranges', 'min_price', 'max_price'])) }}" 
                               class="text-sm {{ empty($selectedRanges[0]) ? 'text-primary-500 font-bold' : 'text-gray-600 hover:text-primary-500' }}">
                                All Prices
                            </a>
                        </div>
                        
                        {{-- Checkbox filters --}}
                        @foreach($priceRanges as $range)
                            <label class="flex items-center space-x-3 cursor-pointer hover:bg-gray-50 p-2 rounded transition-colors">
                                <input 
                                    type="checkbox" 
                                    name="price_ranges[]" 
                                    value="{{ $range['value'] }}"
                                    {{ in_array($range['value'], $selectedRanges) ? 'checked' : '' }}
                                    onchange="document.getElementById('priceFilterForm').submit()"
                                    class="w-4 h-4 text-primary-500 border-gray-300 rounded focus:ring-primary-500 focus:ring-2 cursor-pointer"
                                >
                                <span class="text-sm text-gray-700">{{ $range['label'] }}</span>
                            </label>
                        @endforeach
                    </div>
                </form>
            </div>
        </aside>

        {{-- Products Grid --}}
        <div class="lg:col-span-3">
            {{-- Toolbar --}}
            <div class="bg-white border border-gray-200 rounded-lg p-4 mb-6 flex items-center justify-between">
                <p class="text-sm text-gray-600">
                    Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} results
                </p>
                
                <div class="flex items-center gap-4">
                    <form action="{{ route('products.index') }}" method="GET" class="flex items-center gap-2">
                        <input type="hidden" name="category" value="{{ request('category') }}">
                        @if(request('price_ranges'))
                            @foreach(is_array(request('price_ranges')) ? request('price_ranges') : [request('price_ranges')] as $range)
                                <input type="hidden" name="price_ranges[]" value="{{ $range }}">
                            @endforeach
                        @endif
                        <label class="text-sm text-gray-600">Sort by:</label>
                        <select name="sort" onchange="this.form.submit()" class="input-field py-2">
                            <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                            <option value="price_low" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_high" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name: A-Z</option>
                        </select>
                    </form>
                </div>
            </div>

            {{-- Products Grid --}}
            @if($products->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($products as $product)
                        <x-product-card :product="$product" />
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-8">
                    {{ $products->appends(request()->query())->links() }}
                </div>
            @else
                <div class="bg-white rounded-lg border border-gray-200 p-12 text-center">
                    <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                    </svg>
                    <h3 class="text-lg font-bold text-gray-700 mb-2">No products found</h3>
                    <p class="text-gray-500 mb-4">Try adjusting your filters or search criteria</p>
                    <a href="{{ route('products.index') }}" class="btn-primary inline-block">Clear All Filters</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
