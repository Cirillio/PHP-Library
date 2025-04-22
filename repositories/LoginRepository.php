<?php

namespace repositories;

use PDO;
use models\User;
use repositories\UserRepository;
use Exception;

class LoginRepository
{
    private $userRepository;
    private $registerRepository;

    public function __construct($pdo)
    {
        $this->userRepository = new UserRepository($pdo);
        $this->registerRepository = new RegisterRepository($pdo);
    }

    public function login(string $username, string $password): User|bool
    {

        $userFind = $this->userRepository->findUser(null, $username);

        $user = $userFind ? $userFind : throw new Exception('Пользователь не найден');

        $registration = $this->registerRepository->check($user->user_id);

        $pass_valid = password_verify(trim($password), $registration['password']);

        return $pass_valid ? $user : throw new Exception('Неверный пароль');
    }
}
