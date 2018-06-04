<?php
namespace drivers\mysql;

class MysqlDriver
{
    public static function connect($params)
    {
        $dsn = "mysql:host={$params['host']};dbname={$params['dbname']};charset={$params['charset']}";
        $opt = [
            \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try
        {
            $pdo = new \PDO($dsn, $params['user'], $params['pass'], $opt);
            return $pdo;
        }
        catch (\PDOException $e)
        {
            return false;
        }
    }
}