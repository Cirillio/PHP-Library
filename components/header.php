<header>
    <div class="flex justify-end sm:gap-4 sm:px-20 px-2 py-2 shadow-sm">
        <label class="input mx-auto ">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </g>
            </svg>
            <input type="search" class="w-full" required placeholder="Search" />
        </label>

        <?php if ($AUTH): ?>
            <div class="min-[100px]:hidden sm:flex">
                <a href="/cart" tabindex="0" role="button" class="btn btn-ghost">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-nowrap">
                        | Cart:
                    </span>
                    <span>
                        (999)₱
                    </span>
                </a>
            </div>

            <div class="dropdown dropdown-end">
                <div tabindex="0" role="button" class="btn btn-ghost avatar">
                    <?php if ($USER->getAvatar()): ?>
                        <div class="w-6 rounded-full">
                            <img
                                alt="Tailwind CSS Navbar component"
                                src="../root/avatars/<?= $USER->getAvatar() ?>" />
                        </div>
                    <?php endif; ?>

                    <?php if (!$USER->getAvatar()): ?>
                        <div class="avatar avatar-placeholder">
                            <div class="bg-neutral text-neutral-content w-6 rounded-full">
                                <span class="text-xs"><?= substr($USER->getUsername(), 0, 1) ?></span>
                            </div>
                        </div>
                    <?php endif; ?>

                    <span class="text-nowrap font-semibold">|
                        <?php echo $USER->getUsername(); ?>
                    </span>
                </div>
                <div class="min-[100px]:hidden sm:flex">
                    <ul
                        tabindex="0"
                        class="menu menu-md dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow-md border border-base-content">
                        <li><a href="../profile">Профиль</a></li>
                        <li><a href=" /logout">Выход</a></li>
                    </ul>
                </div>
                <div class="sm:hidden">
                    <ul
                        tabindex="0"
                        class="menu menu-lg dropdown-content bg-base-100  rounded-box z-1 mt-3 w-52 p-2 shadow-md border border-base-content">
                        <li><a href="../profile">Профиль</a></li>
                        <li><a href="/cart">Корзина</a></li>
                        <li><a href=" /logout">Выход</a></li>
                    </ul>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!$AUTH): ?>

            <div class="flex gap-4">
                <a href="/login" class="btn card place-items-center grow grid btn-ghost btn-primary">Вход</a>
                <a href="/register" class="btn card place-items-center grow grid btn-ghost btn-primary">Регистрация</a>

            </div>

        <?php endif; ?>

    </div>
    <div class="flex flex-wrap sm:px-10 gap-10 justify-center py-6 items-baseline">
        <?php include "Logo.php"; ?>
        <ul class="flex ml-auto sm:w-fit w-full sm:gap-40  mx-auto text-lg">
            <li class="flex-1 text-center"><a href="/"><button data-link="" class="header-link disabled:underline hover:text-primary disabled:cursor-default cursor-pointer transition-all">Главная</button></a></li>
            <li class="flex-1 text-center"><a href="/library"><button data-link="library" class="header-link disabled:underline hover:text-primary disabled:cursor-default cursor-pointer transition-all">Каталог</button></a></li>
            <li class="flex-1 text-center"><a href="/authors"><button data-link="authors" class="header-link disabled:underline hover:text-primary cursor-pointer disabled:cursor-default transition-all">Авторы</button></a></li>
        </ul>
    </div>
</header>