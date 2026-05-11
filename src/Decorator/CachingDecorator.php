<?php

namespace Main\Decorator;

class CacheDecorator extends TaskDecorator
{
    private array $cache = [];

    public function getTaskById(int $id)
    {
        if (isset($this->cache[$id])) {
            return $this->cache[$id];
        }

        $task = parent::getTaskById($id);
        $this->cache[$id] = $task;

        return $task;
    }

    public function getAllTasks()
    {
        if (isset($this->cache['all'])) {
            return $this->cache['all'];
        }

        $tasks = parent::getAllTasks();
        $this->cache['all'] = $tasks;

        return $tasks;
    }
}
