<?php


namespace App\Utils;


abstract class Config

{
    public const DB_FILE = __DIR__ . '/../../.env';

    public static function getCredentials(string $data){
        $file = explode("\n", str_replace(' ', '', file_get_contents(self::DB_FILE)));
        foreach ($file as $value) {
            if (strpos($value, $data) === 0) {
                return str_replace($data, '', $value);
            }
        }
    }
}