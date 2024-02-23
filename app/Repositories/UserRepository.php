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
        return User::where('email', $mail)->first();
    }

    public function storeUser(array $data) : void {
        $user = new User($data);
        $user->save();
    }
}
