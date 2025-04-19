<?php

namespace controllers;

use repositories\BookRepository;
use repositories\CartRepository;
use models\Book;

class BookController
{

    private $BookRepository;
    private $CartRepository;

    public function __construct($pdo)
    {
        $this->BookRepository = new BookRepository($pdo);
        $this->CartRepository = new CartRepository($pdo);
    }

    public function getOne($id): Book|null
    {
        if (is_numeric($id)) {
            return $this->BookRepository->getOne($id) ?? null;
        }
        return null;
    }

    public function getCatalog($params = null): array
    {

        $limit = 12;  // Количество книг на странице
        $page = $params['page'];

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

    public function getYearsPublish(): array
    {
        return $this->BookRepository->getUniqueYears();
    }

    public function getGenres(): array
    {
        return $this->BookRepository->getUniqueGenres();
    }

    // public function create(Book $Book): Book {}

    // public function update(Book $Book): Book {}

    // public function delete(Book $Book) {}
}
