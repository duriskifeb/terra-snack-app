<x-guest-layout>
    <div>

    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="w-24 mx-auto">
    </div>

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-inter">Login</h1>
        <p class="text-sm text-gray-500 mt-2">Masukkan No. Telepon dan password</p>
    </div>

    <form id="loginForm" method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-5">
            <!-- Username -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <!-- Ikon User -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A1.75 1.75 0 0118 22H6a1.75 1.75 0 01-1.499-1.882z" />
                    </svg>
                </span>

                <input id="name" type="text" name="name"
                    class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                    placeholder="Username">
            </div>

            <!-- Password -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <!-- Ikon Gembok -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5
                            a2.25 2.25 0 002.25-2.25v-6.75
                            a2.25 2.25 0 00-2.25-2.25H6.75
                            a2.25 2.25 0 00-2.25 2.25v6.75
                            a2.25 2.25 0 002.25 2.25z" />
                    </svg>
                </span>

                <input id="password" type="password" name="password"
                    class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                    placeholder="Password">
            </div>
        </div>

        <!-- Link ke Register -->
        <div class="text-center text-sm mt-7">
            <span class="text-gray-600">Pengguna baru? silahkan </span>
            <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                mendaftar
            </a>
        </div>

        <div class="mt-6">
            <button type="submit" id="loginButton"
                class="w-full flex justify-center py-3 px-4 
                    border border-transparent rounded-xl shadow-sm 
                    text-base font-medium text-white bg-red-600 
                    hover:bg-red-700 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Masuk
            </button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('loginForm').addEventListener('submit', function (e) {
            const username = document.getElementById('name').value.trim();
            const password = document.getElementById('password').value.trim();

            if (username === '' || password === '') {
                e.preventDefault(); // hentikan submit form
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Isi Username dan Password terlebih dahulu!',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
            }
        });
    </script>
</x-guest-layout>
