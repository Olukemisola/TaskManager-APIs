<?php

namespace Main\Model;

use Main\Strategy\HighPriorityStrategy;
use Main\Strategy\LowPriorityStrategy;
use Main\Strategy\PriorityStrategy;
use Main\Utils\DB;

abstract class taskModel{

protected $id;

protected $title;

protected $description;

protected $completed;

protected $assignedUser;
 protected  $priorityStrategy;


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
public function create(string $title, string $type): array
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


}



?>