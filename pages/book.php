<?php

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $book_id = $_GET['id'];
    $book = $bookController->getOne($book_id);
    $book_title = $book->getTitle();
    $book_genre = $book->getGenre();
    $book_year = $book->getYear();
    $book_description = $book->getDescription();
    $book_price = $book->getPrice();
    $book_cover_image = $book->getCoverImage();
    $book_author_id = $book->getAuthorId();
    $book_author_name = $book->getAuthorName();
    $book_stock = $book->getStock();
    setPageTitle($book_title);
} else {
    echo "Wrong request";
    exit;
}


?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $TITLE; ?></title>
    <?php include "components/styles.php"; ?>
</head>

<body class="flex flex-col max-h-screen min-h-screen">

    <?php include "components/header.php";
    ?>

    <div class="2xl:px-60 xl:px-20 md:px-10 pb-10 sm:px-4 px-2 flex flex-1">
        <main class="book gap-1 p-1 flex flex-col sm:flex-row flex-1" data-in-cart="false" data-id="<?= $book_id ?>" data-price="<?= $book_price ?>" data-stock="<?= $book_stock ?>">
            <section class="flex flex-col gap-2 items-center sm:flex-3/7 lg:flex-1/5">
                <picture class="relative w-full rounded-3xl overflow-hidden shadow-sm aspect-square sm:aspect-3/4 min-h-[200px] flex bg-base-300 justify-center items-center">
                    <img src="../root/books/<?= $book_cover_image ?>" alt="$book_title"
                        class="h-full w-full m-auto object-fit object-contain"
                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-xl bg-black w-full h-full flex justify-center text-center items-center\'>Нет изображения</div>';" />
                    <?php if ($book_stock < 10 && $book_stock > 0): ?>
                        <span class="absolute top-1 right-1 z-80 sm:top-2 sm:right-2 btn btn-sm btn-active btn-error">
                            Осталось мало книг
                        </span>
                    <?php elseif ($book_stock == 0): ?>
                        <span class="absolute top-1 right-1 z-80 sm:top-2 sm:right-2 btn btn-sm btn-active btn-error">
                            Нет в наличии
                        </span>
                    <?php endif; ?>
                </picture>
                <h2 class="sm:text-2xl text-md px-4 py-2 w-full font-semibold text-base-content text-center bg-base-300 rounded-3xl sm:hidden"><?= $book_title ?></h2>

                <div class="flex flex-col-reverse sm:flex-col w-full gap-2">
                    <div class="w-full flex justify-end items-center gap-2 bg-base-200 shadow-sm rounded-3xl p-2">
                        <button disabled class="add-to-cart flex-1 btn sm:btn-md btn-sm  btn-primary button text-nowrap">В корзину</button>
                        <button class="btn sm:btn-md sm:flex-0 aspect-square btn-outline  flex-1 btn-sm btn-accent sm:btn-square">
                            <span class="sm:hidden">В избранное</span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-[1.2em] min-[100px]:hidden sm:block">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </button>
                    </div>
                    <ul class="w-full  space-y-2 profile-info bg-base-200 rounded-3xl shadow-sm p-2">
                        <li class="flex  justify-between gap-2 items-center  bg-base-300 py-1 px-4 rounded-3xl">
                            <span class=" text-accent">Автор:</span>
                            <span class="text-primary text-end"><?= $book_author_name ?></span>
                        </li>
                        <li class="flex justify-between gap-2 items-center bg-base-300 py-1 px-4 rounded-3xl">
                            <span class=" text-accent">Жанр:</span>
                            <span class="text-primary text-end"><?= $book_genre ?></span>
                        </li>
                        <li class="flex  justify-between gap- items-center  bg-base-300 py-1 px-4 rounded-3xl">
                            <span class=" text-accent">Год издания:</span>
                            <span class="text-primary text-end"><?= $book_year ?></span>
                        </li>
                        <li class="flex justify-between gap-2 items-center bg-base-300 py-1 px-4 rounded-3xl">
                            <span class=" text-accent">Доступно количество:</span>
                            <span class="text-primary text-end"><?= $book_stock ?></span>
                        </li>
                    </ul>
                </div>
            </section>
            <section class="flex flex-col gap-1 sm:flex-4/7 lg:flex-3/5">
                <h2 class="px-4 py-2 shadow-sm text-2xl font-semibold text-base-content text-center bg-base-300 rounded-3xl overflow-hidden min-[100px]:hidden sm:block"><?= $book_title ?></h2>
                <div class="p-4 flex-1 flex flex-col justify-between ">
                    <p class="text-lg"><?= $book_description ?></p>
                </div>
            </section>
        </main>
    </div>


    <?php include "components/footer.php";
    ?>

    <script src="/public/axios.min.js"></script>
    <script type="module">
        import {
            Cart
        }
        from "../public/assets/cart/Cart.js"
        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        document.addEventListener("DOMContentLoaded", async () => {
            const cart = new Cart("book");
            const cart_controller = new CartController(cart);
        })
    </script>

</body>

</html>