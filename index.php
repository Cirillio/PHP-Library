<?php
// Получаем URI запроса
$request = $_SERVER['REQUEST_URI'];

// Убираем параметры запроса (например, ?id=1), если они есть
$request = parse_url($request, PHP_URL_PATH);

// Определяем маршруты
switch ($request) {

    case '/library':
        require __DIR__ . '/pages/main.php'; // Главная страница в корне
        break;
    case '/login':
        require __DIR__ . '/pages/login.php'; // Страница логина в папке pages
        break;
    case '/logout':
        require __DIR__ . '/pages/logout.php'; // Страница логина в папке pages
        break;
    case '/login_process':
        require __DIR__ . '/pages/login_process.php'; // Страница логина в папке pages
        break;
    case '/register_process':
        require __DIR__ . '/pages/register_process.php'; // Страница логина в папке pages
        break;
    case '/register':
        require __DIR__ . '/pages/register.php'; // Страница регистрации в папке pages
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php'; // Страница 404 для неизвестных маршрутов
        break;
}
