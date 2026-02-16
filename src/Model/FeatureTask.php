<?php

namespace Main\Model;

use Main\Model\taskModel;

class FeatureTask extends taskModel
{
    public function getType(): string
    {
        return 'feature';
    }
}
