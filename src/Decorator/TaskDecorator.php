<?php

namespace Main\Decorator;

use Main\Interface\Services\ITaskService;

abstract class TaskDecorator implements ITaskService
{
    protected ITaskService $taskService;

    public function __construct(ITaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    public function getAllTasks()
    {
        return $this->taskService->getAllTasks();
    }

    public function getTaskById(int $id)
    {
        return $this->taskService->getTaskById($id);
    }

    public function createTask(array $data)
    {
        return $this->taskService->createTask($data);
    }

    public function updateStatus(int $id, $completed)
    {
        return $this->taskService->updateStatus($id, $completed);
    }
}
