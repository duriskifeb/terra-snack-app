<div>
    <div class="mt-5 mb-8">
        <div class="flex items-center justify-center gap-4">
            <span class="text-2xl text-[#E13220]">
                <i class="fa-solid fa-cart-shopping"></i>
            </span>
            <p class="text-[#E13220] font-semibold text-2xl">
                Keranjang
            </p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-4 pb-40">
        @if ($cart && $cart->items->isNotEmpty())
            @foreach ($cart->items as $item)
                <livewire:cart.cart-item :cartItem="$item" :key="$item->id" />
            @endforeach
        @else
            <p class="col-span-2 text-center text-gray-500 mt-10">Keranjang Anda kosong.</p>
        @endif
    </div>

    <div
        class="fixed py-10 flex flex-col gap-8 bottom-0 max-w-content mx-auto px-mobile-gutter left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">

        <div>
            <div class="flex justify-between items-center text-xs  text-gray-700 mb-2">
                <span class="font-medium">Total Barang</span>
                <span class="text-[#8F8F8F]">{{ $cart->items->sum('quantity') }}</span>
            </div>
            <div class="flex justify-between items-center text-xs  text-black mb-4">
                <span class="font-bold">Total Yang Harus Dibayarkan</span>
                <span class="text-[#8F8F8F]">Rp {{ number_format($this->total, 0, ',', '.') }}</span>
            </div>
        </div>

        <div>
            <a href="#"
                class="block w-full text-sm text-center bg-[#E13220] text-white font-semibold py-2 rounded-lg shadow-md hover:bg-red-700 transition-colors">
                Lanjutkan Ke Pembayaran
            </a>

            <a href="{{ route('products.list') }}" wire:navigate
                class="block text-center text-gray-500 font-medium mt-3">
                <i class="fa-solid fa-chevron-left fa-xs mr-1"></i>
                Kembali
            </a>
        </div>

    </div>
</div>