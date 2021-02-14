<?php

namespace App\Model;

use App\Exception\ValidationException;
use DateTime;

class User extends AbstractModel
{
    public const STATUS_ACTIVE = 1;
    public const STATUS_INACTIVE = 0;
    public const TABLE_NAME = 'users';

    public function create(array $user): void
    {
        $stm = $this->db()->prepare('
            INSERT INTO users (`name`,email,password,status,created_at)
            VALUE (?,?,?,?,?)
        ');

        $stm->execute([
            $user['name'],
            $user['email'],
            $user['password'],
            1,
            (new \DateTime())->format('Y-m-d H:i:s')
        ]);
    }

    public function update(int $id, array $user): void
    {
        $sql = '
            UPDATE users SET `name` = ?, email = ?, password = ?, status = ?, created_at = ?
            WHERE id = ?
        ';

        $user[] = $id;
        $stm = $this->db()->prepare($sql);
        $stm->execute($user);
    }

}