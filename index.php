<?php
ini_set('display_errors', 0); // Отключаем вывод ошибок на экран
ini_set('log_errors', 1);     // Включаем логирование ошибок
ini_set('error_log', __DIR__ . '/logs/error.log'); // Указываем путь к файлу логов
error_reporting(E_ALL);       // Логируем все типы ошибок

require_once 'vendor/autoload.php';
require_once 'config/config.php';

$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__);

use config\Database;
use models\CurrentUser;
use controllers\RegisterController;
use controllers\LoginController;
use controllers\BookController;
use controllers\CartController;

session_start();
$request = htmlspecialchars(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ENT_QUOTES, 'UTF-8');

try {
    $pdo = Database::getConnection();
} catch (Exception $e) {
    error_log("Failed to initialize application: " . $e->getMessage());
    require __DIR__ . '/pages/error.php';
    exit;
}
$AUTH = checkAuth();

$USER = $AUTH ? new CurrentUser($pdo, $_SESSION['user_id']) : null;

$registerController = new RegisterController($pdo);
$loginController = new LoginController($pdo);
$bookController = new BookController($pdo);
$cartController = new CartController($pdo, $USER->getId());



switch ($request) {
    case '/profile':
        require __DIR__ . '/pages/profile.php';
        break;
    case '/catalog':
        require __DIR__ . '/pages/catalog.php';
        break;
    case '/book':
        require __DIR__ . '/pages/book.php';
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
