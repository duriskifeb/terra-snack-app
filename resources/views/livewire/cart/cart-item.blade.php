<div class="bg-white p-4 rounded-2xl shadow-lg flex flex-col items-center relative">
    <button wire:click="removeItem" wire:loading.attr="disabled" wire:target="removeItem"
        class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition-colors z-10" aria-label="Hapus item">
        <i class="fa-solid fa-times fa-lg"></i>
    </button>

    @if ($cartItem->product)
        <img src="{{ $cartItem->product->image_url ?? 'https://placehold.co/300x300/e2e8f0/e2e8f0?text=Image' }}"
            alt="{{ $cartItem->product->name ?? 'Produk' }}" class="w-full h-24 object-contain mb-3" {{--
            onerror="this.src='https://placehold.co/300x300/e2e8f0/e2e8f0?text=Image';"> --}}
    @endif

    <h3 class="font-bold text-lg text-gray-900 text-center mb-1">
        {{ $cartItem->product->name ?? 'Nama Produk' }}
    </h3>

    <div class="text-center mb-3 min-h-[30px]">
        <p class="text-xs text-gray-500 leading-tight">
            Rincian :
            @if ($cartItem->optionValues->isNotEmpty())
                {{ $cartItem->optionValues->pluck('name')->join(', ') }}
            @else
                -
            @endif
        </p>
    </div>

    <p class="text-sm font-semibold text-gray-800 mb-4">
        {{ $cartItem->quantity }}x Rp {{ number_format($cartItem->unit_price, 0, ',', '.') }}
    </p>

    <a href="{{ route('product.customize', $cartItem->product_id) }}?cartItemId={{ $cartItem->id }}" wire:navigate
        class="w-full text-center text-sm font-medium text-[#E13220] border border-[#E13220] py-2 rounded-lg hover:bg-[#E13220] hover:text-white transition-colors">
        Ubah
    </a>
</div>

<script>
    document.addEventListener('livewire:initialized', () => {
        const showToast = (icon, message) => {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon,
                title: message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true,
                background: '#fff',
                color: '#333',
                customClass: {
                    popup: 'rounded-xl shadow-md',
                    title: 'font-medium'
                }
            });
        };
        Livewire.on('show-success', message => showToast('success', message));
        Livewire.on('show-error', message => showToast('error', message));
    });
</script>