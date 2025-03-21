<?php

namespace models;

class Storage
{
    public $book_id;
    public $stock;

    public function __construct($data)
    {
        $this->book_id = $data['book_id'];
        $this->stock = $data['stock'];
    }
}
