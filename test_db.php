<?php
$db = parse_url('postgresql://postgres.bitnwnnutzqofkumfger:Jancok123%40123@aws-1-ap-southeast-1.pooler.supabase.com:6543/postgres');
try {
    $pdo = new PDO('pgsql:host='.$db['host'].';port='.$db['port'].';dbname='.ltrim($db['path'], '/'), $db['user'], urldecode($db['pass']), [PDO::ATTR_TIMEOUT => 5]);
    echo 'DB OK';
} catch (Exception $e) {
    echo 'DB ERROR: ' . $e->getMessage();
}
