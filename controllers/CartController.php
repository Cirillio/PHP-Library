<?php

namespace controllers;

use repositories\CartRepository;

use Exception;

class CartController
{
    private $cartRepository;
    private $user = null;
    public function __construct($pdo, $user_id)
    {
        $this->cartRepository = new CartRepository($pdo);
        $this->user = $user_id;
    }

    public function addToCart($book_id)
    {
        $response = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {

                $existingItem = $this->cartRepository->FindInCart($book_id, $this->user);
                if ($existingItem) {
                    throw new Exception('ALREADY_IN_CART');
                }

                $response["success"] = true;
                $response["message"] = "Книга успешно добавлена в корзину";
                $response['data'] = $this->cartRepository->AddToCart($book_id, $this->user);
                http_response_code(201);
                echo json_encode($response);
            } catch (Exception $e) {
                $response["success"] = false;
                $response["message"] = $e->getMessage();
                if ($e->getMessage() === 'ALREADY_IN_CART') {
                    http_response_code(409); // Conflict
                } else {
                    http_response_code(500); // Internal Server Error
                }
            }
        } else {
            $response["success"] = false;
            $response["message"] = "Неверный запрос";
            http_response_code(405);
            echo json_encode($response);
        }
    }

    public function removeFromCart($book_id)
    {
        $response = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $existingItem = $this->cartRepository->FindInCart($book_id, $this->user);
                if (!$existingItem) {
                    throw new Exception('NOT_IN_CART');
                }

                $response["success"] = true;
                $response["message"] = "Книга успешно удалена из корзины";
                $response['data'] = $this->cartRepository->RemoveFromCart($book_id, $this->user);
                http_response_code(200);
                echo json_encode($response);
            } catch (Exception $e) {
                $response["success"] = false;
                $response["message"] = $e->getMessage();
                if ($e->getMessage() === 'NOT_IN_CART') {
                    http_response_code(404); // Not Found
                } else {
                    http_response_code(500); // Internal Server Error
                }
            }
        } else {
            $response["success"] = false;
            $response["message"] = "Неверный запрос";
            http_response_code(405);
            echo json_encode($response);
        }
    }

    public function getCart()
    {
        $response = [];
        try {
            $response["success"] = true;
            $response["message"] = "Корзина";
            $response['data'] = $this->cartRepository->GetCart($this->user);
            http_response_code(200);
            echo json_encode($response);
        } catch (Exception $e) {
            $response["success"] = false;
            $response["message"] = $e->getMessage();
            http_response_code(500); // Internal Server Error
        }
    }

    public function getTotal()
    {
        $response = [];
        try {
            $response["success"] = true;
            $response["message"] = "Сумма корзины";
            $response['data'] = $this->cartRepository->GetTotal($this->user);
            http_response_code(200);
            echo json_encode($response);
        } catch (Exception $e) {
            $response["success"] = false;
            $response["message"] = $e->getMessage();
            http_response_code(500); // Internal Server Error
        }
    }
}
