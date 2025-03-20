<?php

// Автозагрузка классов
spl_autoload_register(function ($class) {
    // Преобразуем пространство имен в путь к файлу
    $file = __DIR__ . '/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});;


$TITLE = "PHP Library";
require './config/database.php';

use models\BookCard;

$sql = "
    SELECT 
        books.id, 
        books.title, 
        books.genre, 
        books.year, 
        books.description, 
        books.price, 
        books.cover_image, 
        authors.name AS author_name, 
        authors.bio AS author_bio, 
        authors.birth_year AS author_birth_year, 
        authors.death_year AS author_death_year
    FROM 
        books
    JOIN 
        authors 
    ON 
        books.author_id = authors.id
";

$stmt = $pdo->query($sql);
$booksData = $stmt->fetchAll();
$books = array_map(function ($bookData) {
    return new BookCard($bookData);
}, $booksData);
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./public/logo.svg" type="image/x-icon">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="./assets/themes.css">
    <link rel="stylesheet" href="./assets/logo.css">
    <link rel="stylesheet" href="./assets/root.css">
</head>

<body class="flex flex-col min-h-dvh">

    <?php include "components/header.php"; ?>

    <main class="xl:px-20 md:px-10 px-4">
        <h1>Каталог книг</h1>
        <div class="flex">
            <div class="lg:flex min-[100px]:hidden border flex-col flex-1/4">
                <h2>Категории</h2>
                <h2>Категории</h2>
                <h2>Категории</h2>
                <h2>Категории</h2>
            </div>
            <div class="grid lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-1 gap-y-2 flex-3/4 flex-wrap ">
                <?php foreach ($books as $book): ?>
                    <div class="flex flex-col shadow-sm rounded-sm overflow-hidden gap-2">
                        <picture class="h-[300px]  flex justify-center items-center ">
                            <img
                                src="./root/books/<?= $book->cover_image ?>"
                                alt="<?= $book->title ?>"
                                class="h-full w-full m-auto object-fit object-contain" />
                        </picture>
                        <div class=" flex-1 flex flex-col justify-between gap-1 sm:px-3 pb-2 lg:gap-4 px-1 lg:px-6 pb-1 lg:pb-4">
                            <strong class="text-xl underline"><?= $book->price ?>₱</strong>
                            <a href="/" class="flex flex-col gap-1">
                                <strong class="font-semibold"><?= $book->title ?></strong>
                                <strong><?= $book->author_name ?></strong>
                            </a>
                            <div class="">
                                <button class="btn btn-primary">В корзину</button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>


    <?php include "components/footer.php"; ?>


    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "./assets/theme.js";
        loadTheme();
        setToggler();
    </script>

</body>

</html>