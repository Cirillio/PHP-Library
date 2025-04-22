<?php
// Секретный ключ, который ты укажешь в настройках Webhook на GitHub
$dotenv = \Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();
$secret = $_ENV['WEBHOOK_SECRET'] ?? ''; // Замени на свой секрет

// Путь к корню проекта (public_html) — на уровень выше от scripts
$projectPath = realpath(__DIR__ . '/..');
// Путь к лог-файлу — logs находится в public_html
$logFile = "$projectPath/logs/webhook.log";

// Проверяем подпись от GitHub для безопасности
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE'] ?? '';
$payload = file_get_contents('php://input');
$hash = "sha1=" . hash_hmac('sha1', $payload, $secret);

if (!hash_equals($signature, $hash)) {
    http_response_code(403);
    file_put_contents($logFile, date('Y-m-d H:i:s') . " - Invalid signature\n", FILE_APPEND);
    die("Invalid signature");
}

// Выполняем git pull и composer install
$output = shell_exec("cd $projectPath && git pull origin main 2>&1 && composer install --no-dev 2>&1");

// Логируем результат
file_put_contents($logFile, date('Y-m-d H:i:s') . " - Webhook executed:\n$output\n", FILE_APPEND);

// Отправляем ответ
http_response_code(200);
echo "Webhook processed successfully.";
