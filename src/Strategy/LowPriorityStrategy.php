<?php

namespace Main\Strategy;
use Main\Model\taskModel;
use Main\Strategy\PriorityStrategy;

class LowPriorityStrategy implements PriorityStrategy{
public function calculatePriority(taskModel $task)
{
    return 'low';
}


}

?>