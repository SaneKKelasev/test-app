<?php

class UsersController
{
    private $userModel;
    private $authModel;

    public function __construct($userModel, $authModel)
    {
        $this->userModel = $userModel;
        $this->authModel = $authModel;
    }

    public function index()
    {
        $users = $this->userModel->getAll();
        $isLogged = $this->authModel->isLoggedIn();
        include_once dirname(__DIR__) . '/../views/users.php';
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            echo $name;
            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->userModel->create($name, $email, $password);
            header('Location: /');
        } else {
            $isNotFill = true;
            include_once dirname(__DIR__) . '/../views/create.php';
        }
    }

    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $this->userModel->delete($id);
            header('Location: /');
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            if ($this->authModel->login($email, $password)) {
                header('Location: /');
            } else {
                $error = 'Invalid email or password';
                include_once dirname(__DIR__) . '/../views/login.php';
            }
        } else {
            include_once dirname(__DIR__) . '/../views/login.php';
        }
    }

    public function logout()
    {
        $this->authModel->logout();
        header('Location: /');
    }
}
