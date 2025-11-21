<div class="relative duration-300 cursor-pointer hover:bg-[#E13220] bg-white p-4 rounded-xl shadow-lg flex justify-center flex-col items-center overflow-visible group">

    <img src="{{ $product->image_url }}"
         alt="{{ $product->name }}"
         class="w-40 h-40 object-contain -mt-24 z-10 drop-shadow-lg">

    <div class="mt-7 text-center">
        <h3 class="font-bold text-lg text-gray-900 group-hover:text-white">{{ $product->name }}</h3>
        <p class="text-base text-gray-700 group-hover:text-white">
            Rp {{ number_format($product->price, 0, ',', '.') }}
        </p>
    </div>

    @if ($product->customizationOptions->isNotEmpty())
        <a href="{{ route('product.customize', $product) }}" wire:navigate
           class="mt-4 w-full bg-[#E13220] group-hover:bg-white group-hover:text-[#E13220] text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors text-center">
           Tambahkan
        </a>
    @else
        <button wire:click="addToCart" wire:loading.attr="disabled"
                class="mt-4 w-full bg-[#E13220] text-white py-2 rounded-lg font-semibold hover:bg-red-700 transition-colors">
            Tambahkan
        </button>
    @endif
</div>
