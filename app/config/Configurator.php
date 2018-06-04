<?php
namespace config\Configurator;

class Configurator
{
    private static $databaseConfig = array(
        'host' => 'stdev.mysql.tools',
        'user' => 'stdev_tasks',
        'pass' => 'srr8kant',
        'dbname' => 'stdev_tasks',
        'charset' => 'utf8'
    );

    public static function getDatabaseConfigParams()
    {
        return self::$databaseConfig;
    }
}