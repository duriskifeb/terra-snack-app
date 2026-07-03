<?php

// 1. Definisikan jalur folder sementara (karena Vercel read-only)
$compiledViewPath = '/tmp/storage/framework/views';

// 2. Buat folder tersebut secara otomatis jika belum ada di mesin Vercel
if (!is_dir($compiledViewPath)) {
    mkdir($compiledViewPath, 0777, true);
}

// 3. Paksa sistem Laravel untuk merender tampilan (views) ke folder /tmp
$_ENV['VIEW_COMPILED_PATH'] = $compiledViewPath;
$_SERVER['VIEW_COMPILED_PATH'] = $compiledViewPath;
putenv('VIEW_COMPILED_PATH=' . $compiledViewPath);

// 4. Panggil dan jalankan aplikasi utama Laravel
require __DIR__ . '/../public/index.php';