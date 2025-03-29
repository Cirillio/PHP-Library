<?php
require_once "autoload.php";
require_once "config/database.php";

use controllers\RegisterController;
use controllers\LoginController;

session_start();
$registerController = new RegisterController($pdo);
$loginController = new LoginController($pdo);
$registerController->makeRegister();
$loginController->logIn();
