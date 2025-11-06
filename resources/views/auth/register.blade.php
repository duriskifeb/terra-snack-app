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
            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A1.75 1.75 0 0118 22H6a1.75 1.75 0 01-1.499-1.882z" />
                        </svg>
                    </span>

                    <input id="name" type="text" name="name" :value="old('name')" required autofocus
                        class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                        placeholder="Username">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.807-.63-5.16-2.983-5.79-5.79l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </span>

                    <input id="phone" type="text" name="phone" :value="old('phone')" required
                        class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                        placeholder="Contoh: 081234567890">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>

                    <input id="password" type="password" name="password" required autocomplete="new-password"
                        class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                        placeholder="Password">
                </div>
                
                <div id="password-requirements" class="mt-2 text-sm text-gray-600 space-y-1 ml-4">
                    <p id="length" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>
                        Minimal 8 karakter
                    </p>
                    <p id="uppercase" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>
                        Mengandung huruf besar (A–Z)
                    </p>
                    <p id="lowercase" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>
                        Mengandung huruf kecil (a–z)
                    </p>
                    <p id="number" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>
                        Mengandung angka (0–9)
                    </p>
                    <p id="symbol" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>
                        Mengandung simbol/karakter khusus
                    </p>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2.25m0 3v.008M12 9a3 3 0 013 3v6a3 3 0 01-6 0v-6a3 3 0 013-3z" />
                        </svg>
                    </span>

                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                        placeholder="Konfirmasi Password">
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
        </div>

        <div class="text-center text-sm mt-7">
            <span class="text-gray-600">Sudah punya akun?</span>
            <a href="{{ route('login') }}" class="font-medium text-red-600 hover:text-red-500">
                Masuk
            </a>
        </div>

        <div class="mt-6">
            <button type="submit" id="submitButton"
                class="w-full flex justify-center py-3 px-4 
                        border border-transparent rounded-xl shadow-sm 
                        text-base font-medium text-white bg-red-600 
                        hover:bg-red-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Daftar
            </button>
        </div>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('registerForm');
            const passwordInput = document.getElementById('password');
            const confirmInput = document.getElementById('password_confirmation');
            const fields = ['name', 'phone', 'password', 'password_confirmation'];
            
            // Objek untuk memetakan kriteria dan regex
            const requirements = {
                length: { regex: /.{8,}/, id: 'length', met: false },
                uppercase: { regex: /[A-Z]/, id: 'uppercase', met: false },
                lowercase: { regex: /[a-z]/, id: 'lowercase', met: false },
                number: { regex: /[0-9]/, id: 'number', met: false },
                symbol: { regex: /[^A-Za-z0-9]/, id: 'symbol', met: false }
            };

            // Ikon yang akan digunakan
            const iconCheck = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="check"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.796-1.886-1.885a.75.75 0 10-1.06 1.06l2.5 2.5a.75.75 0 001.137-.089l4.12-5.39z" clip-rule="evenodd" /></svg>';
            const iconCross = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-4 h-4 mr-2" data-icon="cross"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z" clip-rule="evenodd" /></svg>';


            function updateRequirement(id, isValid) {
                const element = document.getElementById(id);
                if (element) {
                    element.classList.remove(isValid ? 'text-red-500' : 'text-green-500');
                    element.classList.add(isValid ? 'text-green-500' : 'text-red-500');
                    
                    // Ganti ikon
                    const icon = isValid ? iconCheck : iconCross;
                    element.querySelector('svg').outerHTML = icon;
                }
                requirements[id].met = isValid; // Update status
            }

            function validatePassword() {
                const password = passwordInput.value;
                let allRequirementsMet = true;

                for (const key in requirements) {
                    const req = requirements[key];
                    const isValid = req.regex.test(password);
                    updateRequirement(req.id, isValid);
                    if (!isValid) {
                        allRequirementsMet = false;
                    }
                }
                return allRequirementsMet;
            }

            // Jalankan validasi setiap kali user mengetik
            if (passwordInput) {
                passwordInput.addEventListener('keyup', validatePassword);
                validatePassword(); // Initial run
            }

            // Validasi saat form disubmit
            form.addEventListener('submit', function (e) {
                // Pengecekan input kosong
                const isFormValid = fields.every(id => document.getElementById(id).value.trim() !== '');
                const allRequirementsMet = validatePassword();
                
                if (!isFormValid) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Semua field wajib diisi.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                    return;
                }

                // Cek password match
                if (passwordInput.value !== confirmInput.value) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Tidak Sama!',
                        text: 'Konfirmasi password harus sama dengan password.',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Perbaiki'
                    });
                    return;
                }
                
                // Cek persyaratan password
                if (!allRequirementsMet) {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'error',
                        title: 'Password Lemah!',
                        text: 'Password harus memenuhi semua kriteria keamanan (minimal 8 karakter, huruf besar/kecil, angka, simbol).',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'Perbaiki'
                    });
                    return;
                }
            });
        });
    </script>
</x-guest-layout>