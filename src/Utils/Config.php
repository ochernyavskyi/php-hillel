<?php


namespace App\Utils;


abstract class Config

{
    public const DB_FILE = __DIR__ . '/../../.env';

    public static function getDbUsername(): string
    {
        $file = explode("\n", str_replace(' ', '', file_get_contents(self::DB_FILE)));
        foreach ($file as $value) {
            if (strpos($value, 'DBUSER:') === 0) {
                return str_replace('DBUSER:', '', $value);
            }
        }
    }

    public static function getDbUserPassword(): string
    {
        $file = explode("\n", str_replace(' ', '', file_get_contents(self::DB_FILE)));
        foreach ($file as $value) {
            if (strpos($value, 'DBPASSWORD:') === 0) {
                return str_replace('DBPASSWORD:', '', $value);
            }
        }
    }

    public static function getDbName(): string
    {
        $file = explode("\n", str_replace(' ', '', file_get_contents(self::DB_FILE)));
        foreach ($file as $value) {
            if (strpos($value, 'DBNAME:') === 0) {
                return str_replace('DBNAME:', '', $value);
            }
        }
    }

    public static function getDbHost(): string
    {
        $file = explode("\n", str_replace(' ', '', file_get_contents(self::DB_FILE)));
        foreach ($file as $value) {
            if (strpos($value, 'DBHOST:') === 0) {
                return str_replace('DBHOST:', '', $value);
            }
        }
    }
}