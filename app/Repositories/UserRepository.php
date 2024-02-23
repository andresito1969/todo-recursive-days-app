<?php

namespace App\Repositories;
use App\Models\User;

class UserRepository implements UserRepositoryInterface {
    public function getUserById($id) {
        return User::findOrFail($id);
    }

    public function getAllUsers() {
        return User::all();
    }
}
