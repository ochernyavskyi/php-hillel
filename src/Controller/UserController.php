<?php

namespace App\Controller;

use App\Model\User;
use App\Exception\ValidationException;

class UserController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User('users');
    }

    public function index()
    {
        $users = $this->userModel->findAll();

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

        $this->userModel->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ]);

        header('Location: /user');
        exit;
    }

    public function delete(): void
    {
        if (isset($_GET['id'])) {
            $id = (int)$_GET['id'];
            $this->userModel->remove($id);
        }
        header('Location: /user');
        exit;
    }


}