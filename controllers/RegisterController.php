<?php

namespace controllers;

use repositories\RegisterRepository;
use repositories\UserRepository;

use Exception;

class RegisterController
{

    private $registerRepository;
    private $userRepository;

    public function __construct($pdo)
    {
        $this->registerRepository = new RegisterRepository($pdo);
        $this->userRepository = new UserRepository($pdo);
    }

    public function makeRegister()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = 'user';

            $check_user = $this->userRepository->findUser(null, $username, $email);
            if ($check_user->username === $username) {
                throw new Exception('USER_EXISTS');
            }

            if ($password == null or $username == null or $email == null) {
                throw new Exception('EMPTY_FIELDS');
            }

            if (mb_strlen($password) < 8) {
                throw new Exception('SHORT_PASSWORD');
            }

            if ($role != null and $role != 'user' and $role != 'admin') {
                throw new Exception('WRONG_ROLE');
            }

            return $this->registerRepository->create($username, $password, $email, $role);
        }
    }

    public function getRegistration($user_id)
    {
        return $this->registerRepository->check($user_id);
    }
}
