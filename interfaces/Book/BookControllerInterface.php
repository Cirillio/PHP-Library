<?php

namespace interfaces\Book;

use models\Book;

interface BookControllerInterface
{
    // public function getOne($id): Book;

    public function getCatalog(): array;

    // public function create(Book $Book): Book;

    // public function update(Book $Book): Book;

    // public function delete(Book $Book);
}
