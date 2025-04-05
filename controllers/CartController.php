<?php

namespace controllers;

use repositories\CartRepository;

use Exception;

class CartController
{
    private  $cartRepository;
    private $user = null;
    public function __construct($pdo, $user_id)
    {
        $this->cartRepository = new CartRepository($pdo);
        $this->user = $user_id;
    }

    public function addToCart($book_id)
    {
        header('Content-Type: application/json');

        $response = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$book_id || !is_numeric($book_id)) {
                $response = "Неверный идентификатор книги";
                http_response_code(400);
                echo json_encode($response);
                exit;
            }

            $book_id = (int)$book_id;

            try {

                $existingItem = $this->cartRepository->FindInCart($book_id, $this->user);
                if ($existingItem) {
                    throw new Exception('ALREADY_IN_CART');
                }

                // $response["success"] = true;
                // $response["message"] = "Книга успешно добавлена в корзину";
                $response = $this->cartRepository->AddToCart($book_id, $this->user);
                http_response_code(201);
            } catch (Exception $e) {
                // $response["success"] = false;
                $response = $e->getMessage();
                if ($e->getMessage() === 'ALREADY_IN_CART') {
                    http_response_code(409); // Conflict
                } else {
                    http_response_code(500); // Internal Server Error
                }
            } finally {
                echo json_encode($response);
            }
        } else {
            // $response["success"] = false;
            $response = "Неверный запрос";
            http_response_code(405);
            echo json_encode($response);
        }
    }

    public function removeFromCart($book_id)
    {
        header('Content-Type: application/json');
        $response = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (!$book_id || !is_numeric($book_id)) {
                $response = "Неверный идентификатор книги";
                http_response_code(400);
                echo json_encode($response);
                exit;
            }

            $book_id = (int)$book_id;

            try {
                $existingItem = $this->cartRepository->FindInCart($book_id, $this->user);
                if (!$existingItem) {
                    throw new Exception('NOT_IN_CART');
                }

                // $response["success"] = true;
                // $response["message"] = "Книга успешно удалена из корзины";
                $response = $this->cartRepository->RemoveFromCart($book_id, $this->user);
                http_response_code(200);
            } catch (Exception $e) {
                // $response["success"] = false;
                $response = $e->getMessage();
                if ($e->getMessage() === 'NOT_IN_CART') {
                    http_response_code(404); // Not Found
                } else {
                    http_response_code(500); // Internal Server Error
                }
            } finally {
                echo json_encode($response);
            }
        } else {
            // $response["success"] = false;
            $response = "Неверный запрос";
            http_response_code(405);
            echo json_encode($response);
        }
    }

    public function getCart()
    {
        header('Content-Type: application/json');
        $response = null;
        try {
            // $response["success"] = true;
            // $response["message"] = "Корзина";
            $response = $this->cartRepository->GetCart($this->user);
            http_response_code(200);
        } catch (Exception $e) {
            // $response["success"] = false;
            $response = $e->getMessage();
            http_response_code(500); // Internal Server Error
        } finally {
            echo json_encode($response);
        }
    }

    public function getTotal()
    {
        header('Content-Type: application/json');
        $response = null;
        try {
            // $response["success"] = true;
            // $response["message"] = "Сумма корзины";
            $response = $this->cartRepository->GetTotal($this->user);
            http_response_code(200);
        } catch (Exception $e) {
            // $response["success"] = false;
            $response = $e->getMessage();
            http_response_code(500); // Internal Server Error
        } finally {
            echo json_encode($response);
        }
    }
}
