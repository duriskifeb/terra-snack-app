<x-guest-layout>
    <div class="w-full sm:max-w-md px-4 py-8 sm:px-10 sm:py-10 bg-white sm:shadow-lg sm:rounded-xl">

        <div class="flex justify-center mb-6">
            {{-- 
              Ganti 'src' dengan path ke logo "Snack Booth" Anda.
              Logo ini berbeda dari 'logoTerraSnack.svg' yang Anda sebut sebelumnya.
            --}}
            <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="w-24 mx-auto">
        </div>

        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 font-inter">
                Login
            </h1>
            {{-- Sub-judul ini saya sesuaikan dengan field di bawah (No Telepon) --}}
            <p class="text-sm text-gray-500 mt-2">
                Masukkan No. Telepon dan password
            </p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="space-y-5">
                
                <div>
                    {{-- Kita butuh 'relative' untuk menempatkan ikon --}}
                    <div class="relative">
                        {{-- Ikon (Heroicon) --}}
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                            {{-- (Ikon Telepon) --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.807-.63-5.16-2.983-5.79-5.79l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                            </svg>
                        </span>
                        
                        {{-- Input Field --}}
                        <input id="phone" type="text" name="phone" {{-- Ganti 'name' jadi 'phone' --}}
                               :value="old('phone')" required autofocus
                               class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4 
                                      text-gray-900 placeholder:text-gray-400 
                                      focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                               placeholder="No Telepon">
                    </div>
                    {{-- 
                      PENTING: Ganti error key ke 'phone'.
                      Breeze awalnya menggunakan 'name' atau 'email'.
                    --}}
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>

                <div>
                    <div class="relative">
                        {{-- Ikon (Heroicon) --}}
                        <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                           {{-- (Ikon Gembok) --}}
                           <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                             <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                           </svg>
                        </span>

                        <input id="password" type="password" name="password" 
                               required autocomplete="current-password"
                               class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4 
                                      text-gray-900 placeholder:text-gray-400 
                                      focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                               placeholder="Password">
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

            </div> <div class="text-center text-sm mt-7">
                <span class="text-gray-600">Pengguna baru? silahkan </span>
                <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                    mendaftar
                </a>
            </div>

            <div class="mt-6">
                {{-- 
                  Ini adalah <x-primary-button> yang kita kustomisasi
                  dengan warna merah dan 'rounded-xl'
                --}}
                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 
                               border border-transparent rounded-xl shadow-sm 
                               text-base font-medium text-white bg-red-600 
                               hover:bg-red-700 
                               focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Masuk
                </button>
            </div>

        </form>
    </div>
</x-guest-layout>