<div class="flex-col w-full gap-2 flex py-2">
    <h2 class="text-2xl font-semibold text-center text-primary">Фильтры</h2>
    <form action="/catalog" method="get" class="category-form w-full flex flex-col">
        <div class="menu gap-1 min-w-full">
            <li>
                <details open class="open:[&>summary]:opacity-50">
                    <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                        <p class="w-full text-start">По названию</p>
                    </summary>
                    <input type="search" name="title" placeholder="Введите название" class="input input-accent min-w-full my-1">
                </details>
            </li>
            <li>
                <details open class="open:[&>summary]:opacity-50">
                    <summary class="btn min-w-full hover:bg-base-100 shadow-none hover:shadow-sm">
                        <p class="w-full text-start">Автор</p>
                    </summary>
                    <input type="search" value="" name="author" placeholder="Введите имя автора" class="input input-accent min-w-full my-1">
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
                            <input type="checkbox" id="category-<?= $cat_index ?>" name="category[]" value="<?= $category ?>" class="checkbox checkbox-sm checkbox-accent">
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
                            <input type="checkbox" id="year-<?= $year_index ?>" name="year[]" value="<?= $year ?>" class="checkbox checkbox-sm checkbox-accent">
                            <p class="w-full text-start"><?= $year ?></p>
                        </label>
                        <?php $year_index++; ?>
                    <?php endforeach; ?>
                </details>
            </li>
        </div>
        <button class="btn btn-primary mx-2" type="submit">Применить</button>
    </form>

</div>