<?php

use Main\Utils\DB;

class userModel{


public $id;
public $name;
public $email;
 private $conn;

    public function __construct()
    {
        $this->conn = DB::getInstance()->getConnection();
    }

public function getId()
{

return $this->id;

}
public function getName(){

return $this->name;
}
public function getEmail(){

return $this->email;
}


}


?>