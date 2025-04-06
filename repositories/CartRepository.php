<?php

namespace repositories;


class CartRepository
{
    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function AddToCart($book_id, $user_id)
    {
        $sql = "INSERT INTO cart (book_id, user_id) VALUES (:book_id, :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id, 'user_id' => $user_id]);
        return $stmt->rowCount() > 0;
    }

    public function RemoveFromCart($book_id, $user_id)
    {
        $sql = "DELETE FROM cart WHERE book_id = :book_id AND user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id, 'user_id' => $user_id]);
        return $stmt->rowCount() > 0;
    }

    public function FindInCart($book_id, $user_id)
    {
        $sql = "SELECT * FROM cart WHERE book_id = :book_id AND user_id = :user_id LIMIT 1";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id, 'user_id' => $user_id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function GetCart($user_id)
    {
        $sql = "SELECT book_id FROM cart WHERE user_id = :user_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function GetTotal($user_id)
    {
        $sql = "SELECT COUNT(*) AS quantity, SUM(price) AS total FROM books WHERE id IN (SELECT book_id FROM cart WHERE user_id = :user_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return ['total' => $result['total'] ?? 0, 'quantity' => $result['quantity'] ?? 0];
    }
}
