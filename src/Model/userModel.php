<?php

namespace Main\Model;

class userModel
{
    public $id;
    public $name;
    public $email;

    public function __construct($id = null, $name = '', $email = '')
    {
        $this->id = $id;
        $this->name = $name;
        $this->email = $email;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }
}