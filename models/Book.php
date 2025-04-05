<?php

namespace models;

class Book
{
    private $id;
    private $title;
    private $genre;
    private $year;
    private $description;
    private $price;
    private $cover_image;
    private $author_id; // Только ID автора

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

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getGenre()
    {
        return $this->genre;
    }

    public function setGenre($genre)
    {
        $this->genre = $genre;
    }

    public function getYear()
    {
        return $this->year;
    }

    public function setYear($year)
    {
        $this->year = $year;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }

    public function getPrice()
    {
        return $this->price;
    }

    public function setPrice($price)
    {
        $this->price = $price;
    }

    public function getCoverImage()
    {
        return $this->cover_image;
    }

    public function setCoverImage($cover_image)
    {
        $this->cover_image = $cover_image;
    }

    public function getAuthorId()
    {
        return $this->author_id;
    }

    public function setAuthorId($author_id)
    {
        $this->author_id = $author_id;
    }


    public function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    public function formatPrice($price)
    {
        return number_format($price, 2, '.', ' ');
    }
}
