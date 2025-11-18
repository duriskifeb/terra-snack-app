<x-guest-layout>

    <div class="text-center mb-6">
        <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="mx-auto w-24 mb-2">
        
        <h1 class="text-2xl font-bold text-amber-700 font-inter">
            Selamat Datang di Terra Snack
        </h1>
        <p class="text-sm text-gray-500">
            Nikmati camilan lezat dengan akunmu 
        </p>
    </div>

    <div class="mt-8 flex flex-col items-center space-y-4">
        
        <a href="{{ route('login') }}" 
           class="w-full inline-flex items-center justify-center px-4 py-2 
                  bg-gray-800 border border-transparent rounded-md 
                  font-semibold text-xs text-white uppercase tracking-widest 
                  hover:bg-gray-700 active:bg-gray-900 
                  focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 
                  transition ease-in-out duration-150">
            Login
        </a>

        <a href="{{ route('register') }}"
           class="w-full inline-flex items-center justify-center px-4 py-2 
                  bg-white border border-amber-700 rounded-md 
                  font-semibold text-xs text-amber-700 uppercase tracking-widest 
                  hover:bg-amber-50 active:bg-amber-100 
                  focus:outline-none focus:ring-2 focus:ring-amber-500 focus:ring-offset-2 
                  transition ease-in-out duration-150">
            Mendaftar
        </a>
        
    </div>
</x-guest-layout>
