<?php

namespace Main\Repository;

use Main\Interface\Repository\IUserRepository;

use Main\Utils\DB;
use PDO;

class UserRepository implements IUserRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->getConnection();
    }

    // Create a new user
    public function createUser($name, $email)
    {
        $sql = "INSERT INTO users (name, email) VALUES (:name, :email)";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name' => $name,
            ':email' => $email
        ]);
    }

    // Get user by ID
    public function getById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        $getUsers = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $getUsers;
    }

    public function updateUser($id, $name, $email)
    {
        $sql = "UPDATE users SET name = :name, email = :email WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':id' => $id,
            ':name' => $name,
            ':email' => $email
        ]);
    }
    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute(
            [
                ':id' => $id
            ]
        );
    }
}
