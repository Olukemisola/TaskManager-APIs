<?php

namespace Main\Service;

use Main\Interface\Services\ITaskService;
use Main\Interface\Repository\ITaskRepository;
use Main\Repository\TaskRepository;

class TaskServiceImpl implements ITaskService
{
    public function __construct(
        private readonly ITaskRepository $taskRepo
    ) {}

    public function getAllTasks()
    {
        return $this->taskRepo->getAll();
    }

    public function getTaskById(int $id)
    {
        return $this->taskRepo->getById($id);
    }

    // public function createTask(array $data)
    // {
    //     return $this->taskRepo->createTask();
    // }
    public function createTask(array $data)
    {
        return $this->taskRepo->createTask(
            $data['title'],
            $data['description'],
            $data['completed'] ?? 0,
            $data['assigned_user']
        );
    }
    public function updateStatus(int $id, $completed)
    {
        return $this->taskRepo->updateStatus($id, $completed);
    }
}
