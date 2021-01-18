<?php

//Test comment
namespace App\Model;


use PDO;
use App\Utils\Config;

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

    public static function db(): PDO
    {
        static $conn;
        if (!isset($conn)) {
            try {
                $dsn = sprintf(
                    'mysql:host=%s;dbname=%s',
                    config::getCredentials('DBHOST:'),
                    config::getCredentials('DBNAME:')
                );
                $conn = new PDO($dsn, config::getCredentials('DBUSER:'), config::getCredentials('DBPASSWORD:'));
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