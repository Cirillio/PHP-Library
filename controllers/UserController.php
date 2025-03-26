<?php

namespace controllers;

use repositories\UserRepository;

class UserController
{
    private $userRepository;

    public function __construct($pdo)
    {
        $this->userRepository = new UserRepository($pdo);
    }

    public function getUser($id)
    {
        return $id ? $this->userRepository->findUser($id) : null;
    }
}
