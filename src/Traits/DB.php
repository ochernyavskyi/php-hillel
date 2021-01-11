<?php

namespace App\Traits;

use PDO;

trait DB
{
    private static function getDb() {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s',
            '192.168.10.20',
            'homestead'
        );
        $pdo = new PDO($dsn, 'homestead', 'secret');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }
}