<?php
// Load variables from .env
$envFile = __DIR__ . '/../.env';
if (file_exists($envFile)) {
    $envVars = parse_ini_file($envFile);
    
    $server = $envVars['DB_HOST'] ?? 'localhost';
    $user = $envVars['DB_USER'] ?? '';
    $pass = $envVars['DB_PASS'] ?? '';
    $bd = $envVars['DB_NAME'] ?? '';
} else {
    // Fallback for hardcoded values ​​if .env does not exist.
    $server = "localhost";
    $user = "user_workalign";
    $pass = "W0rkAlign2024";
    $bd = "workalign_db";
}

try {
    $pdo = new PDO("mysql:host=$server;dbname=$bd;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Em produção, logue o erro em vez de exibir
    error_log("Database connection error: " . $e->getMessage());
    die("Database connection error.");
}
?>