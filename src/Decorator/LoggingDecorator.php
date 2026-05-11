<?php

namespace Main\Decorator;

class LoggingDecorator extends TaskDecorator
{
    public function getAllTasks()
    {
        error_log("Fetching all tasks");
        return parent::getAllTasks();
    }

    public function getTaskById(int $id)
    {
        error_log("Fetching task ID: " . $id);
        return parent::getTaskById($id);
    }

    public function createTask(array $data)
    {
        error_log("Creating task: " . json_encode($data));
        return parent::createTask($data);
    }

    public function updateStatus(int $id, $completed)
    {
        error_log("Updating task $id to " . $completed);
        return parent::updateStatus($id, $completed);
    }
}
