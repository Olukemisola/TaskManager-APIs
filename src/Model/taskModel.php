<?php

namespace Main\Model;

use Main\Utils\DB;

abstract class taskModel{

protected $id;

protected $title;

protected $description;

protected $completed;

protected $assignedUser;

  protected $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->getConnection();
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


}



?>