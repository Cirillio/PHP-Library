<?php
if (!$AUTH) header("Location: /login");


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
    <link rel="icon" href="/public/logo.svg" type="image/svg+xml">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <?php include "components/styles.php"; ?>
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
    <script type="module">
        import {
            SetHeaderLinks
        } from "../public/assets/header.js"

        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        document.addEventListener("DOMContentLoaded", async () => {
            SetHeaderLinks();
            const cart_controller = new CartController();
            await cart_controller.InitCartAsync();
        })
    </script>

</body>

</html>