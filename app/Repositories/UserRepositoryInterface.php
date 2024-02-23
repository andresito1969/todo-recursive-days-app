<?php

namespace App\Repositories;

interface UserRepositoryInterface{
    public function getUserById($id);

    public function getAllUsers();

    public function getUserByMail($mail);
}