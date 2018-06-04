<?php
require_once 'config/Configurator.php';

require_once 'core/model.php';
require_once 'core/view.php';
require_once 'core/controller.php';
require_once 'core/route.php';

require_once 'drivers/MysqlDriver.php';
require_once 'libraries/MysqlQueryLib.php';
require_once 'libraries/FileUploadLib.php';
require_once 'libraries/ImageResizeLib.php';

use Model\model as Model;
use Router\router as Router;
use Controller\controller as Controller;
use View\view as view;

$router = Router::getInstance(); // get Router class instance
$router->start(); // start router