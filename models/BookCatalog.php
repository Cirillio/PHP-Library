<?php

namespace models;

class BookCatalog
{
    public $id;
    public $title;
    public $genre;
    public $year;
    public $price;
    public $cover_image;
    public $author_name;
    public $author_id;
    public $stock;


    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $this->escape($data['title']);
        $this->genre = $this->escape($data['genre']);
        $this->year = $data['year'];
        $this->price = $this->formatPrice($data['price']);
        $this->cover_image = $this->escape($data['cover_image']);
        $this->author_name = $this->escape($data['author_name']);
        $this->author_id = $data['author_id'];
        $this->stock = $data['stock'];
    }

    private function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    private function formatPrice($price)
    {
        return number_format($price, 2, '.', ' ');
    }
}
