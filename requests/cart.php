<?php
require_once 'autoload.php';
require "config/database.php";
session_start();

use controllers\CartController;

if (!isset($_SESSION['user_id'])) {
    header("Location: /login");
    exit;
}

$user_id = $_SESSION['user_id'];
$cartController = new CartController($pdo, $user_id);

header('Content-Type: application/json');

$action = $_GET['action'] ?? null;

$data = json_decode(file_get_contents("php://input"), true);

$response = ["success" => false];

switch ($action) {
    case 'add':

        if (!isset($data['book_id']) || !is_numeric($data['book_id'])) {
            $response["message"] = "Неверный идентификатор книги";
            http_response_code(400);
            echo json_encode($response);
            exit;
        }

        $cartController->addToCart((int)$data['book_id']);
        break;

    case 'remove':

        if (!isset($data['book_id']) || !is_numeric($data['book_id'])) {
            $response["message"] = "Неверный идентификатор книги";
            http_response_code(400);
            echo json_encode($response);
            exit;
        }

        $cartController->removeFromCart((int)$data['book_id']);
        break;

    case 'get':
        $cartController->getCart();
        break;

    case "total":
        $cartController->getTotal();
        break;

    default:
        $response["message"] = "Неверный запрос";
        http_response_code(405);
        echo json_encode($response);
}
