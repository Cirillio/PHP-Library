<?php
// Получаем URI запроса
$request = $_SERVER['REQUEST_URI'];

// Убираем параметры запроса (например, ?id=1), если они есть
$request = parse_url($request, PHP_URL_PATH);

// Определяем маршруты
switch ($request) {
    case '/':
    case '':
        require __DIR__ . '/pages/main.php'; // Главная страница в корне
        break;
    case '/about':
        require __DIR__ . '/pages/about.php'; // Страница about в папке pages
        break;
    case '/contact':
        require __DIR__ . '/pages/contact.php'; // Страница contact в папке pages
        break;
    case '/login':
        require __DIR__ . '/pages/login.php'; // Страница contact в папке pages
        break;
    case '/register':
        require __DIR__ . '/pages/register.php'; // Страница contact в папке pages
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/pages/404.php'; // Страница 404 для неизвестных маршрутов
        break;
}
