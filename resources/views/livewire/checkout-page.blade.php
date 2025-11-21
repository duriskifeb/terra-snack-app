<div>

    <div class="p-5">
        <a href="{{ route('cart') }}" wire:navigate class="text-gray-400 font-semibold">&lt; Kembali ke Keranjang</a>
        <h1 class="text-3xl font-bold mt-2">Checkout Pembayaran</h1>
    </div>

    @if ($order)
        <div class="p-4 space-y-6 pb-24">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold mb-4 text-center">Scan QRIS untuk Membayar</h2>

                <div class="flex justify-center mb-4">
                    <img src="{{ asset('assets/qris_dana.jpeg') }}" alt="QRIS DANA"
                        class="w-64 h-64 border-4 border-gray-200 rounded-lg">
                </div>

                <div class="text-center p-4 bg-yellow-100 border border-yellow-300 rounded-lg">
                    <p class="font-semibold text-gray-800">Total Pembayaran:</p>
                    <p class="text-4xl font-bold text-red-600 my-2">
                        Rp {{ number_format($this->totalPrice, 0, ',', '.') }}
                    </p>
                    <p class="text-sm text-gray-700 mt-3">
                        PENTING: Mohon transfer sesuai nominal diatas, lalu unggah bukti pembayaran.
                    </p>
                </div>
            </div>

            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="text-lg font-semibold mb-3">Rincian Pesanan</h3>
                <div class="space-y-2 text-gray-700">
                    <div class="flex justify-between">
                        <span>Subtotal ({{ $cart->items->sum('quantity') }} barang)</span>
                        <span>Rp {{ number_format($this->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Biaya Packaging</span>
                        <span>Rp {{ number_format($this->packagingFeeTotal, 0, ',', '.') }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between font-bold text-lg">
                        <span>Total</span>
                        <span>Rp {{ number_format($this->totalPrice, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            @if($order->payment_status == 'unpaid')
                <div class="bg-white p-6 rounded-lg shadow-md">
                    <h3 class="text-lg font-semibold mb-4">Unggah Bukti Pembayaran</h3>

                    <form wire:submit.prevent="uploadPaymentProof" class="flex flex-col items-center gap-4">

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
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror

                        <button type="submit"
                            class="w-full max-w-xs bg-[#E13220] text-white font-semibold py-2 px-4 rounded-lg shadow hover:bg-red-700 transition-colors">
                            Upload Bukti
                        </button>
                    </form>

                    <p class="text-sm text-gray-500 mt-2 text-center">
                        Setelah mengunggah bukti, admin akan memverifikasi dan memperbarui status pembayaran.
                    </p>
                </div>
            @endif
        </div>
    @else
        <div class="p-5 text-center">
            <p class="text-gray-600">Memuat rincian checkout...</p>
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