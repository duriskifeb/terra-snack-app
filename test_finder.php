<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Symfony\Component\Finder\Finder;

$time = microtime(true);
$finder = Finder::create()->in(app_path())->files();
echo "App Path files: " . $finder->count() . "\n";
echo "Time: " . (microtime(true) - $time) . "s\n";

$time = microtime(true);
$finder2 = Finder::create()->in(resource_path('views'))->files();
echo "View Path files: " . $finder2->count() . "\n";
echo "Time: " . (microtime(true) - $time) . "s\n";
