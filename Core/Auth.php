<?php
declare(strict_types=1);

namespace Core;

// core/Auth.php
// Simple Auth service that uses the User model and stores user info in $_SESSION.

// make sure the User model is available
require_once __DIR__ . '/../Model/User.php';

use Model\User;

class Auth
{
    protected Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

    /**
     * Attempt to log a user in.
     * Returns true on success, false otherwise.
     */
    public function login(string $email, string $password): bool
    {
        $userModel = $this->container->get(User::class);
        $user = $userModel->findByEmail($email);

        if ($user && password_verify($password, (string)$user['password'])) {
            $_SESSION['user'] = [
                'id'       => isset($user['iduser']) ? (int)$user['iduser'] : null,
                'email' => $user['email'],
                'nama'     => $user['nama'],
                'role'     => $user['role'] ?? 'user',
            ];
            return true;
        }

        return false;
    }

    /**
     * Is there a logged-in user?
     */
    public function check(): bool
    {
        return isset($_SESSION['user']);
    }

    /**
     * Return the current user session array or null.
     */
    public function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    /**
     * Return user id if present.
     */
    public function id(): ?int
    {
        return isset($_SESSION['user']['id']) ? (int)$_SESSION['user']['id'] : null;
    }

    /**
     * Return the current user's role.
     */
    public function role(): ?string
    {
        return $_SESSION['user']['role'] ?? null;
    }

    /**
     * Log out the current user (clears session user data).
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}
