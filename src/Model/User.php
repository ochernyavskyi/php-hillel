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

    public function save(User $user): void
    {
        $checkUserExist = $this->findByEmail($user->getEmail());
        if ($checkUserExist) {
            throw new ValidationException([
                'email' => 'Email already exist'
            ]);
        }

        $stm = $this->db()->prepare('
            INSERT INTO users (`name`,email,password,status,created_at)
            VALUE (?,?,?,?,?)
        ');

        $stm->execute([
            $user->getName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getStatus(),
            $user->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public function findByEmail(string $email): array
    {
        $stm = $this->db()->prepare('SELECT * FROM users WHERE email = ?');
        $stm->execute([$email]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        if (empty($name)) {
            echo 'Invalid  length';
        } else
            $this->name = htmlspecialchars($name);
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Invalid email';
        } else
            $this->email = htmlspecialchars($email);
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        if ($hash) {
            $this->password = $hash;
        }
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }
}