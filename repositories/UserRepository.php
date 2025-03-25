<?php

namespace repositories;

use models\User;
use PDO;

class UserRepository
{

    private $pdo;
    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    public function findUser($id = null, $username = null, $email = null): User|bool
    {
        $stmt = $this->pdo->prepare("SELECT * FROM users WHERE user_id = :id OR username = :username OR email = :email");
        $stmt->execute(['id' => $id, 'username' => $username, 'email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $user = new User($user);
        }
        return $user;
    }
}
