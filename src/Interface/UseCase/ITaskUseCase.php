<?php

namespace Main\Interface\UseCase;

interface ITaskUseCase
{
    public function create($input);
    public function getAll();
    public function updateStatus($id, $Completed);
}
