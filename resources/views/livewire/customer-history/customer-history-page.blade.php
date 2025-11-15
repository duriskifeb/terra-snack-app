<div class="p-6 max-w-3xl mx-auto">
    <div class="flex items-center justify-center gap-4 mb-8"> <span class="text-2xl text-[#E13220]">
            <i class="fa-solid fa-scroll"></i>
        </span>
        <p class="text-[#E13220] font-semibold text-2xl">
            History Pembelian
        </p>
    </div>

    <div x-data="{
            observer: null,
            init() {
                const container = this.$refs.scrollContainer;
                const trigger = this.$refs.scrollTrigger;

                this.observer = new IntersectionObserver(entries => {
                    entries.forEach(entry => {
                        if(entry.isIntersecting) {
                            this.$wire.loadMore(); 
                        }
                    });
                }, {
                    root: container,
                    threshold: 1.0
                });
                if(trigger) this.observer.observe(trigger);
            }
        }" x-init="init()" class="space-y-10 max-h-[500px] overflow-auto rounded-lg p-3" x-ref="scrollContainer">

        @foreach($orders as $order)
                <a href="{{ route('customer-history.detail', ['orderId' => $order->id]) }}"
                    class=" p-6  shadow rounded-lg flex flex-col gap-12 justify-between items-start duration-300 hover:bg-red-600 group font-semibold group-hover:text-white">
                    <div class="space-y-3">
                        <p class="font-bold group-hover:text-white  text-xl text-gray-800">Order #{{ $order->id }}</p>

                        <p class="text-sm text-gray-600 group-hover:text-white">
                            Status Pesanan:
                            <span class="inline-block px-2 ml-3 py-1 text-xs font-semibold rounded-full
                                {{ match ($order->status) {
                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                    'processing' => 'bg-blue-100 text-blue-800',
                                    'completed' => 'bg-green-100 text-green-800',
                                    'cancelled' => 'bg-red-100 text-red-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst($order->status) }}
                            </span>
                        </p>

                        <p class="text-sm text-gray-600 group-hover:text-white">
                            Pembayaran:
                            <span class="inline-block px-2 py-1 text-xs font-semibold rounded-full ml-3
                                {{ match ($order->payment_status) {
                                    'unpaid' => 'bg-gray-100 text-gray-800',
                                    'paid' => 'bg-green-100 text-green-800',
                                    default => 'bg-gray-100 text-gray-800'
                                } }}">
                                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
                            </span>
                        </p>

                        <p class="text-xs text-gray-500 group-hover:text-white">
                            Dibuat: {{ \Carbon\Carbon::parse($order->created_at)->format('d M Y H:i') }}
                        </p>

                        <p class="text-2xl text-gray-600 group-hover:text-white">
                            Total: <span class="font-semibold">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</span>
                        </p>
                    </div>
                </a>
        @endforeach

        @if($hasMorePages)
            <div x-ref="scrollTrigger" class="flex justify-center py-4">
                <div class="flex items-center gap-2 text-gray-500 text-sm">
                    <svg class="animate-spin h-5 w-5 text-[#E13220]" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                    </svg>
                    Memuat lebih banyak
                </div>
            </div>
        @endif
    </div>
</div>