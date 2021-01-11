<?php

namespace App\Controller;

use App\Model\User;
use App\Traits\Auth;
use App\Exception\ValidationException;

class UserController
{
    public function index()
    {
        $users = User::findAll();

        $data = [
            'title' => 'Users',
            'users' => $users
        ];
        return view('user.user_list', $data);
    }

    public function registration(): string
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $data = [
                'title' => 'User registration',
            ];
            return view('user.user_registration', $data);
        }

        $errors = [];
        $data = $_POST;
        if (empty($data['email'])) {
            $errors['email'] = 'Cannot be empty';
        } else {
            if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = 'Invalid format';
            }
        }

        if (empty($data['password'])) {
            $errors['password'] = 'Cannot be empty';
        }

        if ($errors) {
            throw new ValidationException($errors);
        }

        $user = new User(
            $data['name'],
            $data['email'],
            $data['password'],
        );
        User::save($user);

        header('Location: /user');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            User::remove($id);
        }
        header('Location: /user');
        exit;
    }


}