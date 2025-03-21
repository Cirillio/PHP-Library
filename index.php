<?php

require './autoload.php';


$TITLE = "PHP Library";
require './config/database.php';

use controllers\BookController;

$BookController = new BookController($pdo);

$books = $BookController->getCatalog();

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
    <link rel="stylesheet" href="./public/assets/themes.css">
    <link rel="stylesheet" href="./public/assets/logo.css">
    <link rel="stylesheet" href="./public/assets/root.css">
    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "./public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>
</head>

<body class="flex flex-col min-h-dvh">

    <?php include "components/header.php"; ?>

    <main class="xl:px-20 md:px-10 px-4">
        <h1 class="text-3xl font-semibold text-primary my-8">Каталог книг</h1>
        <div class="flex gap-2">
            <div class="lg:flex min-[100px]:hidden flex-col gap-2 flex-1/4">
                <h2 class="text-2xl font-semibold text-center text-primary">Категории</h2>
                <a class="category-btn btn btn-ghost" data-genre="" href="/">Весь каталог</a>
                <a class="category-btn btn btn-ghost" data-genre="Роман" href="/?category=Роман">Роман</a>
                <a class="category-btn btn btn-ghost" data-genre="Детектив" href="/?category=Детектив">Детектив </a>
                <a class="category-btn btn btn-ghost" data-genre="Повесть" href="/?category=Повесть">Повесть</a>
                <a class="category-btn btn btn-ghost" data-genre="Антиутопия" href="/?category=Антиутопия">Антиутопия</a>
                <a class="category-btn btn btn-ghost" data-genre="Романтика" href="/?category=Романтика">Романтика</a>
            </div>
            <div class="grid lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-1 gap-y-2 flex-3/4 flex-wrap ">
                <?php foreach ($books as $book): ?>
                    <div class="flex flex-col shadow-sm rounded-sm overflow-hidden gap-2">
                        <picture class="h-[300px] relative flex justify-center items-center ">
                            <img
                                src="./root/books/<?= $book->cover_image ?>"
                                alt="<?= $book->title ?>"
                                class="h-full w-full m-auto object-fit object-contain" />

                            <?php if ($book->stock < 10): ?>
                                <span class="absolute top-2 right-2 bg-warning text-base-100 px-2 py-1 rounded-sm">
                                    Осталось мало книг
                                </span>
                            <?php endif; ?>

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

                <?php if (!$books): ?>
                    <span class=" text-2xl font-semibold text-center text-error">
                        Ничего не найдено.
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </main>


    <?php include "components/footer.php"; ?>


    <script>
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get('category');
        console.log(category);
        const categoryBtns = document.querySelectorAll('.category-btn');
        categoryBtns.forEach(btn => {
            btn.classList.add('btn-ghost');
            btn.removeAttribute('disabled');
            if (btn.dataset.genre === category) {
                btn.classList.remove('btn-ghost');
                btn.setAttribute('disabled', true);
            }
        });
    </script>

</body>

</html>