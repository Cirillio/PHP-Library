<?php

namespace models;

class Book
{
    public $id;
    public $title;
    public $genre;
    public $year;
    public $description;
    public $price;
    public $cover_image;
    public $author_id; // Только ID автора

    public function __construct($data)
    {
        $this->id = $data['id'];
        $this->title = $this->escape($data['title']);
        $this->genre = $this->escape($data['genre']);
        $this->year = $data['year'];
        $this->description = $this->escape($data['description']);
        $this->price = $this->formatPrice($data['price']);
        $this->cover_image = $this->escape($data['cover_image']);
        $this->author_id = $data['author_id'];
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
