<?php

namespace models;

class User
{
    public $user_id;
    public $username;
    public $email;
    public $phone;
    public $role;
    public $avatar;

    public function __construct($data)
    {
        $this->user_id = $data['user_id'];
        $this->username = $this->escape($data['username']);
        $this->email = $this->escape($data['email']);
        $this->phone = $this->escape($data['phone']);
        $this->role = $this->escape($data['role']);
        $this->avatar = $this->escape($data['avatar']);
    }

    private function escape($value)
    {
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }
}
