<?php

namespace controllers;

use repositories\BookRepository;
use repositories\CartRepository;

class BookController
{

    private $BookRepository;
    private $CartRepository;

    public function __construct($pdo)
    {
        $this->BookRepository = new BookRepository($pdo);
        $this->CartRepository = new CartRepository($pdo);
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

    public function getCart($user_id): array
    {
        $id_list = array_column($this->CartRepository->GetCart($user_id), 'book_id');
        return $this->BookRepository->GetForCart($id_list);
    }

    // public function create(Book $Book): Book {}

    // public function update(Book $Book): Book {}

    // public function delete(Book $Book) {}
}
