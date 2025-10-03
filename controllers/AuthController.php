<?php
class AuthController {
    private $auth;

    public function __construct($auth) {
        $this->auth = $auth;
    }

    public function loginForm() {
        include __DIR__ . '/../views/login.php';
    }

    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if ($this->auth->login($email, $password)) {
            header("Location: /dashboard");
            exit;
        } else {
            echo "Login Gagal.";
        }
    }

    public function logout() {
        $this->auth->logout();
        header("Location: /login");
    }
}
