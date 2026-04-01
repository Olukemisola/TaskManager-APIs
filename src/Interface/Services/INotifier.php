<?php

namespace Main\Interface\Services;

interface INotifier
{
    public function update(string $target, string $message): bool;
}
