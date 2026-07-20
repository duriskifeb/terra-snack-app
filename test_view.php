<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    echo "Getting factory...\n";
    $viewFactory = view();
    echo "Making welcome...\n";
    $view = $viewFactory->make('welcome');
    echo "Rendering welcome...\n";
    $content = $view->render();
    echo "Render successful! Length: " . strlen($content) . "\n";
} catch (\Exception $e) {
    echo "Exception: " . $e->getMessage() . "\n";
}
