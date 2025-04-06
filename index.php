<?php
session_start();

require_once 'autoload.php';
require_once 'config/config.php';

use config\Database;
use models\CurrentUser;
use controllers\RegisterController;
use controllers\LoginController;
use controllers\BookController;
use controllers\CartController;

$pdo = Database::getConnection();

$AUTH = checkAuth();

$USER = new CurrentUser($pdo, $_SESSION['user_id'] ?? null);

$registerController = new RegisterController($pdo);
$loginController = new LoginController($pdo);
$BookController = new BookController($pdo);
$cartController = new CartController($pdo, $USER->getId());


$request = $_SERVER['REQUEST_URI'];

$request = parse_url($request, PHP_URL_PATH);

switch ($request) {
    case '/profile':
        require __DIR__ . '/pages/profile.php';
        break;
    case '/catalog':
        require __DIR__ . '/pages/main.php';
        break;
    case '/login':
        require __DIR__ . '/pages/login.php';
        break;
    case '/logout':
        require __DIR__ . '/pages/logout.php';
        break;
    case '/login_process':
        require __DIR__ . '/requests/login_process.php';
        break;
    case '/register_process':
        require __DIR__ . '/requests/register_process.php';
        break;
    case '/register':
        require __DIR__ . '/pages/register.php';
        break;
    case '/cart_process':
        require __DIR__ . '/requests/cart_process.php';
        break;
    case '/cart':
        require __DIR__ . '/pages/cart.php';
        break;

    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php';
        break;
}
