<?php
session_start();

require_once 'autoload.php';
require 'config/config.php';
require 'config/database.php';

$AUTH = checkAuth();


use controllers\BookController;

$TITLE = "PHP Library";

$BookController = new BookController($pdo);
$books = $BookController->getCatalog();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/logo.svg" type="image/svg+xml">

    <title>
        <?php echo $TITLE; ?>
    </title>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../public/assets/themes.css">
    <link rel="stylesheet" href="../public/assets/logo.css">
    <link rel="stylesheet" href="../public/assets/root.css">
    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "../public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>
</head>

<body>

    <?php include "components/header.php";
    ?>

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
            <div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-x-2 gap-y-4 flex-3/4 flex-wrap lg:px-8 ">
                <?php foreach ($books as $book): ?>
                    <div class="flex flex-col bg-base-200 hover:border-base-content border transition-all duration-75 border-base-100 rounded-sm overflow-hidden gap-2">
                        <a href="">
                            <picture class="h-[300px] relative flex bg-base-300 justify-center items-center ">
                                <img
                                    src="../root/books/<?= $book->cover_image ?>"
                                    alt="<?= $book->title ?>"
                                    class="h-full w-full m-auto object-fit object-contain" />
                                <?php if ($book->stock < 10): ?>
                                    <span class="absolute top-2 right-2 bg-warning text-base-100 px-2 py-1 rounded-sm">
                                        Осталось мало книг
                                    </span>
                                <?php endif; ?>
                            </picture>
                        </a>

                        <div class=" flex-1 grid grid-rows-4 px-1 py-1 gap-2">
                            <span class="row-span-2 flex flex-col">
                                <a href="" class="w-fit"><strong class="text-lg"><?= $book->title ?></strong></a>
                                <a href="" class="w-fit"><strong class="font-normal"><?= $book->author_name ?></strong></a>
                            </span>
                            <strong class="row-start-3 flex items-center text-xl"><?= $book->price ?>₱</strong>
                            <div class="w-full row-start-4 flex items-center gap-2">
                                <button class="btn flex-1 btn-primary">В корзину</button>
                                <button class="btn btn-secondary btn-square">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-[1.2em]">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                                    </svg>
                                </button>
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