<div>
    <div class="flex justify-center gap-7 mb-6 py-4  sticky top-0  z-10">
        @if ($categories)
            @foreach ($categories as $category)
                <button wire:click="filterByCategory({{ $category->id }})" class=" 
                                        flex items-center gap-2  text-lg font-semibold transition-colors
                                        {{ $activeCategoryId == $category->id
                    ? 'text-[#E13220] border-b-2 border-[#E13220]'
                    : 'text-[#F8B418] hover:text-[#DFA113]' 
                                        }}
                                    ">
                    @if (stripos($category->name, 'snack') !== false)
                            <i class="fa-solid fa-burger"></i>
                    @else
                        <i class="fa-solid fa-glass-water"></i>
                    @endif
                    <span>{{ $category->name }}</span>
                </button>
            @endforeach
        @endif
    </div>

    <div class="grid grid-cols-2 gap-x-4 gap-y-28 pb-12 pt-20">
        @if ($products)
            @forelse($products as $product)
                <div class="even:mt-28">
                    <livewire:products.product-item :product="$product" :key="$product->id" />
                </div>
            @empty
                <p class="col-span-2 text-center text-gray-500">Tidak ada produk</p>
            @endforelse
        @else
            <p class="col-span-2 text-center text-gray-500">Tidak ada produk di kategori ini.</p>
        @endif
    </div>
</div>