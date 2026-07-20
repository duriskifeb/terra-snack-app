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
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A1.75 1.75 0 0118 22H6a1.75 1.75 0 01-1.499-1.882z" />
                        </svg>
                    </span>

                    <input id="name" type="text" name="name" class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600" placeholder="Username">
                </div>

                <!-- Password -->
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-gray-400">
                        <!-- Ikon Gembok -->
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 00-9 0v3.75m-.75 11.25h10.5
                            a2.25 2.25 0 002.25-2.25v-6.75
                            a2.25 2.25 0 00-2.25-2.25H6.75
                            a2.25 2.25 0 00-2.25 2.25v6.75
                            a2.25 2.25 0 002.25 2.25z" />
                        </svg>
                    </span>

                    <input id="password" type="password" name="password" class="block w-full rounded-xl border-red-500 py-3 pl-12 pr-4
                    text-gray-900 placeholder:text-gray-400
                    focus:ring-2 focus:ring-inset focus:ring-red-600 focus:border-red-600" placeholder="Password">
                </div>
            </div>

            <div class="text-center text-sm mt-7">
                <span class="text-gray-600">Pengguna baru? silahkan </span>
                <a href="{{ route('register') }}" class="font-medium text-red-600 hover:text-red-500">
                    mendaftar
                </a>
            </div>

            <div class="mt-6">
                <button type="submit" id="loginButton" class="w-full flex justify-center py-3 px-4 
                    border border-transparent rounded-xl shadow-sm 
                    text-base font-medium text-white bg-red-600 
                    hover:bg-red-700 
                    focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    Masuk
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
                            <feColorMatrix in="SourceAlpha" type="matrix"
                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                            <feOffset dx="-0.654617" />
                            <feGaussianBlur stdDeviation="0.327309" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.09 0" />
                            <feBlend mode="normal" in2="BackgroundImageFix" result="effect1_dropShadow_422_777" />
                            <feColorMatrix in="SourceAlpha" type="matrix"
                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                            <feOffset dx="-1.30923" />
                            <feGaussianBlur stdDeviation="0.327309" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.05 0" />
                            <feBlend mode="normal" in2="effect1_dropShadow_422_777"
                                result="effect2_dropShadow_422_777" />
                            <feColorMatrix in="SourceAlpha" type="matrix"
                                values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 127 0" result="hardAlpha" />
                            <feOffset dx="-1.96385" />
                            <feGaussianBlur stdDeviation="0.327309" />
                            <feColorMatrix type="matrix" values="0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0 0.01 0" />
                            <feBlend mode="normal" in2="effect2_dropShadow_422_777"
                                result="effect3_dropShadow_422_777" />
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
            document.getElementById('loginForm').addEventListener('submit', function (e) {
                const username = document.getElementById('name').value.trim();
                const password = document.getElementById('password').value.trim();

                if (username === '' || password === '') {
                    e.preventDefault();
                    Swal.fire({
                        icon: 'warning',
                        title: 'Perhatian!',
                        text: 'Isi Username dan Password terlebih dahulu!',
                        confirmButtonColor: '#d33',
                        confirmButtonText: 'OK'
                    });
                }
            });

            @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session("error") }}',
                confirmButtonColor: '#d33',
                confirmButtonText: 'OK'
            });
            @endif
        </script>
</x-guest-layout>