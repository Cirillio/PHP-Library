<?php

namespace repositories;

use models\Book;
use models\BookCatalog;
use PDO;

class BookRepository
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
        WHERE
            books.id = :id
    ";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        $book = $stmt->fetch(PDO::FETCH_ASSOC);

        $book = new Book($book);

        return $book;
    }

    public function getForCatalog($params = null, $limit = 12, $page = 0): array
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
            authors.id AS author_id,
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

        // Обработка параметра category
        if (!empty($params['category'])) {
            if (is_array($params['category'])) {
                // Если category — массив, используем IN
                $placeholders = implode(',', array_fill(0, count($params['category']), '?'));
                $conditions[] = "books.genre IN ($placeholders)";
                $queryParams = array_merge($queryParams, $params['category']);
            } else {
                // Если category — строка
                $conditions[] = "books.genre = ?";
                $queryParams[] = $params['category'];
            }
        }

        // Обработка параметра title
        if (!empty($params['title'])) {
            $conditions[] = "books.title LIKE ?";
            $queryParams[] = '%' . $params['title'] . '%';
        }

        // Обработка параметра author
        if (!empty($params['author'])) {
            $conditions[] = "authors.name LIKE ?";
            $queryParams[] = '%' . $params['author'] . '%';
        }

        // Обработка параметра year
        if (!empty($params['year'])) {
            if (is_array($params['year'])) {
                // Если year — массив, используем IN
                $placeholders = implode(',', array_fill(0, count($params['year']), '?'));
                $conditions[] = "books.year IN ($placeholders)";
                $queryParams = array_merge($queryParams, $params['year']);
            } else {
                // Если year — строка
                $conditions[] = "books.year = ?";
                $queryParams[] = $params['year'];
            }
        }

        // Если есть условия, добавляем их в SQL-запрос
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Добавляем пагинацию
        $offset = ($page - 1) * $limit;
        $sql .= " LIMIT ? OFFSET ?";

        // Добавляем параметры пагинации
        $queryParams[] = $limit;
        $queryParams[] = $offset;

        // Подготавливаем и выполняем запрос
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($queryParams);

        $booksData = $stmt->fetchAll();
        $books = array_map(function ($bookData) {
            return new BookCatalog($bookData);
        }, $booksData);

        return $books;
    }

    public function getTotalBooksCount($params = null): int
    {
        $sql = "
        SELECT COUNT(*) AS total
        FROM 
            books
        JOIN
            authors
        ON
            books.author_id = authors.id
        ";

        // Массив для хранения условий и параметров
        $conditions = [];
        $queryParams = [];

        // Обработка параметра category
        if (!empty($params['category'])) {
            if (is_array($params['category'])) {
                // Если category — массив, используем IN
                $placeholders = implode(',', array_fill(0, count($params['category']), '?'));
                $conditions[] = "books.genre IN ($placeholders)";
                $queryParams = array_merge($queryParams, $params['category']);
            } else {
                // Если category — строка
                $conditions[] = "books.genre = ?";
                $queryParams[] = $params['category'];
            }
        }

        // Обработка параметра title
        if (!empty($params['title'])) {
            $conditions[] = "books.title LIKE ?";
            $queryParams[] = '%' . $params['title'] . '%';
        }

        // Обработка параметра author
        if (!empty($params['author'])) {
            $conditions[] = "authors.name LIKE ?";
            $queryParams[] = '%' . $params['author'] . '%';
        }

        // Обработка параметра year
        if (!empty($params['year'])) {
            if (is_array($params['year'])) {
                // Если year — массив, используем IN
                $placeholders = implode(',', array_fill(0, count($params['year']), '?'));
                $conditions[] = "books.year IN ($placeholders)";
                $queryParams = array_merge($queryParams, $params['year']);
            } else {
                // Если year — строка
                $conditions[] = "books.year = ?";
                $queryParams[] = $params['year'];
            }
        }

        // Если есть условия, добавляем их в SQL-запрос
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" AND ", $conditions);
        }

        // Подготавливаем и выполняем запрос
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($queryParams);

        $result = $stmt->fetch();
        return (int) $result['total'];
    }


    public function getForCart(array $id_list): array
    {
        if (empty($id_list)) {
            return [];
        }

        $placeholders = implode(',', array_fill(0, count($id_list), '?'));
        $sql = "
            SELECT 
                b.id, 
                b.title, 
                b.genre, 
                b.year,
                b.price, 
                b.cover_image, 
                a.name AS author_name, 
                a.id AS author_id,
                IFNULL(s.stock, 0) AS stock
            FROM books b
            JOIN authors a ON b.author_id = a.id
            LEFT JOIN storage s ON b.id = s.book_id
            WHERE b.id IN ($placeholders)";

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($id_list);

        $booksData = $stmt->fetchAll();
        $books = array_map(function ($bookData) {
            return new BookCatalog($bookData);
        }, $booksData);

        return $books;
    }

    public function getUniqueYears(): array
    {
        $sql = "SELECT DISTINCT year FROM books ORDER BY year DESC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }

    public function getUniqueGenres(): array
    {
        $sql = "SELECT DISTINCT genre FROM books ORDER BY genre ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
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
            'title' => $Book->getTitle(),
            'genre' => $Book->getGenre(),
            'year' => $Book->getYear(),
            'description' => $Book->getDescription(),
            'price' => $Book->getPrice(),
            'cover_image' => $Book->getCoverImage(),
            'author_id' => $Book->getAuthorId()
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
            'id' => $Book->getId(),
            'title' => $Book->getTitle(),
            'genre' => $Book->getGenre(),
            'year' => $Book->getYear(),
            'description' => $Book->getDescription(),
            'price' => $Book->getPrice(),
            'cover_image' => $Book->getCoverImage(),
            'author_id' => $Book->getAuthorId()
        ));

        $book = $this->getOne($Book->getId());
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
