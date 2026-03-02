<?php

namespace Main\Model;

use Main\Notifier\ObserverInterface as NotifierObserverInterface;
use Main\Observer\ObserverInterface;
use Main\Strategy\HighPriorityStrategy;
use Main\Strategy\LowPriorityStrategy;
use Main\Strategy\PriorityStrategy;
use Main\Utils\DB;
use PDO;

abstract class taskModel{

protected $id;

protected $title;

protected $description;

protected $completed;

protected $assignedUser;

 protected  $priorityStrategy;

 protected $observers;


  protected $conn;

    public function __construct(PriorityStrategy $priorityStrategy)
    { 
        $this->conn = DB::getInstance()->getConnection();
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
public function create($title, $type)
{
    // switch strategy based on type
    if ($type === "bug") {
        $this->setPriorityStrategy(new HighPriorityStrategy());
    } else {
        $this->setPriorityStrategy(new LowPriorityStrategy());
    }

    $priority = $this->calculatePriority();
    $sql= " INSERT INTO tasks ('title', 'type', 'priority')
        VALUES (:title,:type,:priority)";
    $stmt = $this->conn->prepare($sql);

    $stmt->execute([$title, $type, $priority]);

    return [
        "title" => $title,
        "type" => $type,
        "priority" => $priority
    ];
}

public function setCompleted( $taskId, $completed)
{
    $sql = "UPDATE tasks 
            SET completed = :completed 
            WHERE id = :id";

    $stmt = $this->conn->prepare($sql);

    $stmt->bindParam(':completed', $completed);
    $stmt->bindParam(':id', $taskId);

    if ($stmt->execute()) {

        $this->id = $taskId;
        $this->completed = $completed;

        // THIS triggers observers
        $this->notify();

        return true;
    }

    return false;
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