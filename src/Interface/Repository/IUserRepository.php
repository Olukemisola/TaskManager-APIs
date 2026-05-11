<?php

namespace Main\Interface\Repository;

interface IUserRepository
{
    public function createUser($name, $email);

    public function getById($id);

    public function getAll();

    public function updateUser($id, $name, $email);

    public function deleteUser($id);
}
