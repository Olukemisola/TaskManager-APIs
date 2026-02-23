<?php

namespace Main\Model;

use Main\Model\taskModel;

class FeatureTask extends taskModel
{
     public function __construct($title) 
     {
        $this->title = $title;
     }
    public function getType(): string
    {
        return 'feature';
    }
}
