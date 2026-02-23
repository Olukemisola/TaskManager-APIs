<?php

namespace Main\Strategy;
use Main\Model\taskModel;
use Main\Strategy\PriorityStrategy;

class HighPriorityStrategy implements PriorityStrategy{

public function calculatePriority(taskModel $task)
{
    return 'high';
}

}

?>