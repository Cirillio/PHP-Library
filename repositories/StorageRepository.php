<?php

namespace repositories;

use interfaces\Storage\StorageRepositoryInterface;
use models\Storage;

class StorageRepository implements StorageRepositoryInterface
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOne($book_id): Storage
    {
        $sql = "
        SELECT * FROM storage WHERE book_id = :book_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id]);
        $storage = $stmt->fetchObject(Storage::class);
        return $storage;
    }

    public function getStock($book_id)
    {
        $storage = $this->getOne($book_id);
        return $storage->stock;
    }

    public function getAll($params = null)
    {
        $sql = "
        SELECT * FROM storage
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        $storages = $stmt->fetchAll(\PDO::FETCH_CLASS, Storage::class);
        return $storages;
    }

    public function create($book_id, $stock)
    {
        $sql = "
        INSERT INTO storage (book_id, stock) VALUES (:book_id, :stock)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id, 'stock' => $stock]);
        return $this->getOne($book_id);
    }

    public function update($book_id, $stock)
    {
        $sql = "
        UPDATE storage SET stock = :stock WHERE book_id = :book_id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id, 'stock' => $stock]);
        return $this->getOne($book_id);
    }

    public function delete($book_id)
    {
        $sql = "
        DELETE FROM storage WHERE book_id = :book_id
        ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['book_id' => $book_id]);
        return $book_id;
    }
}
