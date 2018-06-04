<?php
use Controller\Controller as Controller;

class TaskController extends Controller
{
    public function index()
    {
        $model = new TaskControllerModel();
        $model->getData();
    }
}