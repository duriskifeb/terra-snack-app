<x-guest-layout>
    <div class="flex justify-center mb-6">
        <img src="{{ asset('images/logoTerraSnack.svg') }}" alt="Terra Snack Logo" class="w-24 mx-auto">
    </div>

    <div class="text-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900 font-inter">Daftar Akun</h1>
        <p class="text-sm text-gray-500 mt-2">Isi data berikut untuk membuat akun baru</p>
    </div>

    <form id="registerForm" method="POST" action="{{ route('register') }}">
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

            <!-- Phone -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <!-- Ikon Telepon -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M2.25 6.75c0 8.284 6.716 15 15 15h1.5
                            a2.25 2.25 0 002.25-2.25v-1.372
                            a1.125 1.125 0 00-.852-1.09l-4.548-1.137
                            a1.125 1.125 0 00-1.173.417l-.97 1.293
                            a11.25 11.25 0 01-5.406-5.406l1.293-.97
                            a1.125 1.125 0 00.417-1.173L6.962 3.102
                            A1.125 1.125 0 005.872 2.25H4.5
                            A2.25 2.25 0 002.25 4.5v2.25z" />
                    </svg>
                </span>

                <input id="phone" type="text" name="phone"
                    class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                    placeholder="No. Telepon">
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

            <!-- Confirm Password -->
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                    <!-- Ikon Gembok Kedua -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 15v2.25m0 3v.008
                            M12 9a3 3 0 013 3v6a3 3 0 01-6 0v-6a3 3 0 013-3z" />
                    </svg>
                </span>

                <input id="password_confirmation" type="password" name="password_confirmation"
                    class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                    placeholder="Konfirmasi Password">
            </div>
        </div>

        <div class="text-center text-sm mt-7">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                Masuk
            </a>
        </div>

        <div class="mt-6">
            <button type="submit"
                class="w-full flex justify-center py-3 px-4 
                       border border-transparent rounded-xl shadow-sm 
                       text-base font-medium text-white bg-red-600 
                       hover:bg-red-700 
                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Daftar
            </button>
        </div>
    </form>

    <!-- Script validasi input kosong -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.getElementById('registerForm').addEventListener('submit', function (e) {
            const name = document.getElementById('name').value.trim();
            const phone = document.getElementById('phone').value.trim();
            const password = document.getElementById('password').value.trim();
            const confirm = document.getElementById('password_confirmation').value.trim();

            if (name === '' || phone === '' || password === '' || confirm === '') {
                e.preventDefault();
                Swal.fire({
                    icon: 'warning',
                    title: 'Perhatian!',
                    text: 'Isi semua field terlebih dahulu!',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'OK'
                });
                return;
            }

            if (password !== confirm) {
                e.preventDefault();
                Swal.fire({
                    icon: 'error',
                    title: 'Password Tidak Sama!',
                    text: 'Konfirmasi password harus sama dengan password.',
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Perbaiki'
                });
            }
        });
    </script>
</x-guest-layout>
