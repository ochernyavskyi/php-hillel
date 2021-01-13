<?php

//Test comment
namespace App\Model;


use App\Traits\DB;
use PDO;

abstract class AbstractModel
{

    protected static PDO $db;

    public function __construct(string $table)
    {
        $this->table = $table;
        self::$db = $this->db();
    }


    public static function findAll(): array
    {
        $stm = self::db()->query('SELECT * FROM ' . static::TABLE_NAME);
        return $stm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }


    public function remove(int $id): void
    {
        $sql = sprintf('DELETE FROM %s WHERE id = ?', static::TABLE_NAME);
        $stm = self::db()->prepare($sql);
        $stm->execute([$id]);
    }

    public static function db()
    {
        static $conn;
        if (!isset($conn)) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s',
                    '192.168.10.20',
                    'homestead'
                );
                $conn = new PDO($dsn, 'homestead', 'secret');
            } catch (\PDOException $exception) {
                exit ('Connection to DB failed');
            }
            return $conn;
        }
    }


    public static function findById(int $id): array
    {
        $db = self::db();
        $stm = $db->prepare('SELECT * FROM ' . static::TABLE_NAME);
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

}