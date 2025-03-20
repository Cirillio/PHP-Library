<header>
    <div class="flex justify-end gap-4 px-20 py-2 shadow-sm">
        <label class="input mx-auto ">
            <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                    <circle cx="11" cy="11" r="8"></circle>
                    <path d="m21 21-4.3-4.3"></path>
                </g>
            </svg>
            <input type="search" class="w-full" required placeholder="Search" />
        </label>
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
        <div class="dropdown dropdown-end">
            <div tabindex="0" role="button" class="btn btn-ghost avatar">
                <div class="w-6 rounded-full">
                    <img
                        alt="Tailwind CSS Navbar component"
                        src="https://img.daisyui.com/images/stock/photo-1534528741775-53994a69daeb.webp" />
                </div>
                <span class="text-nowrap font-semibold">| Lidia</span>
            </div>
            <ul
                tabindex="0"
                class="menu menu-lg dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
                <li>
                    <a href="../pages/user.php" class="justify-between">
                        Профиль
                    </a>
                </li>
                <li><a>Настройки</a></li>
                <li><a>Выход</a></li>
            </ul>
        </div>
    </div>
    <div class="flex  px-20 py-6 items-baseline">
        <?php include "Logo.php"; ?>
        <ul class="flex mx-auto gap-40 text-lg">
            <li><a href="">Главная</a></li>
            <li><a href="">Новое</a></li>
            <li><a href="">Авторы</a></li>
        </ul>
    </div>
</header>