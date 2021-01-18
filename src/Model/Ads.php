<?php

namespace App\Model;


use App\Exception\InvalidTitleException;
use App\Exception\ValidationException;

class Ads extends AbstractModel
{
    public const TABLE_NAME = 'ads';

    public function getTitle(): string
    {
        return $this->title;
    }

    private function setTitle(string $title): void
    {
        if (empty($title) || strlen($title) > 100) {
            echo 'Invalid title length';
        } else
            $this->title = htmlspecialchars($title);
    }

    public function getBody(): string
    {
        return $this->body;
    }

    private function setBody(string $body): void
    {
        if (empty($body) || strlen($body) > 1000) {
            echo 'Invalid body length';
        } else
            $this->body = htmlspecialchars($body);
    }

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTime $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function save(array $ads): void
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