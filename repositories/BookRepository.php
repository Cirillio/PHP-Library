<?php

namespace repositories;

use interfaces\Book\BookRepositoryInterface;
use models\Book;
use models\BookCatalog;

class BookRepository implements BookRepositoryInterface
{
    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function getOne($id): Book
    {
        $sql = "
        SELECT 
            books.id, 
            books.title, 
            books.genre, 
            books.year, 
            books.description, 
            books.price, 
            books.cover_image, 
            books.author_id,

        FROM 
            books
        WHERE 
            books.id = :id";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetchObject(Book::class);

        return $book;
    }

    public function getForCatalog($params = null): array
    {

        $sql = "
        SELECT 
            books.id, 
            books.title, 
            books.genre, 
            books.year,
            books.price, 
            books.cover_image, 
            authors.name AS author_name, 
            IFNULL(storage.stock, 0) AS stock
        FROM 
            books
        JOIN 
            authors 
        ON 
            books.author_id = authors.id
        LEFT JOIN 
            storage
        ON 
            books.id = storage.book_id 
    ";

        // Массив для хранения условий и параметров
        $conditions = [];
        $queryParams = [];

        // Добавляем условия в зависимости от переданных параметров
        if (!empty($params['category'])) {
            $conditions[] = "books.genre = :category";
            $queryParams['category'] = $params['category'];
        }
        if (!empty($params['title'])) {
            $conditions[] = "books.title LIKE :title";
            $queryParams['title'] = '%' . $params['title'] . '%';
        }
        if (!empty($params['author'])) {
            $conditions[] = "authors.name LIKE :author";
            $queryParams['author'] = '%' . $params['author'] . '%';
        }
        if (!empty($params['year'])) {
            $conditions[] = "books.year = :year";
            $queryParams['year'] = $params['year'];
        }

        // Если есть условия, добавляем их в SQL-запрос
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Подготавливаем и выполняем запрос
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($queryParams);

        $booksData = $stmt->fetchAll();
        $books = array_map(function ($bookData) {
            return new BookCatalog($bookData);
        }, $booksData);

        return $books;
    }


    public function create(Book $Book): Book
    {

        $sql = "
        INSERT INTO
        books
        (title, genre, year, description, price, cover_image, author_id)
        VALUES
        (:title, :genre, :year, :description, :price, :cover_image, :author_id)
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            'title' => $Book->title,
            'genre' => $Book->genre,
            'year' => $Book->year,
            'description' => $Book->description,
            'price' => $Book->price,
            'cover_image' => $Book->cover_image,
            'author_id' => $Book->author_id
        ));
        $book = $this->getOne($this->pdo->lastInsertId());
        return $book;
    }

    public function update(Book $Book): Book
    {
        $sql = "
        UPDATE
        books
        SET
        title = :title,
        genre = :genre,
        year = :year,
        description = :description,
        price = :price,
        cover_image = :cover_image,
        author_id = :author_id
        WHERE
        id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(
            'title' => $Book->title,
            'genre' => $Book->genre,
            'year' => $Book->year,
            'description' => $Book->description,
            'price' => $Book->price,
            'cover_image' => $Book->cover_image,
            'author_id' => $Book->author_id,
            'id' => $Book->id
        ));

        $book = $this->getOne($Book->id);
        return $book;
    }

    public function delete($id)
    {
        $sql = "
        DELETE FROM books WHERE id = :id
        ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $id;
    }
}
