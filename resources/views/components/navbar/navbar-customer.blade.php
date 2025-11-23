<nav class=" w-full mt-4" x-data="{ open: false }" wire:ignore>
    <div class="max-w-content mx-auto px-mobile-gutter">
        <ul class="flex justify-between items-center">
            <li>
                <a href="{{ route('products.list')  }}">
                    <img src="{{ asset('assets/logo.webp') }}" alt="logo" class="w-12">
                </a>
            </li>
            <li>
                <button @click="open = true"
                    class="text-2xl bg-[#E13220] rounded-full text-white p-[0.30rem] w-10 h-10 flex items-center justify-center">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </li>
        </ul>
        <div class="w-full h-1 bg-[#CD301F] mt-4"></div>
    </div>

    <div x-show="open" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" @click="open = false"
        class="fixed inset-0 bg-black bg-opacity-50 max-w-content mx-auto z-20" style="display: none;"></div>

    <div class="fixed mx-auto max-w-content inset-0 flex justify-end items-start z-50 pointer-events-none"
        aria-hidden="true">
        <div x-show="open" x-transition:enter="ease-out duration-300"
            x-transition:enter-start="translate-x-10 opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
            x-transition:leave="ease-in duration-200" x-transition:leave-start="translate-x-0 opacity-100"
            x-transition:leave-end="translate-x-10 opacity-0" class=" h-full  bg-white  p-6 pointer-events-auto"
            style="display: none;">
            <div class="flex justify-end mb-8">
                <button @click="open = false"
                    class="text-2xl bg-[#E13220] rounded-full text-white p-[0.30rem] w-10 h-10 flex items-center justify-center">
                    <i class="fa-solid fa-times"></i>
                </button>
            </div>

            <ul class="flex flex-col gap-6 text-lg font-medium text-gray-700">
                <li>
                    <a href="{{ route('products.list')  }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-burger text-[#E13220] w-6 text-center"></i>
                        {{-- <i class="fa-solid fa-cart-shopping text-[#E13220] w-6 text-center"></i> --}}
                        <span>Products</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('cart')  }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-cart-shopping text-[#E13220] w-6 text-center"></i>
                        <span>Keranjang Saya</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('customer-history.list')  }}"
                        class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-file-invoice text-[#E13220] w-6 text-center"></i>
                        <span>Riwayat Transaksi</span>
                    </a>
                </li>
                {{-- <li>
                    <a href="" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100">
                        <i class="fa-solid fa-user text-[#E13220] w-6 text-center"></i>
                        <span>Akun</span>
                    </a>
                </li> --}}

                <li class="mt-8 border-t pt-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-100 w-full text-left">
                            <i class="fa-solid fa-arrow-right-from-bracket text-[#E13220] w-6 text-center"></i>
                            <span>Keluar</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>