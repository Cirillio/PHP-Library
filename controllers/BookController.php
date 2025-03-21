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
        $category = $_GET['category'] ?? null;
        $author = $_GET['author'] ?? null;
        $title = $_GET['title'] ?? null;
        $year = $_GET['year'] ?? null;

        $params = compact('category', 'author', 'title', 'year');

        return $this->BookRepository->getForCatalog($params);
    }

    // public function create(Book $Book): Book {}

    // public function update(Book $Book): Book {}

    // public function delete(Book $Book) {}
}
