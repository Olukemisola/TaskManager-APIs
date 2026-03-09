<?php

namespace Main\Model;

use Main\Notifier\ObserverInterface as NotifierObserverInterface;
use Main\Strategy\HighPriorityStrategy;
use Main\Strategy\LowPriorityStrategy;
use Main\Strategy\PriorityStrategy;


abstract class taskModel{

protected $id;

protected $title;

protected $description;

protected $completed;

protected $assignedUser;

 protected  $priorityStrategy;

 protected $observers;


    public function __construct(PriorityStrategy $priorityStrategy)
    { 
        // $this->conn = DB::getInstance()->getConnection();
             $this->priorityStrategy = $priorityStrategy;

    }
        abstract public function getType(): string;


public function getId()
{
    return $this->id;
}

public function getTitle()
{
    return $this->title;
}

public function getDescription()
{
    return $this->description;
}

public function getAssignedUser()
{
    return $this->assignedUser;
}

    public function isCompleted()
    {
        return $this->completed;
    }
       public function setPriorityStrategy(PriorityStrategy $strategy): void
{
    $this->priorityStrategy = $strategy;
}

public function calculatePriority(): string
{
    return $this->priorityStrategy->calculatePriority($this);
}

    public function createTask($title, $type)
    {
        $this->title = $title;

        // switch strategy based on type
        if ($type === "bug") {
            $this->setPriorityStrategy(new HighPriorityStrategy());
        } else {
            $this->setPriorityStrategy(new LowPriorityStrategy());
        }

        $priority = $this->calculatePriority();

        return [
            "title" => $title,
            "type" => $type,
            "priority" => $priority,
             "description" => $this->description,
            "assignedUser" => $this->assignedUser
        ];
    }

public function setCompleted( $taskId, $completed)
{
      
        $this->id = $taskId;
        $this->completed = $completed;

        // notify observers when status changes
        $this->notify();

        return true;

}
public function attach(NotifierObserverInterface $observer): void
{
    $this->observers[] = $observer;
}
protected function notify(): void
{
    foreach ($this->observers as $observer) {
        $observer->update($this);
    }
}

}
?>