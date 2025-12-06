<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 xl:grid-cols-6 gap-4">
    @foreach($products as $product)
        <x-product-card :product="$product" />
    @endforeach
</div>

<div class="mt-8">
    {{ $products->appends(request()->query())->links() }}
</div>
