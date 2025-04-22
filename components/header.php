<header>
    <div class="flex items-center justify-end gap-2 2xl:px-60 xl:px-20 md:px-10 px-2 py-4 shadow-sm">
        <form class="flex w-full gap-2 md:px-0 px-2 sm:mr-auto" action="/catalog" method="get">
            <label class="input sm:min-w-fit min-w-full">
                <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                        <circle cx="11" cy="11" r="8"></circle>
                        <path d="m21 21-4.3-4.3"></path>
                    </g>
                </svg>
                <input name="title" type="search" class="w-full" required placeholder="Поиск книг..." />
            </label>
            <div class="min-[100px]:hidden sm:flex"><button class="btn btn-info" type="submit">Найти</button></div>
        </form>

        <?php if ($AUTH): ?>
            <div class=" ">
                <div class="indicator">
                    <a href="/cart" tabindex="0" role="button" class="btn button btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        <span class="text-nowrap min-[100px]:hidden sm:flex">
                            Корзина
                        </span>
                    </a>
                    <span hidden class="indicator-item indicator-middle indicator-start
                     badge badge-sm badge-info cart-books"></span>
                </div>
            </div>

            <?php if ($USER->getAvatar()): ?>
                <div class="min-[100px]:hidden sm:flex">
                    <div class="avatar">
                        <div class="w-10 rounded-3xl">
                            <img
                                alt="<?= $USER->getUsername() ?>_avatar"
                                src="../root/avatars/<?= $USER->getAvatar() ?>" />
                        </div>
                    </div>
                </div>
                <a class="sm:hidden flex" href="/profile">
                    <div class="avatar">
                        <div class="w-10 rounded-3xl">
                            <img
                                alt="<?= $USER->getUsername() ?>_avatar"
                                src="../root/avatars/<?= $USER->getAvatar() ?>" />
                        </div>
                    </div>
                </a>
            <?php else: ?>
                <div class="min-[100px]:hidden sm:flex">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-neutral text-neutral-content w-6 rounded-3xl">
                            <span class="text-xs"><?= substr($USER->getUsername(), 0, 1) ?></span>
                        </div>
                    </div>
                </div>
                <a href="/profile" class="sm:hidden flex">
                    <div class="avatar avatar-placeholder">
                        <div class="bg-neutral text-neutral-content w-6 rounded-3xl">
                            <span class="text-xs"><?= substr($USER->getUsername(), 0, 1) ?></span>
                        </div>
                    </div>
                </a>
            <?php endif; ?>

            <div class="min-[100px]:hidden sm:flex">
                <div class="dropdown dropdown-end">
                    <div tabindex="0" role="button" class="btn btn-ghost">
                        <span class="text-nowrap font-semibold">
                            <?php echo $USER->getUsername(); ?>
                        </span>
                    </div>
                    <ul
                        tabindex="0"
                        class="menu menu-md dropdown-content bg-base-100 rounded-md z-1 mt-3 w-52 p-2 shadow-md border border-base-content">
                        <li><a href="/profile">Профиль</a></li>
                        <li><a href="/logout">Выход</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!$AUTH): ?>

            <div class="flex gap-2 sm:gap-4">
                <a href="/login" class="btn sm:btn-md btn-sm card place-items-center grow grid btn-ghost btn-primary">Вход</a>
                <a href="/register" class="btn sm:btn-md btn-sm card place-items-center grow grid btn-ghost btn-primary">Регистрация</a>
            </div>

        <?php endif; ?>

    </div>
    <div class="flex flex-wrap 2xl:px-60 xl:px-20 md:px-10 sm:px-4 px-2 sm:gap-10 gap-6 justify-center xl:py-14 md:py-10 py-6 items-baseline">
        <?php include "Logo.php"; ?>
        <ul class="flex ml-auto sm:w-fit w-full sm:gap-40 mx-auto text-lg">
            <li class="flex-1 text-center"><a href="/"><button data-link="" class="header-link border shadow-sm btn btn-ghost btn-md lg:btn-lg"><span class="font-normal">Главная</span></button></a></li>
            <li class="flex-1 text-center"><a href="/catalog"><button data-link="catalog" class="header-link border shadow-sm btn btn-ghost btn-md lg:btn-lg"><span class="font-normal">Каталог</span></button></a></li>
            <li class="flex-1 text-center"><a href="/authors"><button data-link="authors" class="header-link border shadow-sm btn btn-ghost btn-md lg:btn-lg"><span class="font-normal">Авторы</span></button></a></li>
        </ul>
    </div>
</header>