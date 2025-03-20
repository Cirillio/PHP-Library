<?php

$TITLE = "PHP Library";

$username = "Ivan";

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/public/logo.svg" type="image/x-icon">
    <title>
        <?php echo $username . " | " . $TITLE; ?>
    </title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="/assets/themes.css">
</head>

<body class="flex flex-col min-h-screen">

    <?php include "../components/header.php"; ?>


    <?php include "../components/footer.php"; ?>


    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "/assets/theme.js";
        loadTheme();
        setToggler();
    </script>

</body>

</html>