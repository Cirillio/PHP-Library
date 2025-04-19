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
    <h1>Страница не найдена</h1>

    <?php include "components/footer.php"; ?>
    <script src="/public/axios.min.js"></script>
    <script type="module">
        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        document.addEventListener("DOMContentLoaded", async () => {
            const cart_controller = new CartController("catalog");
            await cart_controller.InitCartAsync();
        })
    </script>
</body>

</html>