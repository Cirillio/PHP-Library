<?php
// Получаем URI запроса
$request = $_SERVER['REQUEST_URI'];

// Убираем параметры запроса (например, ?id=1), если они есть
$request = parse_url($request, PHP_URL_PATH);

// Определяем маршруты
switch ($request) {
    case '/profile':
        require __DIR__ . '/pages/profile.php';
        break;
    case '/library':
        require __DIR__ . '/pages/main.php';
        break;
    case '/login':
        require __DIR__ . '/pages/login.php';
        break;
    case '/logout':
        require __DIR__ . '/pages/logout.php';
        break;
    case '/login_process':
        require __DIR__ . '/pages/login_process.php';
        break;
    case '/register_process':
        require __DIR__ . '/pages/register_process.php';
        break;
    case '/register':
        require __DIR__ . '/pages/register.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php'; // Страница 404 для всех неизвестных маршрутов
        break;
}
