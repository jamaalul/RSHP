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
            $userId = $user['iduser'];
            $roles = $userModel->getRolesForUser($userId);
            $_SESSION['user'] = [
                'id'       => $userId,
                'email' => $user['email'],
                'nama'     => $user['nama'],
                'roles'    => $roles,
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
     * Return the current user's roles.
     */
    public function roles(): array
    {
        return $_SESSION['user']['roles'] ?? [];
    }

    /**
     * Return the current user's role (first one for backward compatibility).
     */
    public function role(): ?string
    {
        $roles = $this->roles();
        return $roles[0] ?? null;
    }

    /**
     * Log out the current user (clears session user data).
     */
    public function logout(): void
    {
        unset($_SESSION['user']);
    }
}
