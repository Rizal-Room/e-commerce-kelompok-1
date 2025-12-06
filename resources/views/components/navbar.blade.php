{{-- Bandage Style Navbar --}}
<nav class="bg-white shadow-sm" x-data="{ mobileMenuOpen: false }">
    {{-- Main Navigation --}}
    <div class="border-b border-gray-200">
        <div class="container-custom">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex-shrink-0">
                    <h1 class="text-2xl font-extrabold text-text-primary">Bandage</h1>
                </a>

                {{-- Desktop Menu --}}
                <nav class="hidden lg:flex items-center gap-8">
                    <a href="{{ route('home') }}" class="text-text-secondary hover:text-primary-500 font-bold text-sm transition">Home</a>
                    <a href="{{ route('products.index') }}" class="text-text-secondary hover:text-primary-500 font-bold text-sm transition">Shop</a>
                    
                    {{-- Categories Dropdown --}}
                    <div x-data="{ open: false }" @click.away="open = false" class="relative">
                        <button @click="open = !open" class="text-text-secondary hover:text-primary-500 font-bold text-sm transition flex items-center gap-1">
                            Categories
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        
                        <div x-show="open" x-cloak class="absolute left-0 mt-2 w-64 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                            {{-- Men Category --}}
                            <div class="px-4 py-2">
                                <a href="{{ route('products.index', ['category' => 1]) }}" class="font-bold text-gray-900 hover:text-primary-500">Men</a>
                                <div class="ml-4 mt-1 space-y-1">
                                    <a href="{{ route('products.index', ['category' => 2]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Shirts</a>
                                    <a href="{{ route('products.index', ['category' => 3]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Pants</a>
                                    <a href="{{ route('products.index', ['category' => 4]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Jackets</a>
                                    <a href="{{ route('products.index', ['category' => 5]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Shoes</a>
                                    <a href="{{ route('products.index', ['category' => 6]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Accessories</a>
                                </div>
                            </div>
                            <hr class="my-2">
                            {{-- Women Category --}}
                            <div class="px-4 py-2">
                                <a href="{{ route('products.index', ['category' => 7]) }}" class="font-bold text-gray-900 hover:text-primary-500">Women</a>
                                <div class="ml-4 mt-1 space-y-1">
                                    <a href="{{ route('products.index', ['category' => 8]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Dresses</a>
                                    <a href="{{ route('products.index', ['category' => 9]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Tops</a>
                                    <a href="{{ route('products.index', ['category' => 10]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Pants</a>
                                    <a href="{{ route('products.index', ['category' => 11]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Shoes</a>
                                    <a href="{{ route('products.index', ['category' => 12]) }}" class="block text-sm text-gray-600 hover:text-primary-500">Accessories</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @auth
                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('admin.dashboard') }}" class="text-text-secondary hover:text-primary-500 font-bold text-sm transition">Admin Panel</a>
                        @endif
                        @if(auth()->user()->store)
                            <a href="{{ route('seller.dashboard') }}" class="text-text-secondary hover:text-primary-500 font-bold text-sm transition">Dashboard</a>
                        @endif
                    @endauth
                </nav>

                {{-- Right Section --}}
                <div class="flex items-center gap-6">
                    {{-- Search (Desktop) --}}
                    <div class="hidden lg:flex items-center gap-2">
                        <form action="{{ route('products.search') }}" method="GET" class="relative">
                            <input 
                                type="text" 
                                name="q" 
                                value="{{ request('q') }}"
                                placeholder="Search..."
                                class="pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary-500 w-64">
                            <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-primary-500">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </button>
                        </form>
                    </div>

                    {{-- Auth & Actions --}}
                    <div class="flex items-center gap-4">
                        {{-- Auth Links --}}
                        @auth
                            {{-- User Dropdown --}}
                            <div x-data="{ open: false }" class="relative">
                                <button @click="open = !open" class="flex items-center gap-2 text-primary-500 hover:text-primary-600 font-bold text-sm transition">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    <span class="hidden lg:inline">{{ auth()->user()->name }}</span>
                                    <svg class="w-4 h-4 hidden lg:inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </button>
                                
                                <div x-show="open" @click.away="open = false" x-cloak class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-2 z-50">
                                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                    <a href="{{ route('transactions.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">My Orders</a>
                                    @if(auth()->user()->store)
                                        <a href="{{ route('seller.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Seller Dashboard</a>
                                    @else
                                        <a href="{{ route('seller.register') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Become Seller</a>
                                    @endif
                                    @if(auth()->user()->isAdmin())
                                        <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin Panel</a>
                                    @endif
                                    <hr class="my-2">
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">Logout</button>
                                    </form>
                                </div>
                            </div>
                        @else
                            {{-- Login Button --}}
                            <a href="{{ route('login') }}" class="flex items-center gap-1 text-primary-500 hover:text-primary-600 font-bold text-sm transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                </svg>
                                <span class="hidden lg:inline">Login</span>
                            </a>
                            {{-- Register Button --}}
                            <a href="{{ route('register') }}" class="flex items-center gap-1 bg-primary-500 text-white hover:bg-primary-600 px-4 py-2 rounded-md font-bold text-sm transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                                </svg>
                                <span class="hidden lg:inline">Register</span>
                            </a>
                        @endauth

                        {{-- Wishlist --}}
                        <a href="{{ route('wishlist.index') }}" class="text-primary-500 hover:text-primary-600 relative transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00- 6.364 0z"/>
                            </svg>
                        </a>

                        {{-- Cart --}}
                        <a href="{{ route('cart.index') }}" class="text-primary-500 hover:text-primary-600 relative transition flex items-center gap-1">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            @php $cartCount = array_sum(array_column(session('cart', []), 'quantity')); @endphp
                            @if($cartCount > 0)
                                <span class="hidden lg:inline text-sm font-bold">({{ $cartCount }})</span>
                                <span class="lg:hidden absolute -top-2 -right-2 bg-primary-500 text-white text-xs font-bold w-5 h-5 rounded-full flex items-center justify-center">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>

                    {{-- Mobile Menu Toggle --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="lg:hidden text-gray-700 p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         x-cloak
         class="lg:hidden border-b border-gray-200 bg-white">
        <div class="container-custom py-4 space-y-3">
            {{-- Mobile Search --}}
            <form action="{{ route('products.search') }}" method="GET" class="relative">
                <input 
                    type="text" 
                    name="q" 
                    placeholder="Search products..."
                    class="w-full pl-4 pr-10 py-2 text-sm border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-primary-500">
                <button type="submit" class="absolute right-3 top-1/2 -translate-y-1/2 text-primary-500">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </button>
            </form>

            {{-- Mobile Links --}}
            <div class="space-y-2">
                <a href="{{ route('home') }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-2 transition">Home</a>
                <a href="{{ route('products.index') }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-2 transition">Shop</a>
                
                {{-- Categories --}}
                <div class="py-2">
                    <p class="text-xs font-bold text-gray-500 uppercase mb-2">Categories</p>
                    <a href="{{ route('products.index', ['category' => 1]) }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-1 transition">Men</a>
                    <a href="{{ route('products.index', ['category' => 7]) }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-1 transition">Women</a>
                </div>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-2 transition">Admin Panel</a>
                    @endif
                    @if(auth()->user()->store)
                        <a href="{{ route('seller.dashboard') }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-2 transition">My Dashboard</a>
                    @endif
                    <a href="{{ route('transactions.index') }}" class="block text-text-secondary hover:text-primary-500 font-bold text-sm py-2 transition">My Orders</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left text-danger-500 hover:text-danger-600 font-bold text-sm py-2 transition">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block text-primary-500 hover:text-primary-600 font-bold text-sm py-2 transition">Login</a>
                    <a href="{{ route('register') }}" class="block bg-primary-500 text-white hover:bg-primary-600 font-bold text-sm py-2 transition rounded-md text-center">Register</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
