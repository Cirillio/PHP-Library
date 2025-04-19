<article class="book bg-base-200 hover:bg-base-300 w-full rounded-3xl flex hover:shadow-md transition-all shadow-none duration-300" data-in-cart="false" data-id="<?= $book->id ?>" data-price="<?= $book->price ?>" data-stock="<?= $book->stock ?>">
    <?php if ($book->stock == 0): ?>
        <span class="absolute bottom-1 left-1 w-fit h-fit z-80 bg-error book-warning text-base-100 px-2 py-1 rounded-sm">
            Нет в наличии
        </span>
    <?php endif; ?>
    <div class=" relative lg:flex-row flex-col p-2 gap-2 flex w-full ">
        <div class="flex w-full book-content">
            <a href="">
                <picture class="h-[100px] aspect-square rounded-2xl overflow-hidden flex bg-base-200 justify-center items-center">
                    <img
                        src="../root/books/<?= $book->cover_image ?>"
                        alt="<?= $book->title ?>"
                        class="h-full w-full object-fit object-contain"
                        onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-md bg-black w-full h-full flex justify-center text-center items-center\'>Нет изображения</div>';" />
                </picture>
            </a>
            <div class="flex w-full flex-col lg:flex-row p-2 min-h-full">
                <span class="flex flex-col flex-1">
                    <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="w-fit"><strong class="book-title"><?= $book->title ?></strong></a>
                    <a href="/author?id=<?= $book->author_id ?>&name=<?= $book->author_name ?>" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
                </span>
                <span class="book-price">
                    <?= $book->price ?>
                    <span class="">₽</span>
                </span>
            </div>
        </div>
        <div class="flex  lg:w-fit w-full items-center justify-between lg:absolute gap-1 right-2 bottom-2">
            <div class="flex items-center gap-1">
                <button disabled class="book-cart-dec btn btn-sm btn-accent aspect-square max-w-fit"><span class="text-xl font-light text-primary-content">-</span></button>
                <input type="text" name="item_quantity" readonly id="" class="book-cart-quantity w-fit max-w-8 border-none shadow-md text-accent bg-base-100 rounded-md focus:outline-none cursor-default text-center aspect-square" value="1">
                <button class="book-cart-inc btn btn-sm btn-accent aspect-square max-w-fit"><span class="text-xl font-light text-primary-content">+</span></button>
            </div>
            <button disabled class="add-to-cart sm:btn-md btn-sm opacity-100 btn btn-outline  btn-primary button text-nowrap"></button>
        </div>
    </div>
</article>