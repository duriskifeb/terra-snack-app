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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A1.75 1.75 0 0118 22H6a1.75 1.75 0 01-1.499-1.882z" />
                        </svg>
                    </span>

                    <input id="name" type="text" name="name" :value="old('name')" required autofocus class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600" placeholder="Username">
                </div>
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 002.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-2.807-.63-5.16-2.983-5.79-5.79l1.293-.97c.362-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 00-1.091-.852H4.5A2.25 2.25 0 002.25 4.5v2.25z" />
                        </svg>
                    </span>

                    <input id="phone" type="text" name="phone" :value="old('phone')" required class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600"
                        placeholder="Contoh: 081234567890">
                </div>
                <x-input-error :messages="$errors->get('phone')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 002.25-2.25v-6.75a2.25 2.25 0 00-2.25-2.25H6.75a2.25 2.25 0 00-2.25 2.25v6.75a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>

                    <input id="password" type="password" name="password" required autocomplete="new-password" class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                        text-gray-900 placeholder:text-gray-400
                        focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600" placeholder="Password">
                </div>

                <div id="password-requirements" class="mt-2 text-sm text-gray-600 space-y-1 ml-4">
                    <p id="length" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 mr-2" data-icon="cross">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        Minimal 8 karakter
                    </p>
                    <p id="uppercase" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 mr-2" data-icon="cross">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        Mengandung huruf besar (A–Z)
                    </p>
                    <p id="lowercase" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 mr-2" data-icon="cross">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        Mengandung huruf kecil (a–z)
                    </p>
                    <p id="number" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 mr-2" data-icon="cross">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        Mengandung angka (0–9)
                    </p>
                    <p id="symbol" class="text-red-500 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                            class="w-4 h-4 mr-2" data-icon="cross">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.28 7.22a.75.75 0 00-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 101.06 1.06L10 11.06l1.72 1.72a.75.75 0 101.06-1.06L11.06 10l1.72-1.72a.75.75 0 00-1.06-1.06L10 8.94l-1.72-1.72z"
                                clip-rule="evenodd" />
                        </svg>
                        Mengandung simbol/karakter khusus
                    </p>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 15v2.25m0 3v.008M12 9a3 3 0 013 3v6a3 3 0 01-6 0v-6a3 3 0 013-3z" />
                        </svg>
                    </span>

                    <input id="password_confirmation" type="password" name="password_confirmation" required class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
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
            <button type="submit" id="submitButton" class="w-full flex justify-center py-3 px-4 
                        border border-transparent rounded-xl shadow-sm 
                        text-base font-medium text-white bg-red-600 
                        hover:bg-red-700 
                        focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                Daftar
            </button>
        </div>
    </form>

    <div class="flex-col mt-10 gap-4 flex justify-center items-center">
        <div class="flex gap-2 justify-center items-center w-full">
            <div class="w-10 bg-black h-[0.2px]"></div>
            <p>Atau Masuk Dengan</p>
            <div class="w-10 bg-black h-[0.2px]"></div>
        </div>
        <a href="{{route('google.redirect')  }}">
            <svg width="32" height="32" viewBox="0 0 448 447" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g clip-path="url(#clip0_422_777)" filter="url(#filter0_ddd_422_777)">
                    <path
                        d="M445.062 229.52C445.227 211.382 443.841 198.132 440.705 184.376L228.747 182.454L228.005 264.323L352.42 265.451C349.728 285.774 335.905 316.291 305.617 336.607L305.17 339.344L371.728 390.686L376.367 391.18C419.357 353.083 444.454 296.683 445.062 229.52Z"
                        fill="#4285F4" />
                    <path
                        d="M226.383 443.261C287.336 443.814 338.684 424.667 376.367 391.181L305.617 336.607C286.436 349.426 260.768 358.263 227.156 357.959C167.457 357.418 117.137 318.476 99.5565 265.121L96.907 265.317L26.7437 317.386L25.8099 319.854C62.2805 392.255 138.087 442.461 226.383 443.261Z"
                        fill="#34A853" />
                    <path
                        d="M99.5561 265.121C94.9147 251.352 92.2898 236.618 92.4276 221.422C92.5653 206.223 95.4568 191.542 100.096 177.856L99.9965 174.932L29.9229 120.745L27.6046 121.797C12.0331 151.563 2.94929 185.066 2.62716 220.608C2.30502 256.15 10.7801 289.81 25.8096 319.854L99.5561 265.121Z"
                        fill="#FBBC05" />
                    <path
                        d="M229.609 87.3474C272 87.7316 300.433 105.884 316.603 120.985L380.866 60.7729C342.059 24.8761 291.335 2.59881 230.382 2.04637C142.086 1.2461 65.3822 50.0687 27.6054 121.797L100.097 177.856C118.892 124.831 169.91 86.8063 229.609 87.3474Z"
                        fill="#EB4335" />
                </g>
                <defs>
                    <filter id="filter0_ddd_422_777" x="-2.02667" y="-0.654617" width="449.367" height="448.058"
                        filterUnits="userSpaceOnUse" color-interpolation-filters="sRGB">
                        <feFlood flood-opacity="0" result="BackgroundImageFix" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                            result="hardAlpha" />
                        <feOffset dx="-0.654617" />
                        <feGaussianBlur stdDeviation="0.327309" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.09 0" />
                        <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_422_777" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                            result="hardAlpha" />
                        <feOffset dx="-1.30923" />
                        <feGaussianBlur stdDeviation="0.327309" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0" />
                        <feBlend mode="normal" in2="effect1_dropShadow_422_777" result="effect2_dropShadow_422_777" />
                        <feColorMatrix in="SourceAlpha" type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0"
                            result="hardAlpha" />
                        <feOffset dx="-1.96385" />
                        <feGaussianBlur stdDeviation="0.327309" />
                        <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.01 0" />
                        <feBlend mode="normal" in2="effect2_dropShadow_422_777" result="effect3_dropShadow_422_777" />
                        <feBlend mode="normal" in="SourceGraphic" in2="effect3_dropShadow_422_777" result="shape" />
                    </filter>
                    <clipPath id="clip0_422_777">
                        <rect width="442.754" height="442.754" fill="white"
                            transform="translate(4.60449) rotate(0.519281)" />
                    </clipPath>
                </defs>
            </svg>
        </a>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
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