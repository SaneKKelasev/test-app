<?php

use App\Model\Auth;
use App\Model\UserModel;

require_once dirname(__DIR__) . '/config/config.php';
require_once dirname(__DIR__) . '/app/model/UserModel.php';
require_once dirname(__DIR__) . '/app/model/Auth.php';
require_once dirname(__DIR__) . '/app/controllers/UsersController.php';

$userModel = new UserModel($pdo);
$authModel = new Auth($pdo);

$controller = new UsersController($userModel, $authModel);

if ($_SERVER['REQUEST_URI'] === '/') {
    $controller->index();
} elseif ($_SERVER['REQUEST_URI'] === '/create') {
    $controller->create();
} elseif ($_SERVER['REQUEST_URI'] === '/delete') {
    $controller->delete();
} elseif ($_SERVER['REQUEST_URI'] === '/login') {
    $controller->login();
} elseif ($_SERVER['REQUEST_URI'] === '/logout') {
    $controller->logout();
} else {
    header('HTTP/1.0 404 Not Found');
}
