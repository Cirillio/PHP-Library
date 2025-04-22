<?php
setPageTitle("(500) Ошибка сервера");
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
            <img src="/public/icons/page-lost.svg" alt="404" class="w-full h-full">
        </picture>
        <div class="flex lg:gap-6 sm:gap-4 gap-2 items-center flex-col justify-center my-10 ">
            <span class="text-error lg:text-3xl sm:text-xl text-md font-bold select-none">Произошла ошибка:</span>
            <span class="text-error">
                <?php
                var_dump($e->getMessage());
                ?>
            </span>
            <a href="<?= $request ?>" class="btn btn-ghost btn-outline btn-error sm:btn-md btn-sm lg:btn-xl">Попробовать еще раз</a>
        </div>

    </div>

</body>

</html>