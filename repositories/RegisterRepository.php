<?php

namespace repositories;

class RegisterRepository
{

    private $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }



    public function create($username, $password, $email, $role = null)
    {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $currentDate = date('Y-m-d H:i:s');

        $stmt = $this->pdo->prepare("INSERT INTO registration (password, date) VALUES (:password, :date)");
        $stmt->execute(['password' => $hashedPassword, 'date' => $currentDate]);

        $registeredId = $this->pdo->lastInsertId();

        $stmt = $this->pdo->prepare("INSERT INTO users (user_id, username, email, role) VALUES (:user_id, :username, :email, :role)");
        $stmt->execute(['user_id' => $registeredId, 'username' => $username, 'email' => $email, 'role' => $role]);

        return $registeredId;
    }
}
