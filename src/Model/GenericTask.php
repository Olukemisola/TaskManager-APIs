<?php

namespace Main\Model;
use Main\Model\taskModel;
use Main\Strategy\LowPriorityStrategy;

class GenericTask extends taskModel
{
      public function __construct($title) 
     {
      $this->title = $title;
    $this->priorityStrategy = new LowPriorityStrategy(); // default

     }
    public function getType(): string
    {
        return 'generic';
    }
}