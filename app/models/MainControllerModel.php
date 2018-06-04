<?php
use Model\Model as Model;
use drivers\mysql as MysqlDriver;
use libraries\MysqlQueryLib as Query;
use libraries\FileUploadLib as FileUpload;
use config\Configurator as Configurator;

class MainControllerModel extends Model
{
    public function getTaskList()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        return $query->select()->table('tasks')->order($this->getVarFromPost('sort'), $this->getVarFromPost('sortDirection'))->take($this->getVarFromPost('take'))->offset($this->getVarFromPost('offset'))->get()->toArray();
    }

    public function getTotalTasks()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        return $query->table('tasks')->totalRows();
    }

    public function addNewTask()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $newTask = array(
            'user' => $this->getVarFromPost('user'),
            'email' => $this->getVarFromPost('email'),
            'text' => $this->getVarFromPost('text'),
            'image' => $this->getVarFromPost('image'),
            'status' => 'new',
            'create_time' => strtotime('now')
        );
        $query->table('tasks')->insert($newTask);
    }

    public function imageUploadHandler()
    {
        return FileUpload\FileUploadLib::upload();
    }

    public function saveTaskChanges()
    {
        $query = new Query\MysqlQueryLib(MysqlDriver\MysqlDriver::connect(Configurator\Configurator::getDatabaseConfigParams()));
        $records = array(
            'text' => $this->getVarFromPost('taskText')
        );
        if($this->getVarFromPost('taskStatus') === "true") { $records['status'] = 'done'; }
        $query->table('tasks')->where("id = {$this->getVarFromPost('taskId')}")->update($records);
    }
}