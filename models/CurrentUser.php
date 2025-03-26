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
        $this->userController = new UserController($pdo);
        $this->registerController = new RegisterController($pdo);
        $this->user = $this->userController->getUser($user_id);
        $this->date_registration = $this->registerController->getRegistration($user_id)['date'];
    }

    public function getUsername()
    {
        return $this->user->username;
    }

    public function getRole()
    {
        return $this->user->role;
    }

    public function getAvatar()
    {
        return $this->user->avatar;
    }

    public function getId()
    {
        return $this->user->user_id;
    }

    public function getEmail()
    {
        return $this->user->email;
    }

    public function getPhone()
    {
        return $this->user->phone;
    }

    public function getDateRegistration()
    {
        return $this->date_registration;
    }
}
