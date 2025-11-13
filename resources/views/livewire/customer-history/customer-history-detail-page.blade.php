<div class="p-6 max-w-3xl mx-auto space-y-6">
    <a href="{{ route('customer-history.list') }}" wire:navigate class="text-gray-400 font-semibold hover:text-gray-600 transition">
        &lt; Kembali
    </a>

    <h1 class="text-2xl font-bold mt-4 mb-6 text-center text-[#E13220]">
        Detail Pesanan #{{ $order->id }}
    </h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-700 font-semibold mb-1">Status Pesanan:</p>
            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                {{ match($order->status) {
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'processing' => 'bg-blue-100 text-blue-800',
                    'completed' => 'bg-green-100 text-green-800',
                    'cancelled' => 'bg-red-100 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                } }}">
                {{ ucfirst($order->status) }}
            </span>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-700 font-semibold mb-1">Status Pembayaran:</p>
            <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full
                {{ match($order->payment_status) {
                    'unpaid' => 'bg-gray-100 text-gray-800',
                    'pending_payment' => 'bg-yellow-100 text-yellow-800',
                    'paid' => 'bg-green-100 text-green-800',
                    'expired' => 'bg-red-100 text-red-800',
                    'failed' => 'bg-red-200 text-red-800',
                    default => 'bg-gray-100 text-gray-800'
                } }}">
                {{ ucfirst(str_replace('_', ' ', $order->payment_status)) }}
            </span>
        </div>

        <!-- Total Harga -->
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-700 font-semibold mb-1">Total Harga:</p>
            <p class="font-semibold text-gray-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
        </div>

        <!-- Tanggal Transaksi -->
        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-700 font-semibold mb-1">Tanggal Transaksi:</p>
            <p class="text-gray-800">{{ $order->created_at->format('d M Y H:i') }}</p>
        </div>

        <div class="bg-white p-4 rounded-lg shadow">
            <p class="text-gray-700 font-semibold mb-1">Tanggal Pembayaran:</p>
            <p class="text-gray-800">
                {{ $order->paid_at ? \Carbon\Carbon::parse($order->paid_at)->format('d M Y H:i') : '-' }}
            </p>
        </div>
    </div>

    <div class="mt-6">
        <h2 class="text-lg font-semibold mb-3 text-gray-700 border-b pb-2">Daftar Item</h2>

        <div class="bg-white rounded-lg shadow divide-y divide-gray-200">
            @foreach($order->items as $item)
                <div class="p-3 flex justify-between items-center">
                    <div>
                        <p class="font-medium text-gray-800">{{ $item->product->name ?? 'Produk' }}</p>
                        <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                    </div>
                    <p class="font-semibold text-red-600">
                        Rp {{ number_format($item->unit_price * $item->quantity, 0, ',', '.') }}
                    </p>
                </div>
            @endforeach
        </div>

        <div class="mt-3 text-right font-semibold text-gray-700">
            Total Item: Rp {{ number_format($order->items->sum(fn($i) => $i->unit_price * $i->quantity), 0, ',', '.') }}
        </div>
    </div>
</div>
