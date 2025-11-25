<div class="p-6 max-w-3xl mx-auto space-y-10">

    <a href="{{ route('customer-history.list') }}" wire:navigate
        class="text-gray-400 font-semibold hover:text-gray-600 transition flex items-center gap-1">
        <i class="fa-solid fa-arrow-left"></i>
        Kembali
    </a>

    <h1 class="text-2xl font-bold mt-4 mb-6 text-center text-[#E13220]">
        Detail Pesanan #{{ $order->id }}
    </h1>

    <div class="flex flex-col gap-7">

        <x-order.card>
            <x-order.label icon="fa-solid fa-circle-info">Status Pesanan</x-order.label>
            <x-order.badge :type="$order->status">
                {{ ucfirst($order->status) }}
            </x-order.badge>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-credit-card">Status Pembayaran</x-order.label>
            <x-order.badge :type="$order->payment_status">
                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
            </x-order.badge>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-wallet">Total Harga</x-order.label>
            <p class="font-bold text-gray-800 text-lg">
                Rp {{ number_format($order->total_price, 0, ',', '.') }}
            </p>
        </x-order.card>

        <x-order.card>
            <x-order.label icon="fa-solid fa-calendar-days">Tanggal Transaksi</x-order.label>
            <p class="text-gray-800 font-medium">
                {{ $order->created_at->translatedFormat('d M Y • H:i') }}
            </p>
            <p class="text-xs text-gray-500">
                ({{ $order->created_at->diffForHumans() }})
            </p>
        </x-order.card>

        <x-order.card class="flex flex-col gap-3">

            <x-order.label icon="fa-solid fa-clock">Status Pembayaran</x-order.label>

            @if ($order->paid_at)
                <x-order.badge type="paid">
                    Pembayaran Berhasil
                </x-order.badge>
            @else
                <x-order.badge type="unpaid">
                    Belum Dibayar
                </x-order.badge>
            @endif


            @if ($order->paid_at)
                <div class="text-sm">
                    <p class="text-gray-800 font-semibold">
                        {{ $order->paid_at->timezone('Asia/Jakarta')->translatedFormat('d M Y • H:i') }}
                    </p>
                    <p class="text-xs text-gray-500">
                        ({{ $order->paid_at->diffForHumans() }})
                    </p>
                </div>
            @endif


            @if ($order->payment_status === 'unpaid')
                <a href="{{ route('customer-history.upload-proof', $order->id) }}" wire:navigate class="w-full bg-[#E13220] text-white text-xs font-semibold py-2 rounded-lg shadow
                       hover:bg-red-700 transition flex items-center justify-center gap-2">
                    <i class="fa-solid fa-upload"></i>
                    Upload Bukti Pembayaran
                </a>

                <p class="text-xs text-gray-400 text-center italic">
                    Silakan upload bukti setelah Anda melakukan pembayaran.
                </p>
            @endif

        </x-order.card>


        <x-order.card>
            <x-order.label icon="fa-solid fa-map">Pickup Location</x-order.label>
            <div>
                <p class="text-xs text-gray-500 leading-relaxed">
                    Jl. Ketintang No.156, Ketintang, <br> Kec. Gayungan, Surabaya, Jawa Timur 60231
                </p>
            </div>
            <a href="https://maps.google.com/?q=Jl.+Ketintang+No.156,+Ketintang,+Surabaya" target="_blank"
                class="mt-4 flex items-center justify-center gap-2 w-full bg-gray-100 text-gray-700 py-2 rounded-lg text-xs font-semibold hover:bg-gray-200 transition">
                <i class="fa-solid fa-map"></i> Buka di Peta
            </a>
        </x-order.card>


    </div>

    <div class="mt-10">
        <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2 flex items-center gap-2">
            <i class="fa-solid fa-list"></i>
            Daftar Item
        </h2>

        <div class="bg-white rounded-lg shadow divide-y divide-gray-200">

            @foreach ($order->items as $item)
                <div class="p-4 flex justify-between items-center hover:bg-gray-50 transition">

                    <div class="space-y-1">
                        <p class="font-medium text-gray-800">
                            {{ $item->product->name ?? 'Produk' }}
                        </p>

                        <p class="text-sm text-gray-500 flex items-center gap-1">
                            {{ $item->quantity }} × Rp {{ number_format($item->unit_price, 0, ',', '.') }}
                        </p>
                    </div>

                    <p class="font-bold text-red-600 text-right">
                        Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                    </p>

                </div>
            @endforeach

        </div>

        <div class="mt-3 text-right font-semibold text-gray-700 text-xl">
            Total Item :
            <span class="text-[#E13220]">
                Rp {{ number_format($order->items->sum(fn($i) => $i->unit_price * $i->quantity), 0, ',', '.') }}
            </span>
        </div>
    </div>

</div>