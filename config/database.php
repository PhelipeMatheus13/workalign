<?php

// Load environment variables
$envFile = __DIR__ . '/../.env';

if (!file_exists($envFile)) {
    throw new Exception(".env file not found.");
}

$env = parse_ini_file($envFile);

$driver   = $env['DB_DRIVER']   ?? 'mysql';
$host     = $env['DB_HOST']     ?? 'localhost';
$db       = $env['DB_NAME']     ?? '';
$user     = $env['DB_USER']     ?? '';
$password = $env['DB_PASS']     ?? '';

$dsn = "{$driver}:host={$host};dbname={$db};charset=utf8";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];