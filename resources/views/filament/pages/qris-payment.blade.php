<div class="flex flex-col items-center justify-center py-8 space-y-6">
    <div class="p-6 bg-white rounded-lg shadow-lg">
        <img 
            src="{{ asset('images/qris.jpeg') }}" 
            alt="QRIS Code" 
            class="w-64 h-64 object-contain"
        >
    </div>

    <div class="text-center space-y-2">
        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
            Order #{{ $order_id }}
        </p>
        <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">
            Rp {{ number_format($total, 0, ',', '.') }}
        </p>
        <p class="text-sm text-gray-600 dark:text-gray-400">
            Scan QR Code di atas menggunakan aplikasi e-wallet Anda
        </p>
    </div>

    <div class="text-center space-y-2">
        <p class="text-xs text-gray-500 dark:text-gray-500">
            Mendukung semua aplikasi pembayaran QRIS
        </p>
        <p class="text-xs font-medium text-gray-600 dark:text-gray-400">
            GoPay • OVO • DANA • ShopeePay • LinkAja
        </p>
    </div>

    <div class="max-w-md p-4 bg-yellow-50 dark:bg-yellow-900/20 rounded-lg">
        <p class="text-xs text-yellow-800 dark:text-yellow-200 text-center">
            ⚠️ Pastikan pembayaran sudah berhasil sebelum klik "Sudah Scan & Bayar"
        </p>
    </div>
</div>