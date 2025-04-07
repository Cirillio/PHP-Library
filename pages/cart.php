<?php
if (!$AUTH) {
    header("Location: /login");
}

$books = $bookController->getCart($USER->getId());
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/logo.svg" type="image/svg+xml">
    <title>Корзина | PHP Library</title>
    <?php include "components/styles.php"; ?>
</head>

<body class="flex flex-col max-h-screen min-h-screen">

    <?php include "components/header.php" ?>

    <main class="sm:overflow-hidden w-full xl:px-20 flex-1 md:px-10 sm:px-4 px-2 gap-2 py-4 flex flex-col">
        <div class="flex bg-base-200 min-h-0 flex-1 gap-1 w-full p-1 rounded-md shadow-md sm:flex-row flex-col">
            <section class="items-end flex-1 flex gap-1 flex-2/3 flex-col ">
                <div class="rounded-md bg-base-300 w-full p-2">
                    <h1 class="text-xl sm:text-2xl text-shadow-sm text-primary opacity-90 font-semibold ">Корзина</h1>
                </div>
                <?php if ($books) {
                    echo '<cart class="flex flex-col flex-1 overflow-y-auto w-full rounded-md bg-base-300 p-1 gap-4">';
                    foreach ($books as $book) {
                        include "components/BookCart.php";
                    }
                    echo '</cart>';
                } else {
                    include "components/EmptyCart.php";
                }
                ?>



            </section>
            <section class="h-fit rounded-md gap-10 p-2 flex bg-base-300 flex-col flex-1/3">
                <h2 class="text-secondary text-xl sm:text-2xl text-center">Оформление заказа</h2>
                <ul class="flex flex-col px-4 gap-4">
                    <li class="flex w-full items-baseline gap-2">
                        <span>Товара:</span>
                        <span class="cart-quantity">0</span>
                        <div class="w-full border-b border-dotted border-base-content"></div>
                        <span class="cart-total"></span>
                        <span class="text-error">₽</span>
                    </li>
                    <li class="flex w-full items-baseline gap-2">
                        <span class="font-semibold">Итого:</span>
                        <div class="w-full border-b border-dotted border-base-content"></div>
                        <span class="cart-books-total font-normal"></span>
                        <span class="text-error">₽</span>
                    </li>
                </ul>
                <button class="btn btn-primary <?php if (!$books) echo "btn-disabled" ?>">Оформить</button>
            </section>
        </div>
    </main>

    <?php include "components/footer.php" ?>

    <script src="/public/axios.min.js"></script>
    <script type="module">
        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        document.addEventListener("DOMContentLoaded", async () => {
            const cart_controller = new CartController();
            await cart_controller.InitCartAsync();
            await cart_controller.InitBooksAsync();
        })
    </script>


</body>

</html>