<?php
session_start();

require_once 'autoload.php';
require 'config/config.php';
require 'config/database.php';

use models\CurrentUser;
use controllers\BookController;
use controllers\CartController;

$AUTH = checkAuth();

$USER = $AUTH ? new CurrentUser($pdo, $_SESSION['user_id']) : null;


$CartController = new CartController($pdo, $USER ? $USER->getId() : null);
$BookController = new BookController($pdo);
$books = $BookController->getCatalog();
// $cart = $CartController->getCart();
$TITLE = "Каталог | PHP Library";
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/public/logo.svg" type="image/svg+xml">

    <title>
        <?php echo $TITLE; ?>
    </title>

    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "/public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />


    <link rel="stylesheet" href="/public/assets/themes.css">
    <link rel="stylesheet" href="/public/assets/logo.css">
    <link rel="stylesheet" href="/public/assets/root.css">
</head>

<body>

    <?php include "components/header.php";
    ?>

    <main class="xl:px-20 md:px-10 sm:px-4 px-2">
        <h1 class="text-2xl sm:text-3xl rounded-md bg-base-200 font-semibold shadow-sm w-fit mx-auto sm:mx-0 p-2 text-center text-accent my-8">Каталог книг</h1>
        <div class="flex gap-2">
            <div class="lg:flex min-[100px]:hidden flex-col gap-2 flex-1/4 border border-base-content rounded-md shadow-md py-2">
                <h2 class="text-2xl font-semibold text-center text-primary">Категории</h2>
                <a class="category-btn btn btn-ghost" href="/library">Весь каталог</a>
                <a class="category-btn btn btn-ghost" data-genre="Роман" href="/library?category=Роман">Роман</a>
                <a class="category-btn btn btn-ghost" data-genre="Детектив" href="/library?category=Детектив">Детектив </a>
                <a class="category-btn btn btn-ghost" data-genre="Повесть" href="/library?category=Повесть">Повесть</a>
                <a class="category-btn btn btn-ghost" data-genre="Антиутопия" href="/library?category=Антиутопия">Антиутопия</a>
                <a class="category-btn btn btn-ghost" data-genre="Романтика" href="/library?category=Романтика">Романтика</a>
            </div>
            <div class="grid xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-1 sm:gap-x-2 sm:gap-y-4 flex-3/4 flex-wrap">
                <?php foreach ($books as $book): ?>
                    <div class="flex flex-col bg-base-200 hover:border-base-content border transition-all duration-75 border-base-100 rounded-sm overflow-hidden gap-2">
                        <a href="">
                            <picture class="h-[300px] relative flex bg-base-300 justify-center items-center ">
                                <img
                                    src="../root/books/<?= $book->cover_image ?>"
                                    alt="<?= $book->title ?>"
                                    class="h-full w-full m-auto object-fit object-contain" />

                                <?php if ($book->stock < 10): ?>
                                    <span class="absolute top-1 right-1 sm:top-2 sm:right-2 bg-warning book-warning text-base-100 px-2 py-1 rounded-sm">
                                        Осталось мало книг
                                    </span>
                                <?php endif; ?>
                            </picture>
                        </a>

                        <div class=" flex-1 grid grid-rows-4 px-1 py-1 gap-2">
                            <span class="row-span-2 flex flex-col">
                                <a href="" class="w-fit"><strong class="book-title"><?= $book->title ?></strong></a>
                                <a href="" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
                            </span>
                            <strong class="row-start-3 flex items-center book-price"><?= $book->price ?>₱</strong>
                            <div class="w-full row-start-4 flex items-center gap-1">
                                <button data-in-cart="false" data-cart="<?= $book->id ?>" class="add-to-cart btn flex-1 btn-primary button text-nowrap">В корзину</button>
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


    <script src="../public/assets/categories.js"></script>
    <script src="../public/assets/header.js"></script>
    <script src="/public/axios.min.js"></script>
    <script>
        const book_cart_btn = document.querySelectorAll(".add-to-cart");

        async function AddBookToCart(book) {
            const book_id = Number(book.dataset.cart);
            await axios.post("/cart?action=add", {
                "book_id": book_id
            }).then(response => {
                console.log(response);
                inCart(book);
            }).catch(error => {
                console.log(error);
            })
        }

        async function RemoveBookFromCart(book) {
            const book_id = Number(book.dataset.cart);
            await axios.post("/cart?action=remove", {
                "book_id": book_id
            }).then(response => {
                notInCart(book);
            }).catch(error => {
                console.log(error);
            })
        }

        const addToCartHandler = (event) => {
            const inCart = event.target.dataset.inCart === "true";
            inCart ? RemoveBookFromCart(event.target) : AddBookToCart(event.target);
        }

        function inCart(book) {
            book.dataset.inCart = "true";
            book.classList.add("btn-secondary");
            book.classList.remove("btn-primary");
            book.textContent = "В корзине";
        }

        function notInCart(book) {
            book.dataset.inCart = "false";
            book.classList.remove("btn-secondary");
            book.classList.add("btn-primary");
            book.textContent = "В корзину";
        }

        book_cart_btn.forEach(book => {
            book.onclick = addToCartHandler;
        })

        async function GetCart() {
            await axios.get("/cart?action=get").then(response => {
                const cart = response.data.data;

                console.log(cart);
                // Проверяем, что cart – это массив
                if (!Array.isArray(cart)) {
                    console.error("Ошибка: данные корзины не массив!", cart);
                    return null;
                }

                book_cart_btn.forEach(book => {
                    const book_id = Number(book.dataset.cart);

                    // Проверяем, есть ли книга в корзине
                    const _inCart = cart.some(item => item.book_id === book_id);

                    if (_inCart) {
                        inCart(book);
                    } else {
                        notInCart(book);
                    }

                });

                return cart;
            }).catch(error => {
                console.error("Ошибка при получении данных корзины:", error);
                return null;
            });
        }

        GetCart();
    </script>
</body>

</html>