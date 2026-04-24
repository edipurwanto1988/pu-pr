<?php

require 'vendor/autoload.php';

Dotenv\Dotenv::createImmutable(__DIR__)->load();

echo "DB_HOST: " . $_ENV['DB_HOST'] . "\n";
echo "DB_DATABASE: " . $_ENV['DB_DATABASE'] . "\n";
echo "DB_USERNAME: " . $_ENV['DB_USERNAME'] . "\n";

$config = require 'config/database.php';
echo "\nLaravel DB Config host: " . $config['connections']['mysql']['host'] . "\n";