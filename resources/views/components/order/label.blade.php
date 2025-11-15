@props(['icon'])

<p class=" mb-1 text-sm flex font-semibold text-gray-400 items-center gap-2 uppercase tracking-wide">
    <i class="{{ $icon }} text-red-600"></i>
    {{ $slot }}
</p>
