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

    public function getUserByMail($mail) {
        return User::find()->where('email', $mail);
    }
}
