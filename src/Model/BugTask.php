<?php

namespace Main\Model;

use Main\Model\taskModel;

class BugTask extends taskModel
{
     public function __construct($title) 
     {
        $this->title = $title;
     }
    public function getType(): string
    {
        return 'bug';
    }
}
