<?php

namespace controllers;

use repositories\LoginRepository;

use Exception;

class LoginController
{

    private $loginRepository;

    public function __construct($pdo)
    {
        $this->loginRepository = new LoginRepository($pdo);
    }

    public function logIn()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                $username = $_POST['username'];
                $password = $_POST['password'];

                $user = $this->loginRepository->login($username, $password);

                $_SESSION['user_id'] = htmlspecialchars($user->user_id);

                session_regenerate_id(true); // Обновляем ID сессии

                unset($_POST['password']);

                header("Location: /catalog");
                exit;
            } catch (Exception $e) {
                $_SESSION['error'] = $e->getMessage();
                header("Location: /login");
                exit;
            }
        }
    }


    public function logOut()
    {
        session_unset();
        session_destroy();
        header("Location: /catalog");
        exit;
    }
}
