<?php
require_once 'autoload.php';
require "config/database.php";
session_start();

use controllers\CartController;

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["message" => "Пользователь не авторизован"]);
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];
$cartController = new CartController($pdo, $user_id);


$action = $_GET['action'] ?? null;

$data = json_decode(file_get_contents("php://input"), true);

$response = ["success" => false];

switch ($action) {
    case 'add':
        $cartController->addToCart($data['book_id'] ? $data['book_id'] : null);
        break;

    case 'remove':
        $cartController->removeFromCart($data['book_id'] ? $data['book_id'] : null);
        break;

    case 'get':
        $cartController->getCart();
        break;

    case "total":
        $cartController->getTotal();
        break;

    case null:
        header("Location: /cart");
        exit;

    default:
        $response["message"] = "Неверный запрос";
        http_response_code(405);
        echo json_encode($response);
}
