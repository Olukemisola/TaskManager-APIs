<?php

use Main\Utils\DB;

class taskModel{

public $id;

public $title;

public $description;

public $completed;

public $assignedUser;

  private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->getConnection();
    }

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