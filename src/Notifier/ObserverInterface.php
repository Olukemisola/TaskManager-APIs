<?php

namespace Main\Notifier;

interface ObserverInterface
{
    public function update(string $message);
}