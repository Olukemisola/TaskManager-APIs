<?php

namespace Main\Repository\MongoDB;

use Main\Interface\Repository\ITaskRepository;

class TaskRepository implements ITaskRepository
{
    public function createTask($title, $description, $completed, $assignedUser) {}

    public function getById($id) {}

    public function updateStatus($id, $completed) {}

    public function updateTask($id, $title, $description, $assignedUser, $completed) {}

    public function getAll() {}

    public function deleteTask($id) {}
}
