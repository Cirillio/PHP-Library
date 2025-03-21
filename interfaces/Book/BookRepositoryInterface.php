<?php

namespace interfaces\Book;

use models\Book;

interface BookRepositoryInterface
{
    public function getOne($id): Book;

    public function getForCatalog($params = null): array;


    public function create(Book $Book): Book;

    public function update(Book $Book): Book;

    public function delete($id);
}
