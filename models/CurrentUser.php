<?php

namespace Models;

use controllers\UserController;
use controllers\RegisterController;

class CurrentUser
{
    private $userController;
    private $registerController;
    private $user;
    private $date_registration;

    public function __construct($pdo, $user_id)
    {
        if ($user_id) {
            $this->userController = new UserController($pdo);
            $this->registerController = new RegisterController($pdo);
            $this->user = $this->userController->getUser($user_id);
            $this->date_registration = $this->registerController->getRegistration($user_id)['date'] ?? null;
        }
    }

    public function getUsername()
    {
        return $this->user ? $this->user->username : null;
    }

    public function getRole()
    {
        return $this->user ? $this->user->role : null;
    }

    public function getAvatar()
    {
        return $this->user ? $this->user->avatar : null;
    }

    public function getId()
    {
        return $this->user ? $this->user->user_id : null;
    }

    public function getEmail()
    {
        return $this->user ? $this->user->email : null;
    }

    public function getPhone()
    {
        return $this->user ? $this->user->phone : null;
    }

    public function getDateRegistration()
    {
        return $this->user ? $this->date_registration : null;
    }
}
