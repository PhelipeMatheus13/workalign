<?php

namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static $conn;

    public static function connect()
    {
        if (!self::$conn) {
            require __DIR__ . '/../../config/database.php';
            self::$conn = new PDO($dsn, $user, $password, $options);
        }
        return self::$conn;
    }
}
