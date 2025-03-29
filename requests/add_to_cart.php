<?php
require 'config/database.php';
require_once 'autoload.php';
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];

header('Content-Type: application/json'); // Ответ в формате JSON
$response = [];

$data = json_decode(file_get_contents("php://input"), true);

if (!isset($data['book_id']) || !is_numeric($data['book_id'])) {
    $response["success"] = false;
    $response["message"] = "Неверный идентификатор книги";
    $response['data'] = $data; // Логируем входящие данные
    http_response_code(400);
    echo json_encode($response);
    exit;
}

use controllers\CartController;

$cartController = new CartController($pdo, $user_id);

$book_id = $data['book_id'];


$cartController->addToCart($book_id);
