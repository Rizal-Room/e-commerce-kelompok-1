@extends('layouts.customer')

@section('title', 'Biodata Diri')

@section('content')
<div class="container mx-auto px-4 lg:px-8 py-8">
    <div class="flex flex-col lg:flex-row gap-8">
        <!-- Left Sidebar -->
        <div class="w-full lg:w-64 flex-shrink-0 space-y-4">
            <!-- User Card -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm flex items-center gap-3">
                <div class="w-12 h-12 rounded-full bg-gray-100 overflow-hidden border border-gray-200">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" alt="{{ $user->name }}" class="w-full h-full object-cover">
                </div>
                <div class="overflow-hidden">
                    <h3 class="font-bold text-gray-800 truncate">{{ $user->name }}</h3>
                    <div class="flex items-center gap-1 text-xs text-gray-500">
                        <svg class="w-3 h-3 text-green-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Member Silver</span>
                    </div>
                </div>
            </div>

            <!-- Wallet Summary (Mock) -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm space-y-3">
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded bg-blue-100 text-blue-600 flex items-center justify-center font-bold text-xs">G</div>
                        <span class="font-semibold text-gray-700">Gopay</span>
                    </div>
                    <span class="text-primary-500 font-bold text-xs cursor-pointer">Aktifkan</span>
                </div>
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <div class="w-6 h-6 rounded bg-yellow-100 text-yellow-600 flex items-center justify-center font-bold text-xs">C</div>
                        <span class="font-semibold text-gray-700">Coins</span>
                    </div>
                    <span class="text-gray-500 text-xs">0 Coins</span>
                </div>
            </div>

            <!-- Navigation Menu -->
            <div class="bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
                <div class="p-4 border-b border-gray-100">
                    <h4 class="font-bold text-gray-800">Kotak Masuk</h4>
                    <div class="mt-2 space-y-1">
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Chat</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Ulasan</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Pesan Bantuan</a>
                    </div>
                </div>
                <div class="p-4 border-b border-gray-100">
                    <h4 class="font-bold text-gray-800">Pembelian</h4>
                    <div class="mt-2 space-y-1">
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Menunggu Pembayaran</a>
                        <a href="{{ route('transactions.index') }}" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Daftar Transaksi</a>
                    </div>
                </div>
                <div class="p-4">
                    <h4 class="font-bold text-gray-800">Profil Saya</h4>
                    <div class="mt-2 space-y-1">
                        <a href="{{ route('wishlist.index') }}" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Wishlist</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Toko Favorit</a>
                        <a href="#" class="block text-sm text-gray-600 hover:text-primary-500 py-1">Pengaturan</a>
                        <form method="POST" action="{{ route('logout') }}" class="mt-2">
                            @csrf
                            <button type="submit" class="text-sm text-red-500 hover:text-red-600 font-medium py-1">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="flex-1 bg-white rounded-lg border border-gray-200 shadow-sm overflow-hidden">
            <!-- Tabs -->
            <div class="border-b border-gray-200 overflow-x-auto no-scrollbar">
                <div class="flex px-6 min-w-max">
                    <a href="#" class="px-4 py-4 text-sm font-bold text-primary-500 border-b-2 border-primary-500">Biodata Diri</a>
                    <a href="#" class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Daftar Alamat</a>
                    <a href="#" class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Pembayaran</a>
                    <a href="#" class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Rekening Bank</a>
                    <a href="#" class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Notifikasi</a>
                    <a href="#" class="px-4 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300">Keamanan</a>
                </div>
            </div>

            <!-- Tab Content: Biodata Diri -->
            <div class="p-6 lg:p-8">
                <div class="flex flex-col lg:flex-row gap-8">
                    <!-- Photo Section -->
                    <div class="w-full lg:w-72 flex-shrink-0">
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-100 flex flex-col items-center">
                            <div class="w-48 h-48 rounded-lg bg-gray-200 overflow-hidden mb-4 shadow-inner">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&size=256" alt="{{ $user->name }}" class="w-full h-full object-cover">
                            </div>
                            <button class="w-full py-2 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors mb-3">
                                Pilih Foto
                            </button>
                            <p class="text-xs text-gray-500 text-center leading-relaxed">
                                Besar file: maksimum 10.000.000 bytes (10 Megabytes). Ekstensi file yang diperbolehkan: .JPG .JPEG .PNG
                            </p>
                        </div>
                        
                        <div class="mt-4 space-y-3">
                            <button class="w-full py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors text-left px-4 flex items-center justify-between">
                                <span>Ubah Kata Sandi</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="w-full py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors text-left px-4 flex items-center justify-between">
                                <span>PIN Tokopedia</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                            <button class="w-full py-2.5 border border-gray-300 rounded-lg text-sm font-bold text-gray-700 hover:bg-gray-50 transition-colors text-left px-4 flex items-center justify-between">
                                <span>Verifikasi Instan</span>
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form Section -->
                    <div class="flex-1 space-y-8">
                        <!-- Ubah Biodata Diri -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-4">Ubah Biodata Diri</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                                    <label class="text-sm text-gray-500">Nama</label>
                                    <div class="lg:col-span-2 flex items-center justify-between group">
                                        <span class="text-sm text-gray-800 font-medium">{{ $user->name }}</span>
                                        <button class="text-primary-500 text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">Ubah</button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                                    <label class="text-sm text-gray-500">Tanggal Lahir</label>
                                    <div class="lg:col-span-2 flex items-center justify-between group">
                                        <span class="text-sm text-primary-500 cursor-pointer">Tambah Tanggal Lahir</span>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                                    <label class="text-sm text-gray-500">Jenis Kelamin</label>
                                    <div class="lg:col-span-2 flex items-center justify-between group">
                                        <span class="text-sm text-primary-500 cursor-pointer">Tambah Jenis Kelamin</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ubah Kontak -->
                        <div>
                            <h3 class="font-bold text-gray-800 mb-4">Ubah Kontak</h3>
                            <div class="space-y-4">
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                                    <label class="text-sm text-gray-500">Email</label>
                                    <div class="lg:col-span-2 flex items-center justify-between group">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-800 font-medium">{{ $user->email }}</span>
                                            <span class="px-2 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold rounded">Terverifikasi</span>
                                        </div>
                                        <button class="text-primary-500 text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">Ubah</button>
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center">
                                    <label class="text-sm text-gray-500">Nomor HP</label>
                                    <div class="lg:col-span-2 flex items-center justify-between group">
                                        <div class="flex items-center gap-2">
                                            <span class="text-sm text-gray-800 font-medium">081234567890</span>
                                            <span class="px-2 py-0.5 bg-green-100 text-green-600 text-[10px] font-bold rounded">Terverifikasi</span>
                                        </div>
                                        <button class="text-primary-500 text-sm font-bold opacity-0 group-hover:opacity-100 transition-opacity">Ubah</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
