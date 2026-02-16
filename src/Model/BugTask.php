<?php

namespace Main\Model;

use Main\Model\taskModel;

class BugTask extends taskModel
{
    public function getType(): string
    {
        return 'bug';
    }
}
