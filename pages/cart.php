<?php
require_once 'autoload.php';
require 'config/config.php';
require 'config/database.php';

session_start();



use models\CurrentUser;

$AUTH = checkAuth();

$USER = $AUTH ? new CurrentUser($pdo, $_SESSION['user_id']) : header("Location: /login");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Корзина | PHP Library</title>
    <?php include "components/styles.php"; ?>
</head>

<body>

    <?php include "components/header.php" ?>

    <section></section>

    <?php include "components/footer.php" ?>

    <script src="/public/axios.min.js"></script>

</body>

</html>