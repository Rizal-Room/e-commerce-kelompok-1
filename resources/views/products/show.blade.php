@extends('layouts.customer')

@section('title', $product->name)

@section('content')
<div class="bg-white pb-12" x-data="productDetail()">
    <!-- Breadcrumb -->
    <div class="container mx-auto px-4 lg:px-8 py-4">
        <div class="flex items-center text-sm text-gray-500 gap-2">
            <a href="{{ route('home') }}" class="text-primary-500 hover:underline">Home</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('products.index', ['category' => $product->productCategory->id]) }}" class="text-primary-500 hover:underline">{{ $product->productCategory->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="truncate max-w-[200px]">{{ $product->name }}</span>
        </div>
    </div>

    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
            <!-- Left Column: Images (4 cols) -->
            <div class="lg:col-span-4">
                <div class="sticky top-24">
                    <!-- Main Image -->
                    <div class="aspect-square rounded-lg overflow-hidden border border-gray-100 mb-4 relative group">
                        @if($product->productImages->count() > 0)
                            <img :src="activeImage" alt="{{ $product->name }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center text-gray-400">
                                <svg class="w-20 h-20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                        @endif
                    </div>

                    <!-- Thumbnails -->
                    <div class="grid grid-cols-5 gap-2">
                        @foreach($product->productImages as $image)
                            <button @click="activeImage = '{{ asset('storage/' . $image->image) }}'" 
                                    class="aspect-square rounded border overflow-hidden hover:border-primary-500 transition-colors"
                                    :class="{ 'border-primary-500 ring-1 ring-primary-500': activeImage === '{{ asset('storage/' . $image->image) }}', 'border-gray-200': activeImage !== '{{ asset('storage/' . $image->image) }}' }">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Center Column: Product Info (5 cols) -->
            <div class="lg:col-span-5">
                <h1 class="text-xl font-bold text-gray-900 mb-2 leading-snug">{{ $product->name }}</h1>
                
                <div class="flex items-center gap-2 text-sm mb-4">
                    <span class="text-gray-500">Terjual <span class="text-gray-700 font-medium">100+</span></span>
                    <span class="text-gray-300">•</span>
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-yellow-400 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        <span class="font-bold text-gray-900">4.9</span>
                        <span class="text-gray-500">(32 rating)</span>
                    </div>
                </div>

                <div class="text-3xl font-bold text-gray-900 mb-6">
                    Rp{{ number_format($product->price, 0, ',', '.') }}
                </div>

                <hr class="border-gray-100 mb-6">

                <!-- Variant Selection (Mock) -->
                <div class="mb-6">
                    <h3 class="font-bold text-gray-900 mb-3">Pilih Ukuran: <span class="text-gray-500 font-normal" x-text="selectedSize || 'Pilih'"></span></h3>
                    <div class="flex flex-wrap gap-2">
                        @foreach(['38', '39', '40', '41', '42', '43'] as $size)
                            <button @click="selectedSize = '{{ $size }}'" 
                                    class="px-4 py-2 rounded-lg border text-sm font-medium transition-all"
                                    :class="{ 
                                        'border-primary-500 bg-primary-50 text-primary-600': selectedSize === '{{ $size }}',
                                        'border-gray-200 text-gray-600 hover:border-gray-300': selectedSize !== '{{ $size }}'
                                    }">
                                {{ $size }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <hr class="border-gray-100 mb-6">

                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <div class="flex gap-8">
                        <button @click="activeTab = 'detail'" class="pb-3 font-bold text-sm border-b-2 transition-colors" :class="activeTab === 'detail' ? 'text-primary-500 border-primary-500' : 'text-gray-500 border-transparent hover:text-gray-700'">Detail Produk</button>
                        <button @click="activeTab = 'panduan'" class="pb-3 font-bold text-sm border-b-2 transition-colors" :class="activeTab === 'panduan' ? 'text-primary-500 border-primary-500' : 'text-gray-500 border-transparent hover:text-gray-700'">Panduan</button>
                        <button @click="activeTab = 'info'" class="pb-3 font-bold text-sm border-b-2 transition-colors" :class="activeTab === 'info' ? 'text-primary-500 border-primary-500' : 'text-gray-500 border-transparent hover:text-gray-700'">Info Penting</button>
                    </div>
                </div>

                <!-- Tab Content -->
                <div x-show="activeTab === 'detail'" class="space-y-4 text-sm text-gray-700 leading-relaxed">
                    <div class="grid grid-cols-2 gap-y-2 max-w-md mb-4">
                        <span class="text-gray-500">Kondisi</span>
                        <span class="font-medium text-gray-900">{{ $product->condition == 'new' ? 'Baru' : 'Bekas' }}</span>
                        <span class="text-gray-500">Min. Pemesanan</span>
                        <span class="font-medium text-gray-900">1 Buah</span>
                        <span class="text-gray-500">Etalase</span>
                        <a href="#" class="font-bold text-primary-500">Semua Etalase</a>
                    </div>
                    
                    <div class="prose prose-sm max-w-none text-gray-700">
                        {!! nl2br(e($product->description)) !!}
                    </div>
                </div>

                <hr class="border-gray-100 my-6">

                <!-- Store Info -->
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-gray-100 overflow-hidden border border-gray-200">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($product->store->name) }}&background=random" alt="" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <h3 class="font-bold text-gray-900 flex items-center gap-1">
                                {{ $product->store->name }}
                                <svg class="w-4 h-4 text-primary-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            </h3>
                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                <span class="text-primary-500 font-bold">.</span>
                                <span>Online 7 menit lalu</span>
                                <span class="text-gray-300">•</span>
                                <span>{{ $product->store->city ?? 'Jakarta Pusat' }}</span>
                            </div>
                        </div>
                    </div>
                    <button class="px-4 py-1.5 border border-primary-500 text-primary-500 font-bold text-sm rounded-lg hover:bg-primary-50 transition-colors">
                        Follow
                    </button>
                </div>

                <hr class="border-gray-100 my-6">

                <!-- Shipping Info -->
                <div>
                    <h3 class="font-bold text-gray-900 mb-3">Pengiriman</h3>
                    <div class="flex gap-3 text-sm">
                        <div class="text-gray-500">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        </div>
                        <div>
                            <div class="text-gray-700 mb-1">Dikirim dari <span class="font-bold">{{ $product->store->city ?? 'Jakarta Pusat' }}</span></div>
                            <div class="flex items-center gap-2">
                                <span class="text-gray-500">Ongkir mulai</span>
                                <span class="font-bold text-gray-900">Rp10.000</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Column: Action Card (3 cols) -->
            <div class="lg:col-span-3">
                <div class="sticky top-24">
                    <div class="border border-gray-200 rounded-xl p-4 shadow-sm">
                        <h3 class="font-bold text-gray-900 mb-4">Atur jumlah dan catatan</h3>
                        
                        <!-- Selected Variant -->
                        <div class="flex items-center gap-2 mb-4 bg-gray-50 p-2 rounded-lg" x-show="selectedSize">
                            <span class="text-sm text-gray-600">Ukuran: <span class="font-bold text-gray-900" x-text="selectedSize"></span></span>
                        </div>

                        <!-- Quantity -->
                        <div class="flex items-center gap-4 mb-4">
                            <div class="flex items-center border border-gray-300 rounded-lg">
                                <button @click="quantity > 1 ? quantity-- : null" class="px-3 py-1 text-gray-500 hover:text-primary-500 disabled:opacity-50" :disabled="quantity <= 1">-</button>
                                <input type="text" x-model="quantity" class="w-12 text-center text-sm border-none focus:ring-0 p-1 font-bold text-gray-700" readonly>
                                <button @click="quantity < {{ $product->stock }} ? quantity++ : null" class="px-3 py-1 text-primary-500 hover:text-primary-600 disabled:opacity-50" :disabled="quantity >= {{ $product->stock }}">+</button>
                            </div>
                            <span class="text-sm text-gray-500">Stok: <span class="font-bold text-gray-900">{{ $product->stock }}</span></span>
                        </div>

                        <!-- Subtotal -->
                        <div class="flex items-center justify-between mb-6">
                            <span class="text-gray-500 text-sm">Subtotal</span>
                            <span class="text-lg font-bold text-gray-900" x-text="'Rp' + ({{ $product->price }} * quantity).toLocaleString('id-ID')"></span>
                        </div>

                        <!-- Buttons -->
                        <div class="space-y-3">
                            <button @click="addToCart()" class="w-full py-2.5 bg-primary-500 text-white font-bold rounded-lg hover:bg-primary-600 transition-colors flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Keranjang
                            </button>
                            <button class="w-full py-2.5 border border-primary-500 text-primary-500 font-bold rounded-lg hover:bg-primary-50 transition-colors">
                                Beli Langsung
                            </button>
                        </div>

                        <div class="mt-4 flex items-center justify-center gap-4 text-sm text-gray-500 font-medium">
                            <button class="flex items-center gap-1 hover:text-primary-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                                Chat
                            </button>
                            <span class="text-gray-300">|</span>
                            <button class="flex items-center gap-1 hover:text-primary-500" onclick="toggleWishlist({{ $product->id }})">
                                <svg class="w-4 h-4 {{ in_array($product->id, session('wishlist', [])) ? 'fill-red-500 text-red-500' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                Wishlist
                            </button>
                            <span class="text-gray-300">|</span>
                            <button class="flex items-center gap-1 hover:text-primary-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                                Share
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews Section -->
        <div class="mt-12 border-t border-gray-100 pt-8">
            <h2 class="font-bold text-lg text-gray-900 mb-6">Ulasan Pembeli</h2>
            <div class="flex items-start gap-12">
                <!-- Rating Summary -->
                <div class="flex items-center gap-4">
                    <div class="text-6xl font-bold text-gray-900">4.9<span class="text-lg text-gray-500 font-normal">/5.0</span></div>
                    <div class="space-y-1">
                        <div class="flex items-center gap-1 text-yellow-400">
                            @for($i=0; $i<5; $i++) <svg class="w-5 h-5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg> @endfor
                        </div>
                        <div class="text-sm text-gray-500 font-medium">100% pembeli merasa puas</div>
                        <div class="text-xs text-gray-400">32 rating • 18 ulasan</div>
                    </div>
                </div>
                
                <!-- Rating Bars (Visual Only) -->
                <div class="flex-1 max-w-xs space-y-1">
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="w-3">5</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-primary-500 w-[95%]"></div></div>
                        <span>30</span>
                    </div>
                    <div class="flex items-center gap-2 text-xs text-gray-500">
                        <span class="w-3">4</span>
                        <div class="flex-1 h-2 bg-gray-100 rounded-full overflow-hidden"><div class="h-full bg-primary-500 w-[5%]"></div></div>
                        <span>2</span>
                    </div>
                    <!-- ... other bars empty ... -->
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('productDetail', () => ({
            activeImage: '{{ $product->productImages->first() ? asset("storage/" . $product->productImages->first()->image) : "" }}',
            activeTab: 'detail',
            selectedSize: null,
            quantity: 1,

            addToCart() {
                if (!this.selectedSize) {
                    alert('Silakan pilih ukuran terlebih dahulu');
                    return;
                }
                
                fetch('{{ route("cart.add") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        product_id: {{ $product->id }},
                        quantity: this.quantity,
                        note: 'Ukuran: ' + this.selectedSize
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Berhasil masuk keranjang!', 'success');
                        setTimeout(() => location.reload(), 1000);
                    } else {
                        showToast(data.message || 'Gagal menambahkan ke keranjang', 'error');
                    }
                })
                .catch(error => {
                    if (error.status === 401) {
                         window.location.href = '{{ route("login") }}';
                    } else {
                        showToast('Terjadi kesalahan', 'error');
                    }
                });
            }
        }))
    })

    function toggleWishlist(productId) {
        fetch('{{ route("wishlist.toggle") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({
                product_id: productId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast(data.message, 'success');
                location.reload();
            }
        })
        .catch(error => {
            if (error.status === 401) {
                 window.location.href = '{{ route("login") }}';
            }
        });
    }

    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.className = `px-6 py-4 rounded-lg shadow-lg animate-slide-up fixed bottom-4 right-4 z-50 ${
            type === 'success' ? 'bg-gray-800' : 'bg-red-500'
        } text-white font-medium text-sm`;
        toast.textContent = message;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>
@endpush
@endsection
