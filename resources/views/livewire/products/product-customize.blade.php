<div>
    <div class="p-5">
        <a href="{{ route('products.list') }}" wire:navigate class="mb-20 text-gray-400 font-semibold">&lt; Kembali</a>
        <h1 class="text-3xl font-bold mt-2">{{ $product->name }}</h1>
    </div>

    <div class="p-4 space-y-6">
        @foreach ($customizationGroups as $group)
            <div class=" rounded-lg p-4">
                <h3 class="text-xl font-semibold mb-3">{{ $group->name }}</h3>
                <div class="space-y-2">
                    @foreach ($group->optionValues as $value)
                        <label class="flex flex-col p-3 rounded-lg hover:bg-gray-50 cursor-pointer">
                            <div class="flex justify-between items-center">
                                <span class="font-medium text-gray-800">{{ $value->name }}</span>
                                <div class="flex items-center gap-4">
                                    @if ($value->price_modifier > 0)
                                        <span class="text-sm text-gray-600">+ Rp
                                            {{ number_format($value->price_modifier, 0, ',', '.') }}</span>
                                    @else
                                        <span class="text-sm text-green-600">Gratis</span>
                                    @endif

                                    <input type="radio" class="sr-only peer" wire:model.live="selectedOptions.{{ $group->id }}"
                                        value="{{ $value->id }}">
                                    <span
                                        class="w-4 h-4 border border-gray-400 rounded-full peer-checked:bg-red-600 peer-checked:border-red-600"></span>
                                </div>
                            </div>

                            @if (!empty($value->details) && in_array($value->id, (array) ($selectedOptions[$group->id] ?? [])))
                                <ul class="text-sm text-gray-500 mt-1 ml-4 list-disc">
                                    @foreach ($value->details as $key => $detail)
                                        <li>{{ $key }}: {{ $detail }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </label>
                    @endforeach
                </div>
            </div>
        @endforeach

        <div class="flex flex-col gap-2 ounded-lg p-4">
            <label for="notes" class="text-xl font-semibold mb-3">Notes</label>
            <textarea id="notes" wire:model.live="notes" rows="5"
                class="w-full border-gray-300 p-2 rounded-lg focus:ring-red-500 focus:border-red-500"
                placeholder="Contoh: Jangan terlalu pedas..."></textarea>
        </div>

        <div class="flex items-center justify-between rounded-lg p-4">
            <span class="text-xl font-semibold">Jumlah Barang</span>
            <div class="flex items-center gap-4">
                <button wire:click="decrementQuantity"
                    class="w-8 h-8 rounded-full bg-gray-200 text-lg font-bold">-</button>
                <span class="text-xl font-bold w-8 text-center">{{ $quantity }}</span>
                <button wire:click="incrementQuantity"
                    class="w-8 h-8 rounded-full bg-red-600 text-white text-lg font-bold">+</button>
            </div>
        </div>
    </div>

    <div class="sticky bottom-0 bg-white p-4 border-t-4 border-[#E13220] shadow-inner">
        <div class="flex justify-between items-center mb-3">
            <span class="text-lg font-semibold">Total Pembayaran</span>
            <span class="text-2xl font-bold text-red-600">Rp {{ number_format($currentTotalPrice, 0, ',', '.') }}</span>
        </div>
        <button wire:click="addToCart" wire:loading.attr="disabled"
            class="w-full bg-red-600 text-white text-lg font-bold py-3 rounded-lg hover:bg-red-700 transition-colors">
            Tambahkan ke keranjang
        </button>
    </div>
</div>