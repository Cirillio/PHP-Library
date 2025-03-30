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

$genres = [
    "Фантастика",
    "Фэнтези",
    "Детектив",
    "Триллер",
    "Ужасы",
    "Роман",
    "Романтика",
    "Любовный роман",
    "Исторический роман",
    "Повесть",
    "Документальная литература",
    "Приключения",
    "Биография",
    "Мемуары",
    "Автобиография",
    "Философия",
    "Научная литература",
    "Научпоп",
    "Психология",
    "Саморазвитие",
    "Бизнес",
    "Экономика",
    "Политика",
    "Социология",
    "Юриспруденция",
    "Поэзия",
    "Драматургия",
    "Сатира",
    "Эссе",
    "Детская литература",
    "Подростковая литература",
    "Классика",
    "Современная проза",
    "Комиксы и графические новеллы",
    "Религия и духовность",
    "Мистика",
    "Киберпанк",
    "Антиутопия"
];



$CartController = new CartController($pdo, $USER ? $USER->getId() : null);
$BookController = new BookController($pdo);
$books_data = $BookController->getCatalog();
$books = $books_data['books'];
$total_pages = $books_data['totalPages'];
$current_page = $books_data['currentPage'];
// $cart = $CartController->getCart();
$TITLE = "Каталог | PHP Library";

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

    <main data-total-pages="<?= $total_pages ?>" data-current-page="<?= $current_page ?>" class="catalog xl:px-20 md:px-10 pb-10 sm:px-4 px-2">
        <h1 class="text-2xl sm:text-3xl rounded-md bg-base-200 font-semibold shadow-sm w-fit mx-auto sm:mx-0 p-2 text-center text-accent my-8">Каталог книг</h1>
        <div class="flex gap-2">
            <div class="lg:flex min-[100px]:hidden flex-col gap-2 flex-1/4 border border-base-content rounded-md shadow-md py-2">
                <h2 class="text-2xl font-semibold text-center text-primary">Категории</h2>
                <a class="category-btn btn btn-ghost" href="/library">Весь каталог</a>
                <?php foreach ($genres as $genre): ?>
                    <a class="category-btn btn btn-ghost" data-genre="<?= $genre ?>" href="/library?page=1&category=<?= $genre ?>"><?= $genre ?></a>
                <?php endforeach; ?>

            </div>
            <div class="flex flex-col gap-2 items-center  flex-3/4">
                <div class="pagination join w-fit">
                </div>
                <div class="w-full grid h-fit xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-1 sm:gap-x-2 sm:gap-y-4">
                    <?php foreach ($books as $book): ?>
                        <div data-id="<?= $book->id ?>" data-price="<?= $book->price ?>" class="book flex flex-col bg-base-200 hover:border-base-content border transition-all duration-75 border-base-100 rounded-lg overflow-hidden gap-2">
                            <a href="" class="relative ">
                                <picture class="h-[300px] flex bg-base-300 justify-center items-center ">
                                    <img
                                        src="../root/books/<?= $book->cover_image ?>"
                                        alt="<?= $book->title ?>"
                                        class="h-full w-full m-auto object-fit object-contain"
                                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-xl bg-black w-full h-full flex justify-center text-center items-center\'>Нет изображения</div>';" />
                                    <?php if ($book->stock < 10): ?>
                                </picture>
                                <span class="absolute top-1 right-1 z-80 sm:top-2 sm:right-2 bg-warning book-warning text-base-100 px-2 py-1 rounded-sm">
                                    Осталось мало книг
                                </span>
                            <?php endif; ?>
                            </a>
                            <div class=" flex-1 grid grid-rows-4 px-1 py-1 gap-2">
                                <span class="row-span-2 flex flex-col">
                                    <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="w-fit"><strong class="book-title"><?= $book->title ?></strong></a>
                                    <a href="/author?id=<?= $book->author_id ?>&name=<?= $book->author_name ?>" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
                                </span>
                                <strong class="row-start-3 flex items-center book-price"><?= $book->price ?>₱</strong>
                                <div class="w-full row-start-4 flex items-center gap-1">
                                    <button data-in-cart="false" data-cart="<?= $book->id ?>" class="add-to-cart btn flex-1 btn-primary button text-nowrap">В корзину</button>
                                    <button class="btn btn-accent btn-square">
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
        </div>
    </main>


    <?php include "components/footer.php"; ?>


    <script src="../public/assets/categories.js"></script>
    <script src="../public/assets/header.js"></script>
    <script src="/public/axios.min.js"></script>
    <script>
        const cart_total = document.querySelector(".cart-total");
        const cart_quantity = document.querySelector(".cart-quantity");

        const total = {
            "total": 0,
            "quantity": 0
        };

        async function GetTotal() {
            await axios.get("/cart?action=total").then(response => {
                const _total = response.data.data;
                total.quantity = _total.quantity;
                total.total = _total.total;
                console.log(total);
                cart_total.textContent = total.total;
                cart_quantity.textContent = total.quantity;
            }).catch(error => {
                console.log(error);
            })
        }

        GetTotal();

        let cart = null;

        async function GetCart() {
            await axios.get("/cart?action=get").then(response => {
                const _cart = response.data.data;

                // Проверяем, что cart – это массив
                if (!Array.isArray(_cart)) {
                    cart = null;
                }

                book_cart_btn.forEach(book => {
                    const book_id = Number(book.dataset.cart);

                    // Проверяем, есть ли книга в корзине
                    const _inCart = _cart.some(item => item.book_id === book_id);

                    if (_inCart) {
                        inCart(book);
                    } else {
                        notInCart(book);
                    }

                });

                cart = _cart;
                // console.log(cart);
            }).catch(error => {
                console.error("Ошибка при получении данных корзины:", error);
                cart = null;
            });
        }

        GetCart();


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

        async function addToCartHandler(event) {
            const inCart = event.target.dataset.inCart === "true";
            inCart ? await RemoveBookFromCart(event.target) : await AddBookToCart(event.target);
            GetTotal();
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



        // const books = document.querySelectorAll(".book");

        // function updateTotal() {
        //     let total = 0;
        //     let quantity = 0;

        //     books.forEach(book => {
        //         const book_id = Number(book.dataset.id);
        //         const book_price = Number(book.dataset.price);
        //         const inCart = cart.some(item => item.book_id === book_id);
        //         console.log(inCart);

        //         console.log(book_id, book_price);
        //         if (inCart) {
        //             total += book_price;
        //             quantity++;
        //         }
        //     });

        //     cart_total.textContent = total;
        //     cart_quantity.textContent = quantity;
        // }
    </script>
    <script>
        const catalog = document.querySelector(".catalog");
        const pagination = document.querySelector(".pagination");
        const catalog_start_page = 1;
        const catalog_end_page = Number(catalog.dataset.totalPages);
        const catalog_current_page = Number(catalog.dataset.currentPage);


        let page_buttons = [];

        let btn_page_classes = "join-item btn";



        function SetUrlPage(page) {
            const url = new URL(window.location.href);
            const searchParams = new URLSearchParams(url.search);

            if (searchParams.has("page")) {
                searchParams.set("page", page);
            } else {
                searchParams.append("page", page);
            }

            return `?${searchParams.toString()}`;
        }

        function InsertLeftPages(current) {
            let left_pages = [];
            const moreThanFour = current > 4;
            if (moreThanFour) {
                for (let i = current - 1; i > current - 3; i--) {
                    const page_btn = document.createElement("a");

                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;

                    left_pages.push(page_btn);
                }
                const page_btw = document.createElement("a");
                page_btw.setAttribute("class", "join-item btn btn-disabled");
                page_btw.textContent = "...";
                left_pages.push(page_btw);

                const start_page_btn = document.createElement("a");
                start_page_btn.setAttribute("class", btn_page_classes);
                start_page_btn.setAttribute("href", SetUrlPage(catalog_start_page));
                start_page_btn.textContent = catalog_start_page;
                left_pages.push(start_page_btn);
            } else {
                for (let i = current - 1; i > 0; i--) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;
                    left_pages.push(page_btn);
                }
            }
            return left_pages.reverse();
        }

        function InsertRightPages(current) {
            let right_pages = [];
            const moreThanFour = catalog_end_page + 1 - current > 4;
            if (moreThanFour) {
                for (let i = current + 1; i < current + 3; i++) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;
                    right_pages.push(page_btn);
                }
                const page_btw = document.createElement("a");
                page_btw.setAttribute("class", "join-item btn btn-disabled");
                page_btw.textContent = "...";
                right_pages.push(page_btw);

                const end_page_btn = document.createElement("a");

                end_page_btn.setAttribute("class", btn_page_classes);
                end_page_btn.setAttribute("href", SetUrlPage(catalog_end_page));
                end_page_btn.textContent = catalog_end_page;
                right_pages.push(end_page_btn);
            } else {
                for (let i = current + 1; i < catalog_end_page + 1; i++) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;

                    right_pages.push(page_btn);
                }
            }
            return right_pages;
        }

        function RenderPagination(current) {

            const left = InsertLeftPages(current);
            const right = InsertRightPages(current);

            const current_page = document.createElement("a");
            current_page.setAttribute("class", btn_page_classes + " btn-active");
            current_page.setAttribute("href", SetUrlPage(current));
            current_page.textContent = current;

            page_buttons = [...left, current_page, ...right];
            pagination.replaceChildren(...page_buttons);
        }

        RenderPagination(catalog_current_page);
    </script>
</body>

</html>