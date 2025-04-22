<?php
setPageTitle("(404) Страница не найдена");
?>


<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $TITLE; ?></title>
    <?php include "components/styles.php"; ?>
</head>

<body>
    <?php include "components/header.php";
    ?>
    <div class=" flex-col items-center justify-center  w-full flex">
        <picture class="max-h-[600px] flex lg:w-1/3 sm:w-1/2 w-full object-contain object-center">
            <img src="/public/icons/page-not-found.svg" alt="404" class="w-full h-full">
        </picture>
        <div class="flex lg:gap-10 sm:gap-4 gap-2 items-center flex-wrap justify-center my-10 ">
            <span class="text-error lg:text-3xl sm:text-xl text-md font-bold select-none">Страница не найдена (404)</span>
            <a href="/" class="btn btn-ghost btn-outline btn-error sm:btn-md btn-sm lg:btn-xl">Вернуться</a>
        </div>
    </div>

    <?php include "components/footer.php"; ?>
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
            const cart = new Cart("catalog");
            const cart_controller = new CartController(cart);
        })
    </script>
</body>

</html>