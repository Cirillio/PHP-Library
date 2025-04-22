<?php

if (!$AUTH) {
    header("Location: /login");
}
setPageTitle("Корзина");

$books = $bookController->getCart($USER->getId());
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <?php include "components/styles.php"; ?>
</head>

<body class="max-h-screen ">

    <?php include "components/header.php" ?>

    <main class="w-full h-full flex-1 sm:overflow-hidden 2xl:px-60 xl:px-20  md:px-10 sm:px-4 px-2 gap-2 py-4 flex flex-col">
        <div class="flex min-h-0 h-full  flex-1 gap-1 w-full sm:flex-row flex-col">
            <section class="flex gap-1  flex-1 flex-2/3 flex-col ">
                <div class="rounded-3xl shadow-sm bg-base-300 w-full p-2">
                    <h1 class="text-xl text-center sm:text-2xl text-shadow-sm text-primary font-semibold ">Корзина</h1>
                </div>
                <div class="shadow-lg overflow-hidden w-full flex-1 lg:px-3 lg:py-3 rounded-3xl">
                    <?php if ($books): ?>
                        <cart class="flex flex-col sm:px-1 sm:overflow-y-auto h-full w-full gap-2">
                            <?php foreach ($books as $book):
                                include "components/BookCart.php";
                            endforeach;
                            ?>
                        </cart>
                    <?php else:
                        include "components/EmptyCart.php";
                    endif; ?>
                </div>
            </section>
            <section class="h-fit shadow-sm rounded-3xl gap-10 p-2 flex bg-base-300 flex-col flex-1/3">
                <h2 class="text-secondary text-xl sm:text-2xl text-center">Оформление заказа</h2>
                <ul class="flex flex-col lg:px-4 px-1 gap-4">
                    <li class="flex w-full items-baseline gap-2">
                        <span>Количество товаров:</span>
                        <div class="w-full flex-1 border-b border-dotted border-base-content"></div>
                        <span class="cart-quantity">0</span>
                        <span class="text-error">₽</span>
                    </li>
                    <li class="flex w-full items-baseline gap-2">
                        <span class="font-semibold">Итого:</span>
                        <div class="w-full border-b border-dotted border-base-content"></div>
                        <span class="cart-total font-normal"></span>
                        <span class="text-error">₽</span>
                    </li>
                </ul>
                <button class="order-form-open btn btn-primary <?php if (!$books) echo "btn-disabled" ?>">Оформить</button>
                <section id="order_form" class="order-modal hidden w-full h-full opacity-0 duration-150 fixed z-30 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2">
                    <div class="w-full h-full relative">
                        <div class="absolute order-form-close bg-[rgba(0,0,0,0.3)] w-full h-full  overflow-y-auto flex 3xl:px-140 2xl:px-120 xl:px-100 lg:px-60 sm:px-20 sm:py-0 py-4 px-4 top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 z-50 t w-full h-full">
                            <div class="flex flex-col items-center my-auto px-2  sm:px-10 w-full h-fit rounded-3xl shadow-sm bg-base-100 modal-content">
                                <h3 class="text-3xl uppercase my-6 font-semibold text-primary text-center">Заказ</h3>
                                <div class="flex flex-col gap-1 w-full">
                                    <ul class="flex text-sm flex-col gap-1 w-full">
                                        <li class="flex  text-primary bg-base-200 rounded-3xl shadow-sm px-4 py-2 justify-between">
                                            <span>Всего книг:</span>
                                            <span data-books="" class="order-books">9</span>
                                        </li>
                                        <li class="flex  text-primary bg-base-200 rounded-3xl shadow-sm px-4 py-2 justify-between">
                                            <span>Всего товаров:</span>
                                            <span data-quantity="" class="order-quantity">26</span>
                                        </li>
                                        <li class="flex  text-primary bg-base-200 rounded-3xl shadow-sm px-4 py-2 justify-between">
                                            <span>Доставка:</span>
                                            <span data-delivery="" class="order-delivery">500.00 <span class="text-error">₽</span>
                                        </li>
                                        <li class="flex  text-primary bg-base-200 rounded-3xl shadow-sm px-4 py-2 justify-between">
                                            <span>Итоговая сумма:</span>
                                            <span data-total="" class="order-quantity">15399.74 <span class="text-error">₽</span></span>
                                        </li>
                                    </ul>
                                    <fieldset class="fieldset min-w-full">
                                        <legend class="fieldset-legend text-lg mx-auto">Способ получения</legend>
                                        <div class="flex w-full items-center justify-center gap-4 order-check">
                                            <label class="label">
                                                <input type="checkbox" class="checkbox checkbox-primary order-shop" />
                                                <span class="text-lg">В магазине</span>
                                            </label>
                                            <label class="label">
                                                <input type="checkbox" class="checkbox checkbox-primary order-delivery" />
                                                <span class="text-lg">Доставка</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="fieldset min-w-full">
                                        <legend class="fieldset-legend text-lg mx-auto">Магазины</legend>
                                        <select class="select min-w-full text-primary cursor-pointer hover:bg-base-200 transition-all order-shop-delivery">
                                            <option disabled selected>Выберите магазин</option>
                                            <option>Ул. Ленина, д. 12</option>
                                            <option>Ул. Пушкина, д. 35, этаж 2</option>
                                        </select>
                                    </fieldset>
                                    <fieldset class="fieldset min-w-full">
                                        <legend class="fieldset-legend text-lg mx-auto">Адрес доставки</legend>
                                        <input type="text" placeholder="Введите адрес" class="input text-primary order-address-delivery min-w-full" />
                                    </fieldset>
                                    <fieldset class="fieldset min-w-full">
                                        <legend class="fieldset-legend text-lg mx-auto">Способ оплаты</legend>
                                        <div class="flex w-full items-center justify-center gap-4 order-check">
                                            <label class="label">
                                                <input type="checkbox" class="checkbox checkbox-primary order-pay-shop" />
                                                <span class="text-lg">При получении</span>
                                            </label>
                                            <label class="label">
                                                <input type="checkbox" class="checkbox checkbox-primary order-pay-online" />
                                                <span class="text-lg">Онлайн</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                    <fieldset class="fieldset min-w-full">
                                        <legend class="fieldset-legend text-lg mx-auto">Чек</legend>
                                        <div class="flex w-full items-center justify-center gap-4 order-check">
                                            <label class="label">
                                                <input <?= $USER->getPhone() ? "" : "disabled" ?> type="checkbox" class="checkbox checkbox-primary check-phone" />
                                                <span class="text-lg">На телефон</span>
                                            </label>
                                            <label class="label">
                                                <input type="checkbox" class="checkbox checkbox-primary check-email" />
                                                <span class="text-lg">На почту</span>
                                            </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="my-6 flex flex-wrap items-center justify-center gap-1">
                                    <button class="btn btn-lg btn-outline btn-secondary order-form-close">Отмена</button>
                                    <button class="btn btn-lg btn-primary order-send-btn ">Оформить</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </section>
        </div>
    </main>

    <?php include "components/footer.php" ?>

    <script src="/public/axios.min.js"></script>
    <script type="module">
        import {
            Cart
        }
        from '../public/assets/cart/Cart.js'

        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        import {
            Order
        }
        from "../public/assets/order/Order.js"

        document.addEventListener("DOMContentLoaded", async () => {
            const cart = new Cart("cart");
            const cart_controller = new CartController(cart);
            const order = new Order("#order_form", cart);
        })
    </script>


</body>

</html>