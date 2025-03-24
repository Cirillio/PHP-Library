<?php

namespace repositories;

use models\User;

class UserRepository
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findUser($id = null, $username = null, $email = null)
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id OR username = :username OR email = :email");
        $stmt->execute(['id' => $id, 'username' => $username, 'email' => $email]);
        $user = $stmt->fetchObject(User::class);
        return $user instanceof User ? $user : false;
    }
}
