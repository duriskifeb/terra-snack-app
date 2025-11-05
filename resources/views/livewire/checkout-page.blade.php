<div x-data="{
        snapToken: @entangle('snapToken'),
        initSnap() {
            // Watch for snapToken to be set by Livewire
            this.$watch('snapToken', token => {
                if (token) {
                    window.snap.pay(token, {
                        onSuccess: function(result){
                            /* You mayImplement client-side logic here */
                            console.log(result);
                            // Redirect to a success page or back to cart
                            window.location.href = '{{ route('products.list') }}'; 
                        },
                        onPending: function(result){
                            /* You may implement client-side logic here */
                            console.log(result);
                            window.location.href = '{{ route('products.list') }}'; 
                        },
                        onError: function(result){
                            /* You may implement client-side logic here */
                            console.log(result);
                            alert('Payment failed. Please try again.');
                        },
                        onClose: function(){
                            /* You may implement client-side logic here */
                            alert('You closed the popup without finishing the payment.');
                        }
                    });
                }
            });
        }
    }"
    x-init="initSnap()"
>
    {{-- 1. Midtrans Snap.js Script --}}
    <script src="https://app.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    {{-- 2. Page Title --}}
    <div class="mt-5 mb-8">
        <div class="flex items-center justify-center gap-4">
            <span class="text-2xl text-[#E13220]">
                <i class="fa-solid fa-file-invoice-dollar"></i>
            </span>
            <p class="text-[#E13220] font-semibold text-2xl">
                Checkout
            </p>
        </div>
    </div>

    {{-- 3. Order Summary --}}
    <div class="bg-white p-6 rounded-2xl shadow-lg">
        <h3 class="text-lg font-semibold border-b pb-3 mb-3">Ringkasan Pesanan</h3>
        
        <div class="space-y-2">
            @if ($order)
                @foreach ($order->items as $item)
                    <div class="flex justify-between">
                        <span class="text-gray-600">{{ $item->product_name }} (x{{ $item->quantity }})</span>
                        <span class="font-medium">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</span>
                    </div>
                @endforeach
            @endif

            <div class="flex justify-between border-t pt-2">
                <span class="text-gray-600">Biaya Packaging</span>
                <span class="font-medium">Rp {{ number_format($packagingFeeTotal, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between text-xl font-bold text-black pt-3">
                <span>Total Pembayaran</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </div>
        </div>
    </div>

    {{-- 4. Pay Button --}}
    <div class="mt-8">
        <button 
            wire:click="generateSnapToken"
            wire:loading.attr="disabled"
            wire:target="generateSnapToken"
            class="w-full bg-[#E13220] text-white font-semibold py-3 rounded-lg shadow-md hover:bg-red-700 transition-colors"
        >
            <span wire:loading.remove wire:target="generateSnapToken">
                Bayar Sekarang
            </span>
            <span wire:loading wire:target="generateSnapToken">
                Memproses...
            </span>
        </button>
    </div>
</div>