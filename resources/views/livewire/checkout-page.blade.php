<div>
        <div class="mt-5 mb-8">
            <div class="flex items-center justify-center gap-4">
                <span class="text-2xl text-[#E13220]">
                    <i class="fa-solid fa-money-bill"></i>
                </span>
                <h1 class="text-lg font-bold border-b-2 border-[#E13220] text-[#E13220]">Checkout</h1>
            </div>
        </div>

        @if ($order)
            <div class="p-5 space-y-5">

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                    <div class="flex items-start gap-3">
                        <div class="bg-red-50 p-2 rounded-full text-[#E13220]">
                            <i class="fa-solid fa-map"></i>
                        </div>
                        <div>
                            <h2 class="font-bold text-gray-800 text-sm mb-1">Pickup Location</h2>
                            <p class="text-xs text-gray-500 leading-relaxed">
                                Jl. Ketintang No.156, Ketintang, <br> Kec. Gayungan, Surabaya, Jawa Timur 60231
                            </p>
                        </div>
                    </div>
                    <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                        class="mt-4 flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-700 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                        <i class="fa-solid fa-map"></i> Buka di Peta
                    </a>
                </div>

                @foreach($order->items as $item)
                    <div class="bg-white p-4 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)] flex gap-4">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-gray-800">{{ $item->product_name }}</h3>

                            @if($item->optionValues && $item->optionValues->count() > 0)
                                <div class="mt-2 space-y-1">
                                    @foreach($item->optionValues as $option)
                                        <p class="text-xs text-gray-500">
                                            <span class="font-medium text-gray-400">{{ $option->customizationOption->name ?? 'N/A' }}:</span>
                                            {{ $option->name }}
                                        </p>
                                    @endforeach
                                </div>
                            @endif

                            <div class="mt-3 font-bold text-gray-900">
                                Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                            </div>
                        </div>

                        <div class="flex flex-col justify-between items-end">
                            <img src="{{ $item->product->image_url ?? asset('assets/snack-placeholder.png') }}"
                                class="w-20 h-24 object-cover rounded-lg shadow-sm">

                            <div class="text-sm font-semibold text-gray-600 mt-2">
                                x {{ $item->quantity }}
                            </div>
                        </div>
                    </div>
                @endforeach

                @if($order->payment_status == 'unpaid')
                    <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)]">
                        <h3 class="font-bold text-gray-800 mb-4">Pembayaran (QRIS)</h3>

                        <div class="flex flex-col items-center mb-6">
                            <img src="{{ asset('assets/qris.jpeg') }}" alt="QRIS"
                                class="object-contain border-2 border-dashed border-gray-200 rounded-xl p-2">
                            <p class="text-xs text-gray-400 mt-2">Scan QRIS di atas untuk membayar</p>
                        </div>

                        <form class="space-y-3">
                            <div
                                class="border-2 border-dashed border-gray-300 rounded-xl bg-gray-50 p-4 text-center relative hover:bg-gray-100 transition cursor-pointer">
                                <input type="file" wire:model="paymentProof" accept="image/*"
                                  value="{{old('')  }}"  class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">

                                @if ($paymentProof)
                                    <img src="{{ $paymentProof->temporaryUrl() }}" class="h-32 mx-auto object-contain rounded-lg">
                                    <p class="text-xs text-green-600 mt-2 font-semibold">File terpilih. Klik tombol di bawah.</p>
                                @else
                                    <i class="fa-solid fa-camera text-gray-400 text-2xl mb-2"></i>
                                    <p class="text-xs text-gray-500 font-medium">Tap untuk upload bukti transfer</p>
                                @endif
                            </div>
                            @error('paymentProof') <span class="text-red-500 text-xs block text-center">{{ $message }}</span>
                            @enderror
                        </form>
                    </div>
                @endif

                <div class="bg-white p-5 rounded-2xl shadow-[0_2px_8px_rgba(0,0,0,0.05)] space-y-2 mb-20">
                    <h3 class="font-bold text-gray-800 mb-3">Rincian Pembayaran</h3>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between text-sm text-gray-500">
                        <span>Biaya Packaging</span>
                        <span>Rp {{ number_format($packagingFeeTotal, 0, ',', '.') }}</span>
                    </div>
                    <div
                        class="border-t border-dashed border-gray-200 my-2 pt-2 flex justify-between font-bold text-gray-900 text-lg">
                        <span>Total</span>
                        <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            @if($order->payment_status == 'unpaid')
                <div
                    class="sticky  py-10 px-mobile-gutter p-4 bottom-0 max-w-content mx-auto  left-0 right-0 w-full bg-white border-t-4 border-[#E13220] rounded-t-2xl shadow-[0_-4px_10px_rgba(0,0,0,0.05)]">
                    <div class="max-w-lg mx-auto flex items-center justify-between gap-4">
                        <div class="flex flex-col">
                            <span class="text-xs text-gray-400">Total Pembayaran</span>
                            <span class="text-xl font-bold text-[#E13220]">
                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                            </span>
                        </div>

                        <button type="button" wire:click="uploadPaymentProof" wire:loading.attr="disabled"
                            class="bg-[#E13220] text-white px-8 py-3 rounded-full font-bold text-sm shadow-lg shadow-red-200 hover:bg-red-700 transition flex items-center gap-2 disabled:opacity-50">
                            <span wire:loading.remove wire:target="uploadPaymentProof">
                                Kirim Bukti
                            </span>
                            <span wire:loading wire:target="uploadPaymentProof">
                                <i class="fa-solid fa-spinner animate-spin"></i> Sending...
                            </span>
                            <i wire:loading.remove wire:target="uploadPaymentProof" class="fa-solid fa-arrow-right"></i>
                        </button>
                    </div>
                </div>
            @else
                <div class="fixed bottom-0 left-0 right-0 bg-green-50 border-t border-green-100 p-5 pb-8 z-30">
                    <div class="max-w-lg mx-auto text-center">
                        <p class="text-green-700 font-bold mb-2">
                            <i class="fa-solid fa-check-circle"></i> Bukti Terkirim
                        </p>
                        <p class="text-xs text-green-600">Menunggu konfirmasi admin.</p>
                    </div>
                </div>
            @endif

        @else
            <div class="flex items-center justify-center h-screen text-gray-400">
                <i class="fa-solid fa-circle-notch animate-spin text-3xl"></i>
            </div>
        @endif
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