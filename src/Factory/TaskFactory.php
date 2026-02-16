<?php

namespace Main\Factory;
use Main\Model\BugTask;
use Main\Model\FeatureTask;
use Main\Model\taskModel;


class TaskFactory{


public static function create ($type, $title){

return match($type){
'bug'=> new BugTask($title),
'feature'=> new FeatureTask($title),
'default'=> throw new \Exception("Invalid task type: $type")


};

}
}











?>