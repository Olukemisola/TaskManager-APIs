<?php
namespace Main\Strategy;
use Main\Model\taskModel;




interface PriorityStrategy{

public function calculatePriority(taskModel $task);




}







?>