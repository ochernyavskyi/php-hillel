<?php

namespace App\Model;


use App\Exception\InvalidTitleException;
use App\Exception\ValidationException;

class Ads extends AbstractModel
{
    public const TABLE_NAME = 'ads';


    public function create(array $ads): void
    {
        $checkTitleExist = $this->findByTitle($ads['title']);
        if ($checkTitleExist) {
            throw new ValidationException([
                'title' => 'Title already exist'
            ]);
        }

        $db = $this->db();
        $stm = $db->prepare('
            INSERT INTO ads (`title`,body)
            VALUE (?,?)
        ');

        $stm->execute([
            $ads['title'],
            $ads['body'],
        ]);
    }

    public function findByTitle(string $title): array
    {
        $stm = $this->db()->prepare('SELECT * FROM ads WHERE title = ?');
        $stm->execute([$title]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }
}