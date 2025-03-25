<?php
require_once 'autoload.php';
require 'config/config.php';

session_start();

?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="../public/logo.svg" type="image/svg+xml">
    <title>Регистрация | PHP Library</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../public/assets/themes.css">
    <link rel="stylesheet" href="../public/assets/logo.css">
    <link rel="stylesheet" href="../public/assets/root.css">
    <script type="module">
        import {
            setToggler,
            loadTheme
        } from "../public/assets/theme.js";
        loadTheme();
        setToggler();
    </script>
</head>

<body>

    <?php
    include "components/header.php";
    ?>


    <main class="h-screen w-full flex items-center justify-center">

        <div class="form-reg flex w-[600px] flex-col rounded-md py-20 border-neutral border-2 text-neutral m-auto">
            <h1 class="text-3xl font-semibold  mx-auto">Регистрация</h1>
            <a class="w-fit mx-auto text-sm text-secondary hover:underline mt-2 " href="/login">Уже есть аккаунт?</a>
            <form action="/register_process" method="post" class="mx-32 my-10 flex flex-col gap-4">

                <section class="relative">
                    <legend class="fieldset-legend text-xl text-neutral font-semibold">Логин</legend>
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
                    <legend class="fieldset-legend text-xl text-neutral font-semibold">Почта</legend>
                    <label class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </g>
                        </svg>
                        <input type="email" name="email" placeholder="mail@site.com" required class="text-base-content" />
                    </label>
                    <p class="validator-hint absolute z-10 bg-base-100 p-2 text-error rounded-md shadow-md">
                        <span class="text-sm">Введите корректный адрес почты</span>
                    </p>
                </section>


                <section class="relative">
                    <legend class="fieldset-legend text-xl text-neutral font-semibold">Пароль</legend>
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

                <!-- Добавить нон автокомплит -->
                <section class="relative">
                    <label class="input validator">
                        <svg class="h-[1em] opacity-50" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                            </g>
                        </svg>
                        <input type="password" name="confirmPassword" required placeholder="Повторите пароль" minlength="8" class="text-base-content" />
                    </label>
                    <p class="validator-hint absolute z-10 bg-base-100 p-2 text-error rounded-md shadow-md">
                        Пароли не совпадают
                    </p>
                </section>

                <button disabled class="btn btn-accent mt-6 w-fit mx-auto">Зарегистрироваться</button>
            </form>
        </div>

    </main>


    <?php
    include "components/footer.php";
    ?>


    <script>
        window.scrollTo({
            top: document.querySelector('.form-reg').getBoundingClientRect().top + window.pageYOffset - (window.innerHeight / 2) + (document.querySelector('.form-reg').offsetHeight / 2),
            behavior: 'smooth'
        });

        const login = document.querySelector('input[name="username"]');
        const email = document.querySelector('input[name="email"]');
        const password = document.querySelector('input[name="password"]');
        const confirmPassword = document.querySelector('input[name="confirmPassword"]');

        const register_form = {
            "username": null,
            "email": null,
            "password": null,
            "confirmPassword": null
        };

        const checkForm = (e) => {
            register_form[e.target.name] = e.target.validity.valid;
            const loginValid = register_form['username'];
            const emailValid = register_form['email'];
            const passwordValid = register_form['password'];
            const confirmPasswordValid = register_form['confirmPassword'];
            console.log(register_form)
            if (loginValid && emailValid && passwordValid && confirmPasswordValid) {
                document.querySelector('button').removeAttribute('disabled');
            } else {
                document.querySelector('button').setAttribute('disabled', true);
            }
        }

        login.oninput = checkForm;
        email.oninput = checkForm;
        password.oninput = (e) => {
            confirmPassword.setAttribute('pattern', password.value);
            console.log(password.validity.valid);
            checkForm(e);
        }
        confirmPassword.oninput = checkForm;
    </script>

</body>

</html>