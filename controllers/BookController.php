<?php

namespace controllers;

use interfaces\Book\BookControllerInterface;
use repositories\BookRepository;
use models\Book;

class BookController implements BookControllerInterface
{

    private $BookRepository;

    public function __construct($pdo)
    {
        $this->BookRepository = new BookRepository($pdo);
    }

    // public function getOne($id): Book {}

    public function getCatalog(): array
    {
        $params = [];

        if (isset($_GET['category'])) {
            $params['category'] = $_GET['category'];
        }

        if (isset($_GET['author'])) {
            $params['author'] = $_GET['author'];
        }

        if (isset($_GET['title'])) {
            $params['title'] = $_GET['title'];
        }

        if (isset($_GET['year'])) {
            $params['year'] = $_GET['year'];
        }

        $limit = 12;  // Количество книг на странице
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Текущая страница (по умолчанию 1)

        $books = $this->BookRepository->getForCatalog($params, $limit, $page);
        $totalBooks = $this->BookRepository->getTotalBooksCount($params);
        // Вычисляем количество страниц
        $totalPages = ceil($totalBooks / $limit);

        return [
            'books' => $books,
            'totalPages' => $totalPages,
            'currentPage' => $page
        ];
    }

    // public function create(Book $Book): Book {}

    // public function update(Book $Book): Book {}

    // public function delete(Book $Book) {}
}
