<article class="book relative w-full rounded-md p-1 flex hover:shadow-md transition-all shadow-none duration-300" data-in-cart="false" data-id="<?= $book->id ?>" data-price="<?= $book->price ?>" data-stock="<?= $book->stock ?>">
    <?php if ($book->stock == 0): ?>
        <span class="absolute bottom-1 left-1 w-fit h-fit z-80 bg-error book-warning text-base-100 px-2 py-1 rounded-sm">
            Нет в наличии
        </span>
    <?php endif; ?>
    <div class="book-content flex w-full ">
        <a href="">
            <picture class="h-[100px] aspect-square rounded-md overflow-hidden flex bg-base-200 justify-center items-center">
                <img
                    src="../root/books/<?= $book->cover_image ?>"
                    alt="<?= $book->title ?>"
                    class="h-full w-full object-fit object-contain"
                    onerror="this.onerror=null; this.parentElement.innerHTML='<div class=\'text-error opacity-50 text-md bg-black w-full h-full flex justify-center text-center items-center\'>Нет изображения</div>';" />
            </picture>
        </a>
        <span class="flex flex-col mx-2 flex-1">
            <a href="/book?id=<?= $book->id ?>&title=<?= $book->title ?>" class="w-fit"><strong class="book-title"><?= $book->title ?></strong></a>
            <a href="/author?id=<?= $book->author_id ?>&name=<?= $book->author_name ?>" class="w-fit"><strong class="font-normal book-author"><?= $book->author_name ?></strong></a>
        </span>
        <div class="flex flex-col items-end min-h-full">
            <span class="book-price">
                <?= $book->price ?>
                <span class="">₽</span>
            </span>
        </div>
    </div>
    <button disabled class="add-to-cart absolute right-1 bottom-1 py-2 opacity-100 btn btn-primary button text-nowrap"></button>
</article>