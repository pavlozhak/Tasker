<?php
use Controller\Controller as Controller;

class MainController extends Controller
{
	public function index()
	{
		$this->view->render('index_view');
	}

	public function addNewTask()
    {
        $model = new MainControllerModel();
        $model->addNewTask();
    }

    public function getTasks()
    {
        $model = new MainControllerModel();
        $tasks = $model->getTaskList();
        $this->setContentType('application/json')->jsonEncode($tasks);
    }

    public function totalTasks()
    {
        $model = new MainControllerModel();
        echo $model->getTotalTasks();
    }

    public function imageUpload()
    {
        $model = new MainControllerModel();
        echo $model->imageUploadHandler();
    }

    public function editTask()
    {
        $model = new MainControllerModel();
        $model->saveTaskChanges();
    }
}