<?php

if ($AUTH) {
    header("Location: /catalog");
}
setPageTitle("Логин");
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?php echo $TITLE; ?></title>
    <?php include "components/styles.php"; ?>

</head>

<body>

    <?php
    include "components/header.php";
    ?>


    <main class="h-screen w-full flex items-center justify-center">

        <div class="form-login flex w-fit sm:w-[600px] flex-col rounded-2xl py-20 border-neutral border-2 text-base-content m-auto">
            <h1 class="text-3xl font-semibold  mx-auto">Авторизация</h1>
            <a class="w-fit mx-auto text-sm text-secondary hover:underline mt-2 " href="/register">Еще нет аккаунта?</a>

            <?php

            if (isset($_SESSION['error'])) {
                echo
                "
                    <div class='login-error text-error flex items-center justify-center gap-6 text-xl font-semibold my-2 border-y-2 border-error'>"
                    . $_SESSION['error'] .
                    "
                        <button class='btn btn-sm btn-ghost my-2'>OK</button>
                    </div>
                ";

                unset($_SESSION['error']);
            }
            ?>


            <form action="/login_process" method="post" class="sm:mx-32 mx-10 my-10 flex flex-col gap-4">

                <section class="relative">
                    <legend class="fieldset-legend text-xl text-base-content font-semibold">Логин</legend>
                    <label class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
                                <circle cx="12" cy="7" r="4"></circle>
                            </g>
                        </svg>
                        <input type="text" class="text-base-content" required pattern="[A-Za-z][A-Za-z0-9\-]*" minlength="3" maxlength="20" name="username" placeholder="Логин" />
                    </label>
                    <p class="validator-hint absolute z-10 bg-base-100 p-2 text-error rounded-md shadow-md">
                        <span class="text-sm">От 3 до 20 символов, только буквы, цифры или _ и -</span>
                    </p>
                </section>




                <section class="relative">
                    <legend class="fieldset-legend text-xl text-base-content font-semibold">Пароль</legend>
                    <label id="pass" class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                            </g>
                        </svg>
                        <input type="password" name="password" required placeholder="Пароль" minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Должен быть длиннее 8 символов, включая как минимум одну цифру, одну строчную букву и одну заглавную букву" class="text-base-content" />
                    </label>
                    <p class="validator-hint absolute z-10 bg-base-100 p-2 text-error rounded-md shadow-md">
                        Должен быть длиннее 8 символов, включая
                        <br />Как минимум одну цифру
                        <br />Как минимум одну строчную букву
                        <br />Как минимум одну заглавную букву
                    </p>
                </section>


                <div class="flex sm:flex-row flex-col justify-between">
                    <button id="login" disabled class="btn btn-accent mt-6 w-fit mx-auto">Войти</button>
                    <button class="btn btn-error mt-6 w-fit mx-auto">Не помню пароль</button>
                </div>
            </form>
        </div>

    </main>


    <?php
    include "components/footer.php";
    ?>


    <script>
        window.scrollTo({
            top: document.querySelector('.form-login').getBoundingClientRect().top + window.pageYOffset - (window.innerHeight / 2) + (document.querySelector('.form-login').offsetHeight / 2),
            behavior: 'smooth'
        });

        const login = document.querySelector('input[name="username"]');
        const password = document.querySelector('input[name="password"]');

        const login_form = {
            "username": null,
            "password": null,
        };

        const checkForm = (e) => {
            login_form[e.target.name] = e.target.validity.valid;
            const loginValid = login_form['username'];
            const passwordValid = login_form['password'];
            if (loginValid && passwordValid) {
                console.log(loginValid, passwordValid)
                document.querySelector('#login').removeAttribute('disabled');
            } else {
                document.querySelector('#login').setAttribute('disabled', true);
            }
            console.log(login_form)
        }

        login.oninput = checkForm;
        password.oninput = checkForm;

        const loginError = document.querySelector('.login-error');
        const closeError = loginError.querySelector("button");
        closeError.onclick = () => loginError.remove();
    </script>

</body>

</html>