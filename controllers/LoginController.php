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
                // $role = $_POST['role'] || 'user';

                $user = $this->loginRepository->login($username, $password);

                $_SESSION['user_id'] = htmlspecialchars($user->user_id);
                $_SESSION['username'] = htmlspecialchars($user->username);
                $_SESSION['email'] = htmlspecialchars($user->email);
                // $_SESSION['role'] = htmlspecialchars($role);
                $_SESSION['avatar'] = htmlspecialchars($user->avatar) ? htmlspecialchars($user->avatar) : null;
                $_SESSION['phone'] = htmlspecialchars($user->phone) ? htmlspecialchars($user->phone) : null;
                // session_regenerate_id(true); // Обновляем ID сессии
                header("Location: /");
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
        session_start();
        $_SESSION = array();
        session_destroy();
        header("Location: /login");
        exit;
    }
}
