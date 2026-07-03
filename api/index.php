<?php

// ============================================================
// Vercel read-only filesystem fix:
// Redirect semua writable storage Laravel ke /tmp
// ============================================================

$storagePaths = [
    '/tmp/storage/framework/views',
    '/tmp/storage/framework/cache/data',
    '/tmp/storage/framework/sessions',
    '/tmp/storage/logs',
];

foreach ($storagePaths as $path) {
    if (!is_dir($path)) {
        mkdir($path, 0777, true);
    }
}

// Redirect compiled views ke /tmp
$_ENV['VIEW_COMPILED_PATH']    = '/tmp/storage/framework/views';
$_SERVER['VIEW_COMPILED_PATH'] = '/tmp/storage/framework/views';
putenv('VIEW_COMPILED_PATH=/tmp/storage/framework/views');

// Redirect storage root ke /tmp agar log & cache juga ke sana
$_ENV['APP_STORAGE']    = '/tmp/storage';
$_SERVER['APP_STORAGE'] = '/tmp/storage';
putenv('APP_STORAGE=/tmp/storage');

// Panggil dan jalankan aplikasi utama Laravel
require __DIR__ . '/../public/index.php';