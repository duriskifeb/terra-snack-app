<div class="p-6 max-w-lg mx-auto space-y-6 flex flex-col justify-center items-center">
    <div class="flex items-center text-[#E13220] gap-4">
        <span class="fa-solid fa-upload"></span>
        <h1 class="text-xl font-bold text-center ">Upload Bukti Pembayaran</h1>
    </div>

    <x-order.card class="w-full max-w-xs space-y-3 text-center">

        <x-order.label icon="fa-solid fa-receipt">
            Ringkasan Pesanan
        </x-order.label>

        <p class="text-sm text-gray-600">
            <span class="font-semibold text-gray-700">Invoice:</span> #{{ $order->id }}
        </p>

        <p class="text-sm text-gray-600">
            <span class="font-semibold text-gray-700">Total:</span>
            Rp {{ number_format($order->total_price, 0, ',', '.') }}
        </p>

        <div class="border-t pt-2 space-y-1">
            <p class="text-sm font-semibold text-gray-600">Produk:</p>

            @foreach ($order->items as $item)
                <p class="text-sm text-gray-500">
                    {{ $item->product_name ?? $item->product->name }} × {{ $item->quantity }}
                </p>
            @endforeach
        </div>

    </x-order.card>



    <div class="flex flex-col items-center mb-6">
        <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS"
            class="object-contain border-2 border-dashed border-gray-200 rounded-xl p-2">
        <p class="text-xs text-gray-400 mt-2">Scan QRIS di atas untuk membayar</p>
    </div>

    <form class="w-full space-y-4 flex flex-col items-center">

        <label
            class="w-full max-w-xs flex flex-col items-center px-4 py-6 bg-white text-blue rounded-lg shadow-md tracking-wide uppercase border border-gray-300 cursor-pointer hover:bg-gray-100 transition-colors text-center">
            <i class="fa-solid fa-upload text-2xl mb-2 text-red-500"></i>
            <span class="text-sm font-medium text-gray-700">Pilih file bukti pembayaran</span>
            <input type="file" wire:model="paymentProof" accept="image/*" class="hidden" />
        </label>

        @if ($paymentProof)
            <div class="w-full max-w-xs mt-2">
                <p class="text-sm text-gray-500 mb-1 text-center">Preview:</p>
                <img src="{{ $paymentProof->temporaryUrl() }}" alt="Preview Bukti"
                    class="w-full h-64 object-contain border rounded-lg shadow-sm">
            </div>
        @endif

        @error('paymentProof')
            <span class="text-red-500 text-sm text-center w-full max-w-xs">{{ $message }}</span>
        @enderror

        <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
            wire:loading.class="opacity-75 cursor-not-allowed" wire:target="uploadPaymentProof"
            class="w-full max-w-xs bg-[#E13220] text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-red-700 transition-colors flex items-center justify-center space-x-2">

            <span wire:loading wire:target="uploadPaymentProof">
                <i class="fa-solid fa-spinner animate-spin"></i>
            </span>
            <span wire:loading wire:target="uploadPaymentProof">
                Mengupload...
            </span>
            <span wire:loading.remove wire:target="uploadPaymentProof">
                Upload Bukti
            </span>
        </button>

    </form>
</div>