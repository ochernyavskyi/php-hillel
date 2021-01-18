<?php

namespace App\Model;

use PDO;
use App\Utils\Config;

abstract class AbstractModel
{
    protected static PDO $db;
    protected string $table;

    public function __construct(string $table)
    {
        $this->table = $table;
        self::$db = $this->db();
    }

    public function findAll(): array
    {
        $stm = $this->db()->query('SELECT * FROM ' . static::TABLE_NAME);
        return $stm->fetchAll(PDO::FETCH_ASSOC) ?: [];
    }

    public function remove(int $id): void
    {
        $sql = sprintf('DELETE FROM %s WHERE id = ?', static::TABLE_NAME);
        $stm = $this->db()->prepare($sql);
        $stm->execute([$id]);
    }

    public function db(): PDO
    {
        if (!isset(self::$db)) {
            try {
                $dsn = sprintf('mysql:host=%s;dbname=%s', config::getCredentials('DBHOST:'), config::getCredentials('DBNAME:'));
                self::$db = new PDO($dsn, config::getCredentials('DBUSER:'), config::getCredentials('DBPASSWORD:'));
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (\PDOException $exception) {
                exit ('Connection to DB failed');
            }
        }
        return self::$db;
    }


    public static function findById(int $id): array
    {
        $stm = self::$db->prepare('SELECT * FROM ' . static::TABLE_NAME);
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

}