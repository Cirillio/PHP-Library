<article data-in-cart="false" data-id="<?= $book->id ?>" data-price="<?= $book->price ?>" data-stock="<?= $book->stock ?>" class="book flex flex-col bg-base-200 duration-300 hover:border-base-content border transition-all duration-75 border-base-100 rounded-lg overflow-hidden gap-2">
    <a href="" class="relative ">
        <picture class="h-[300px] flex bg-base-300 justify-center items-center ">
            <img
                src="../root/books/<?= $book->cover_image ?>"
                alt="<?= $book->title ?>"
                class="h-full w-full m-auto object-fit object-contain"
                onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-xl bg-black w-full h-full flex justify-center text-center items-center\'>Нет изображения</div>';" />
        </picture>
        <?php if ($book->stock < 10 && $book->stock > 0): ?>
            <span class="absolute top-1 right-1 z-80 sm:top-2 sm:right-2 bg-warning book-warning text-base-100 px-2 py-1 rounded-sm">
                Осталось мало книг
            </span>
        <?php elseif ($book->stock == 0): ?>
            <span class="absolute top-1 right-1 z-80 sm:top-2 sm:right-2 bg-error book-warning text-base-100 px-2 py-1 rounded-sm">
                Нет в наличии
            </span>
        <?php endif; ?>
    </a>
    <div class=" flex-1 grid grid-rows-4 px-1 py-1 gap-2">
        <span class="row-span-2 flex flex-col">
            <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="w-fit"><strong class="book-title"><?= $book->title ?></strong></a>
            <a href="/author?id=<?= $book->author_id ?>&name=<?= $book->author_name ?>" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
        </span>
        <strong class="row-start-3 flex items-center book-price"><?= $book->price ?>₱</strong>
        <div class="w-full row-start-4 flex items-center gap-1">

            <button <?= $book->stock == 0 ? "disabled" : "" ?> class="add-to-cart btn flex-1 btn-primary button text-nowrap">В корзину</button>

            <button class="btn btn-accent btn-square">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-[1.2em]">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                </svg>
            </button>

        </div>
    </div>
</article>