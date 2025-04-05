<?php

session_start();

require_once 'autoload.php';
require 'config/config.php';
require 'config/database.php';

use models\CurrentUser;

$AUTH = checkAuth();
if (!$AUTH) header("Location: /login");

$USER = $AUTH ? new CurrentUser($pdo, $_SESSION['user_id']) : null;

$username = $USER->getUsername();
$role = $USER->getRole();
$avatar = $USER->getAvatar();
$email = $USER->getEmail();
$phone = $USER->getPhone();
$user_id = $USER->getId();
$date = explode(' ', $USER->getDateRegistration())[0];

$TITLE = $USER->getUsername() . " | Профиль | PHP Library";



?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/logo.svg" type="image/x-icon">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/public/assets/themes.css">
    <link rel="stylesheet" href="/public/assets/root.css">
    <link rel="stylesheet" href="/public/assets/logo.css">


    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "/public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>
</head>

<body class="flex flex-col min-h-screen">

    <?php include "components/header.php" ?>


    <main class="h-full w-full flex-col xl:px-20 md:px-10 sm:px-4 px-2 gap-2 py-4 flex-1 items-center flex">
        <div class="flex w-full md:justify-end justify-between items-center">
            <div class=" md:hidden">
                <div class="avatar">
                    <div class="w-16 rounded-xl">
                        <img src="root/avatars/<?= $avatar ?>" alt="<?= $user_id ?>_<?= $username ?>">
                    </div>
                </div>
            </div>
            <div class="flex sm:flex-row flex-col sm:gap-2 gap-1 items-center">
                <button class="w-fit btn  btn-primary md:btn-md btn-sm lg:btn-lg">Профиль</button>
                <button class="w-fit btn btn-ghost btn-primary md:btn-md btn-sm lg:btn-lg">Настройки</button>
            </div>
        </div>
        <div class="min-h-full flex flex-col md:grid grid-cols-2 w-full flex-1 rounded-xl shadow-md bg-base-200">
            <div class="flex md:flex-col bg-base-100 border-4 border-base-200 flex-row-reverse rounded-xl md:gap-4 md:p-4">
                <div class="min-[100px]:hidden md:flex mx-auto">
                    <div class="avatar">
                        <div class="lg:w-32 sm:w-24 w-16 rounded-xl">
                            <img src="root/avatars/<?= $avatar ?>" alt="<?= $user_id ?>_<?= $username ?>">
                        </div>
                    </div>
                </div>
                <div class="space-y-4 rounded-md w-full flex-x-1 md:bg-base-200 md:shadow-md p-4">
                    <ul class="space-y-4 profile-info">
                        <li class="flex  justify-between gap-2 border-b">
                            <span class=" text-accent">Пользователь:</span>
                            <span class="text-primary"><?= $username ?></span>
                        </li>
                        <li class="flex justify-between gap-2 border-b">
                            <span class=" text-accent">Почта:</span>
                            <span class="text-primary"><?= $email ?></span>
                        </li>
                        <li class="flex  justify-between gap-2 border-b">
                            <span class=" text-accent">Телефон:</span>

                            <?php if ($phone): ?>
                                <span class="text-primary"><?= $phone ?></span>
                            <?php else: ?>
                                <span class="text-error">Не указан</span>
                            <?php endif; ?>

                        </li>
                        <li class="flex justify-between gap-2 border-b">
                            <span class=" text-accent">Дата регистрации:</span>
                            <span class="text-primary"><?= $date ?></span>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-4 col-start-2 ">
                <h2>История заказов</h2>
            </div>
        </div>
    </main>

    <?php include "components/footer.php"; ?>


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
                if (_total == null) {
                    throw new Error("Вероятно, пользователь не авторизован. Получить данные о корзине не удалось.");
                }
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
                    throw new Error("Вероятно, пользователь не авторизован. Получить данные о корзине не удалось.");
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
    </script>

</body>

</html>