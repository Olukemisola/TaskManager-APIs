<?php

namespace Main\Repository;

use Main\Interface\Repository\ITaskRepository;
use Main\Utils\DB;
use PDO;

class TaskRepository implements ITaskRepository
{
    private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->getConnection();
        // $this->conn = DB::getInstance();
    }

    public function createTask($title, $description, $completed, $assignedUser)
    {
        $sql = "INSERT INTO tasks (title, description, completed, assigned_user)
                VALUES (:title, :description, :completed, :assigned_user)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':completed' => $completed,
            ':assigned_user' => $assignedUser
        ]);
    }

    public function getById($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatus($id, $completed)
    {
        $sql = "UPDATE tasks SET completed = :completed WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':completed' => $completed,
            ':id' => $id
        ]);
    }
    public function updateTask($id, $title, $description, $assignedUser, $completed)
    {
        $sql = "UPDATE tasks 
            SET title = :title, description = :description, assigned_user = :assigned_user, completed = :completed
            WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        $update = $stmt->execute([
            ':title' => $title,
            ':description' => $description,
            ':assigned_user' => $assignedUser,
            ':completed' => $completed,
            ':id' => $id
        ]);
        return $update;
    }

    public function getAll()
    {
        $sql = "SELECT * FROM tasks";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function deleteTask($id)
    {
        $sql = "DELETE FROM tasks WHERE id = :id";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([':id' => $id]);
    }
}
