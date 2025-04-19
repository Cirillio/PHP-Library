<?php

setPageTitle("Каталог");

$params = [
    'title' => $_GET['title'] ?? null,
    'author' => $_GET['author'] ?? null,
    'category' => $_GET['category'] ?? null,
    'year' => $_GET['year'] ?? null,
    'page' => $_GET['page'] ?? 1
];

$books_data = $bookController->getCatalog($params);
$books = $books_data['books'];
$total_pages = $books_data['totalPages'];
$current_page = $books_data['currentPage'];

$categories = $bookController->getGenres();

$books_years = $bookController->getYearsPublish();
rsort($books_years);
?>

<!DOCTYPE html>
<html lang="ru" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?php echo $TITLE; ?>
    </title>
    <?php include "components/styles.php"; ?>
</head>

<body class="flex flex-col max-h-screen min-h-screen">

    <?php include "components/header.php";
    ?>

    <div class="2xl:px-60 xl:px-20 md:px-10 pb-10 sm:px-4 px-1">
        <main data-total-pages="<?= $total_pages ?>" data-current-page="<?= $current_page ?>" class="catalog flex flex-col gap-4 rounded-3xl">
            <div class="gap-2 flex w-full justify-between px-1 py-4 items-center">
                <h1 class="text-5xl font-semibold text-center text-accent">
                    Каталог
                </h1>
                <div class="lg:hidden min-[100px]:flex">
                    <div class="drawer">
                        <input id="my-drawer" type="checkbox" class="drawer-toggle" />
                        <label for="my-drawer" class="btn btn-primary drawer-button">Фильтры</label>
                        <div class="drawer-side z-100">
                            <label for="my-drawer" aria-label="close sidebar" class="drawer-overlay"></label>
                            <div class="drawer-container bg-base-300 p-2 text-base-content min-h-full w-60 md:w-80">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex gap-1">
                <div class="left-side-container shadow-sm  h-fit lg:flex min-[100px]:hidden flex-1/4 bg-base-300 rounded-3xl">
                    <div class="filters flex-col w-full flex">
                        <h2 class="text-2xl font-semibold mt-2 text-center text-primary">Фильтры</h2>
                        <form action="/catalog" method="get" class="category-form w-full flex flex-col">
                            <div class="menu gap-1 min-w-full">
                                <li>
                                    <details open class="open:[&>summary]:opacity-50">
                                        <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                                            <p class="w-full text-start">По названию</p>
                                        </summary>
                                        <input autocomplete="off" value="<?= $_GET['title'] ?? null ?>" type="search" name="title" placeholder="Введите название" class="input input-accent min-w-full my-1">
                                    </details>
                                </li>
                                <li>
                                    <details open class="open:[&>summary]:opacity-50">
                                        <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                                            <p class="w-full text-start">Автор</p>
                                        </summary>
                                        <input autocomplete="off" type="search" value="<?= $_GET['author'] ?? null ?>" name="author" placeholder="Введите имя автора" class="input input-accent min-w-full my-1">
                                    </details>
                                </li>
                                <li class="w-full">
                                    <details class="open:[&>summary]:opacity-50">
                                        <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                                            <p class="w-full text-start">Категории</p>
                                        </summary>
                                        <?php $cat_index = 0; ?>
                                        <?php foreach ($categories as $category): ?>
                                            <label for="category-<?= $cat_index ?>" class="checkbox-btn btn btn-ghost min-w-full hover:bg-base-100 shadow-none hover:shadow-sm peer-checked:btn-primary">
                                                <input <?php if (isset($_GET['category']) && in_array($category, $_GET['category'])) echo 'checked'; ?> type="checkbox" id="category-<?= $cat_index ?>" name="category[]" value="<?= $category ?>" class="checkbox checkbox-sm checkbox-accent">
                                                <p class="w-full text-start"><?= $category ?></p>
                                            </label>
                                            <?php $cat_index++; ?>
                                        <?php endforeach; ?>
                                    </details>
                                </li>
                                <li class="w-full">
                                    <details class="open:[&>summary]:opacity-50">
                                        <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                                            <p class="w-full text-start">Год издания</p>
                                        </summary>
                                        <?php $year_index = 0; ?>
                                        <?php foreach ($books_years as $year): ?>
                                            <label for="year-<?= $year_index ?>" class="checkbox-btn btn btn-ghost min-w-full hover:bg-base-100 shadow-none hover:shadow-sm peer-checked:btn-primary">
                                                <input <?php if (isset($_GET['year']) && in_array($year, $_GET['year'])) echo 'checked'; ?> type="checkbox" id="year-<?= $year_index ?>" name="year[]" value="<?= $year ?>" class="checkbox checkbox-sm checkbox-accent">
                                                <p class="w-full text-start"><?= $year ?></p>
                                            </label>
                                            <?php $year_index++; ?>
                                        <?php endforeach; ?>
                                    </details>
                                </li>
                            </div>
                            <button class="btn btn-primary mx-2" type="submit">Применить</button>
                            <a href="/catalog" class="btn btn-outline btn-secondary m-2">Сбросить</a>
                        </form>
                    </div>
                </div>
                <?php if (!$books): ?>
                    <?php include "components/EmptyCatalog.php"; ?>

                <?php else: ?>
                    <div class="flex flex-col bg-base-100 rounded-3xl overflow-hidden items-center flex-3/4">
                        <div class="w-full grid p-1 h-fit lg:grid-cols-4 md:grid-cols-4 min-[528px]:grid-cols-3 grid-cols-2 gap-1 sm:gap-x-2 sm:gap-y-4">
                            <?php if ($books) {
                                foreach ($books as $book) {
                                    include "components/BookCatalog.php";
                                }
                            }
                            ?>
                        </div>
                        <div class="pagination my-6 join  overflow-hidden w-fit drop-shadow-sm">
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </main>
    </div>


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
            Cart
        }
        from "../public/assets/cart/Cart.js"

        import {
            CartController
        } from "../public/assets/cart/CartController.js"

        import {
            FilterFormManager
        }
        from "/public/assets/filters/FilterFormManager.js";

        document.addEventListener("DOMContentLoaded", async () => {
            const filter_manager = new FilterFormManager(".filters", ".left-side-container", ".drawer-container");


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
                current_page.setAttribute("class", btn_page_classes + " btn-active btn-info");
                current_page.setAttribute("href", SetUrlPage(current));
                current_page.textContent = current;

                page_buttons = [...left, current_page, ...right];
                pagination.replaceChildren(...page_buttons);
            }

            RenderPagination(catalog_current_page);


            const category_form = document.querySelector(".category-form");

            const checkboxes = category_form.querySelectorAll(".checkbox-btn");

            checkboxes.forEach(checkbox => {
                checkbox.addEventListener("click", () => {
                    const input = checkbox.querySelector("input");
                    input.checked = !input.checked;
                })
            });

            category_form.onsubmit = () => {
                const inputs = category_form.querySelectorAll('input[type="search"]');

                inputs.forEach(input => {
                    if (input.value.trim() === "") {
                        input.disabled = true;
                    }
                });
            }

            const catalog_url = new URL(window.location.href);
            let catalog_search_params = catalog_url.searchParams;

            if (!catalog_search_params.has("page")) {
                catalog_search_params.append("page", 1);
                window.history.pushState({}, "", catalog_url);
            }

            SetHeaderLinks();
            SetCategories();
            const cart = new Cart("catalog");
            const cart_controller = new CartController(cart);
        })
    </script>

</body>

</html>