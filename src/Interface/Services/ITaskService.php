<?php

namespace Main\Interface\Services;

interface ITaskService
{
    public function getTaskById(int $id);
    public function getAllTasks();
    public function createTask(array $data);
    public function updateStatus(int $id, $completed);
}
