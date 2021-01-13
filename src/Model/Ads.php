<?php


namespace App\Model;


use App\Exception\InvalidTitleException;
use App\Exception\ValidationException;
use App\Traits\DB;
use DateTime;

class Ads extends AbstractModel
{

    public const TABLE_NAME = 'ads';
    public string $title;
    public string $body;
    private DateTime $createdAt;


    public function __construct(string $title, string $body)
    {
        $this->setTitle($title);
        $this->setBody($body);
        $this->createdAt = new DateTime();

    }

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



    public static function save(Ads $ads): void
    {
        $checkTitleExist = self::findByTitle($ads->getTitle());
        if ($checkTitleExist) {
            throw new ValidationException([
                'title' => 'Title already exist'
            ]);
        }

        $db = AbstractModel::db();
        var_dump($db);
        $stm = $db->prepare('
            INSERT INTO ads (`title`,body,created_at)
            VALUE (?,?,?)
        ');

        $stm->execute([
            $ads->getTitle(),
            $ads->getBody(),
            $ads->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
    }

    public static function findByTitle(string $title): array
    {
        $db = AbstractModel::db();
        $stm = $db->prepare('SELECT * FROM ads WHERE title = ?');
        $stm->execute([$title]);
        $result = $stm->fetch(\PDO::FETCH_ASSOC);
        return $result ? $result : [];
    }

}