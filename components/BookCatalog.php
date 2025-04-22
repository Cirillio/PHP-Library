<article class="book bg-base-200 hover:bg-base-300 active:-translate-y-1 active:bg-base-300 flex flex-col duration-150 transition-all duration-75 rounded-3xl overflow-hidden hover:-translate-y-1 hover:shadow-md" data-in-cart="false" data-id="<?= $book->id ?>" data-price="<?= $book->price ?>" data-stock="<?= $book->stock ?>">
    <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="relative">
        <picture class="flex bg-base-300 h-full w-full rounded-2xl overflow-hidden aspect-3/4 justify-center items-center ">
            <img
                src="../root/books/<?= $book->cover_image ?>"
                alt="<?= $book->title ?>"
                class="h-full w-full m-auto object-fit object-contain"
                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-xl bg-black w-full h-full flex-1 flex justify-center text-center items-center\'>Нет изображения</div>';" />
        </picture>
        <?php if ($book->stock < 10 && $book->stock > 0): ?>
            <span class="absolute top-1 right-1 z-20 sm:top-2 sm:right-2 bg-warning book-warning text-base-100 px-2 py-1 rounded-sm">
                Осталось мало книг
            </span>
        <?php elseif ($book->stock == 0): ?>
            <span class="absolute top-1 right-1 z-20 sm:top-2 sm:right-2 active:opacity-10 hover:opacity-10 btn btn-sm btn-error">
                Нет в наличии
            </span>
        <?php endif; ?>
        <?php
        if (!isset($_GET['category'])):
        ?>
            <span class="absolute bottom-1 left-1 w-fit h-fit z-20 btn-neutral active:opacity-10 hover:opacity-10 btn btn-sm"><?= $book->genre ?></span>
        <?php endif; ?>
    </a>
    <div class="flex flex-col p-2">
        <div class="flex flex-col h-[64px] sm:h-[96px]">
            <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="w-fit"><strong class="book-title text-ellipsis line-clamp-2 overflow-hidden"><?= $book->title ?></strong></a>
            <a href="/author?id=<?= $book->author_id ?>&name=<?= $book->author_name ?>" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
        </div>

        <div class="flex flex-col  justify-end ">
            <strong class="sm:text-start text-end w-full book-price"><?= $book->price ?>₱</strong>
            <div class="w-full flex-row-reverse sm:flex-row flex items-center gap-1">
                <button disabled class="add-to-cart hover:opacity-90 rounded-2xl btn sm:btn-md sm:flex-1 btn-sm  btn-primary button text-nowrap">В корзину</button>
                <button class="btn sm:btn-md sm:mr-0 mr-auto btn-sm btn-accent btn-outline btn-square">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-[1.2em]">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                    </svg>
                </button>

            </div>
        </div>
    </div>
</article>