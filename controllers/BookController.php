<?php

namespace controllers;

use repositories\BookRepository;

class BookController
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

        foreach ($_GET['filters'] ?? [] as $filterName => $filterValue) {
            if (!empty($filterValue)) {
                $params[$filterName] = $filterValue;
            }
        }

        $limit = 8;  // Количество книг на странице
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
