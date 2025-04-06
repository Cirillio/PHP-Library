<?php
if (!$AUTH) {
    header("Location: /login");
}
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