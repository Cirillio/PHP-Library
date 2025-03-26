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
</head>

<body class="flex flex-col min-h-screen">

    <?php include "components/header.php" ?>


    <main class="h-full w-full flex-col px-20 gap-2 py-4 flex-1 items-center flex">
        <ul class="flex gap-6 w-full justify-end items-center">
            <li class="w-fit btn  btn-primary btn-lg">Профиль</li>
            <li class="w-fit btn btn-ghost btn-primary btn-lg">Настройки</li>
        </ul>
        <div class="min-h-full grid grid-cols-2 w-full flex-1 rounded-xl shadow-md bg-base-200">
            <div class="flex flex-col items-end gap-4 p-4">
                <div class="avatar">
                    <div class="w-32 rounded-xl">
                        <img src="root/avatars/<?= $avatar ?>" alt="<?= $user_id ?>_<?= $username ?>">
                    </div>
                </div>
                <div class="space-y-4">
                    <ul class="space-y-2">
                        <li class="flex  justify-end gap-2 bo border">
                            <span class="font-semibold">Пользователь:</span>
                            <span class="font-semibold"><?= $username ?></span>
                        </li>
                        <li class="flex justify-end gap-2 bo border">
                            <span class="font-semibold">Дата регистрации:</span>
                            <span class="font-semibold"><?= $date ?></span>
                        </li>
                        <li class="flex justify-end gap-2 border">
                            <span class="font-semibold">Почта:</span>
                            <span class="font-semibold"><?= $email ?></span>
                        </li>
                        <li class="flex  justify-end gap-2 bo border">
                            <span class="font-semibold">Телефон:</span>
                            <span class="font-semibold"><?= $phone ? $phone : "Не указан" ?></span>
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


    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "/public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>

</body>

</html>