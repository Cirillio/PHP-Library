<?php

$categories = [
    "Фантастика",
    "Фэнтези",
    "Детектив",
    "Триллер",
    "Ужасы",
    "Роман",
    "Романтика",
    "Любовный роман",
    "Исторический роман",
    "Повесть",
    "Документальная литература",
    "Приключения",
    "Биография",
    "Мемуары",
    "Автобиография",
    "Философия",
    "Научная литература",
    "Научпоп",
    "Психология",
    "Саморазвитие",
    "Бизнес",
    "Экономика",
    "Политика",
    "Социология",
    "Юриспруденция",
    "Поэзия",
    "Драматургия",
    "Сатира",
    "Эссе",
    "Детская литература",
    "Подростковая литература",
    "Классика",
    "Современная проза",
    "Комиксы и графические новеллы",
    "Религия и духовность",
    "Мистика",
    "Киберпанк",
    "Антиутопия"
];

$books_data = $bookController->getCatalog();
$books = $books_data['books'];
$total_pages = $books_data['totalPages'];
$current_page = $books_data['currentPage'];

$TITLE = "Каталог | PHP Library";

?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/logo.svg" type="image/svg+xml">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <?php include "components/styles.php"; ?>
</head>

<body>

    <?php include "components/header.php";
    ?>

    <main data-total-pages="<?= $total_pages ?>" data-current-page="<?= $current_page ?>" class="catalog xl:px-20 md:px-10 pb-10 sm:px-4 px-2">
        <h1 class="text-2xl sm:text-3xl rounded-md bg-base-200 font-semibold shadow-sm w-fit mx-auto sm:mx-0 p-2 text-center text-accent my-8">Каталог книг</h1>
        <div class="flex gap-10">
            <div class="lg:flex min-[100px]:hidden flex-col gap-2 flex-1/4 border border-base-content rounded-md shadow-md py-2">
                <h2 class="text-2xl font-semibold text-center text-primary">Категории</h2>
                <a class="category-btn btn btn-ghost" href="/catalog">Весь каталог</a>
                <?php foreach ($categories as $category): ?>
                    <a class="category-btn btn btn-ghost" data-genre="<?= $category ?>" href="/catalog?page=1&category=<?= $category ?>"><?= $category ?></a>
                <?php endforeach; ?>

            </div>
            <?php if (!$books): ?>
                <span class=" text-2xl h-fit flex-3/4 font-semibold text-center text-error">
                    Ничего не найдено.
                </span>
            <?php else: ?>
                <div class="flex flex-col items-center gap-10  flex-3/4">

                    <div class="w-full grid h-fit xl:grid-cols-4 lg:grid-cols-3 md:grid-cols-4 sm:grid-cols-3 grid-cols-2 gap-1 sm:gap-x-2 sm:gap-y-4">
                        <?php if ($books) {
                            foreach ($books as $book) {
                                include "components/BookCatalog.php";
                            }
                        }
                        ?>

                    </div>

                    <div class="pagination join w-fit">
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </main>


    <?php include "components/footer.php"; ?>



    <script src="/public/axios.min.js"></script>
    <script type="module">
        import {
            SetHeaderLinks
        } from "../public/assets/header.js"

        import {
            SetCategories
        } from "../public/assets/categories.js"

        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        document.addEventListener("DOMContentLoaded", async () => {

            const catalog_url = new URL(window.location.href);
            let catalog_search_params = catalog_url.searchParams;

            if (!catalog_search_params.has("page")) {
                catalog_search_params.append("page", 1);
                window.history.pushState({}, "", catalog_url);
            }

            SetHeaderLinks();
            SetCategories();
            const cart_controller = new CartController("catalog");
            await cart_controller.InitCartAsync();
            await cart_controller.InitBooksAsync();
        })
    </script>


    <script>
        const catalog = document.querySelector(".catalog");
        const pagination = document.querySelector(".pagination");
        const catalog_start_page = 1;
        const catalog_end_page = Number(catalog.dataset.totalPages);
        const catalog_current_page = Number(catalog.dataset.currentPage);


        let page_buttons = [];

        let btn_page_classes = "join-item btn";



        function SetUrlPage(page) {
            const url = new URL(window.location.href);
            const searchParams = new URLSearchParams(url.search);

            if (searchParams.has("page")) {
                searchParams.set("page", page);
            } else {
                searchParams.append("page", page);
            }

            return `?${searchParams.toString()}`;
        }

        function InsertLeftPages(current) {
            let left_pages = [];
            const moreThanFour = current > 4;
            if (moreThanFour) {
                for (let i = current - 1; i > current - 3; i--) {
                    const page_btn = document.createElement("a");

                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;

                    left_pages.push(page_btn);
                }
                const page_btw = document.createElement("a");
                page_btw.setAttribute("class", "join-item btn btn-disabled ");
                page_btw.textContent = "...";
                left_pages.push(page_btw);

                const start_page_btn = document.createElement("a");
                start_page_btn.setAttribute("class", btn_page_classes);
                start_page_btn.setAttribute("href", SetUrlPage(catalog_start_page));
                start_page_btn.textContent = catalog_start_page;
                left_pages.push(start_page_btn);
            } else {
                for (let i = current - 1; i > 0; i--) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;
                    left_pages.push(page_btn);
                }
            }
            return left_pages.reverse();
        }

        function InsertRightPages(current) {
            let right_pages = [];
            const moreThanFour = catalog_end_page + 1 - current > 4;
            if (moreThanFour) {
                for (let i = current + 1; i < current + 3; i++) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;
                    right_pages.push(page_btn);
                }
                const page_btw = document.createElement("a");
                page_btw.setAttribute("class", "join-item btn btn-disabled");
                page_btw.textContent = "...";
                right_pages.push(page_btw);

                const end_page_btn = document.createElement("a");

                end_page_btn.setAttribute("class", btn_page_classes);
                end_page_btn.setAttribute("href", SetUrlPage(catalog_end_page));
                end_page_btn.textContent = catalog_end_page;
                right_pages.push(end_page_btn);
            } else {
                for (let i = current + 1; i < catalog_end_page + 1; i++) {
                    const page_btn = document.createElement("a");
                    page_btn.setAttribute("class", btn_page_classes);
                    page_btn.setAttribute("href", SetUrlPage(i));
                    page_btn.textContent = i;

                    right_pages.push(page_btn);
                }
            }
            return right_pages;
        }

        function RenderPagination(current) {

            const left = InsertLeftPages(current);
            const right = InsertRightPages(current);

            const current_page = document.createElement("a");
            current_page.setAttribute("class", btn_page_classes + " btn-active");
            current_page.setAttribute("href", SetUrlPage(current));
            current_page.textContent = current;

            page_buttons = [...left, current_page, ...right];
            pagination.replaceChildren(...page_buttons);
        }

        RenderPagination(catalog_current_page);
    </script>
</body>

</html>