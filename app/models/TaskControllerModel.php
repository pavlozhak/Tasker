<?php
use Model\Model as Model;
use drivers\mysql as MysqlDriver;
use libraries\MysqlQueryLib as Query;
use config\Configurator as Configurator;

class TaskControllerModel extends Model
{
    public function getData()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $res = $query->select()->from('tasks')->get()->toArray();
        var_dump($res);
    }
}