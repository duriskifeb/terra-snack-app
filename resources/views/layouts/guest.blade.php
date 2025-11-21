<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Terra Snack - Camilan Sehat Lezat</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="max-w-content flex flex-col justify-center items-center mx-auto px-mobile-gutter min-h-screen">
                {{ $slot }}
        </div> 

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        @if (session('success'))
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: '{{ session('success') }}',
            timer: 2500,
            showConfirmButton: false
        })
        </script>
        @endif

        @if (session('error'))
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops... Gagal!',
            text: '{{ session('error') }}',
            timer: 3000,
            showConfirmButton: false
        })
        </script>
        @endif

    </body>
</html>