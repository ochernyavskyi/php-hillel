<?php

//Test comment
namespace App\Model;


use App\Traits\DB;

abstract class AbstractModel
{
    use DB;

    public static function findAll()
    {
        $db = self::getDb();
        $stm = $db->query('SELECT * FROM ' . static::TABLE_NAME);
        return $stm->fetchAll(\PDO::FETCH_ASSOC);
    }

    public static function findById(int $id): array
    {
        $db = self::getDb();
        $stm = $db->prepare('SELECT * FROM ' . static::TABLE_NAME);
        $stm->execute([$id]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

}