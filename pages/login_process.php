<?php

require_once 'autoload.php';
require 'config/database.php';

use controllers\LoginController;

session_start();
$loginController = new LoginController($pdo);
$loginController->logIn();
