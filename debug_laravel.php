<?php

require 'vendor/autoload.php';

$app = require 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "DB Config (from Laravel boot):\n";
echo "Host: " . config('database.connections.mysql.host') . "\n";
echo "Username: " . config('database.connections.mysql.username') . "\n";
echo "Database: " . config('database.connections.mysql.database') . "\n";