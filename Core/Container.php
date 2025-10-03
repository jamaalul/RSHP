<?php

namespace Core;

use Model\User;
use mysqli;
use Exception;

class Container
{
    protected array $services = [];
    protected array $config;

    public function __construct(array $config = [])
    {
        $this->config = $config;

        // Register DB service lazily
        $this->set('db', function($c) {
            $db = $c->getConfig('db');
            $mysqli = new mysqli(
                $db['host'],
                $db['user'],
                $db['pass'],
                $db['name']
            );

            if ($mysqli->connect_error) {
                die("Database connection failed: " . $mysqli->connect_error);
            }

            // Always use utf8mb4
            $mysqli->set_charset("utf8mb4");
            return $mysqli;
        });

        // Register Auth service lazily
        $this->set('auth', function($c) {
            return new \Core\Auth($c);
        });

        // Register User model lazily
        $this->set(User::class, function ($c) {
            return new User($c);
        });
    }

    public function getConfig(string $key, $default = null)
    {
        return $this->config[$key] ?? $default;
    }

    public function set(string $name, callable $factory): void
    {
        $this->services[$name] = $factory;
    }

    public function get(string $name)
    {
        if (!isset($this->services[$name])) {
            throw new Exception("Service {$name} not found");
        }

        // Resolve only once
        if (is_callable($this->services[$name])) {
            $this->services[$name] = call_user_func($this->services[$name], $this);
        }

        return $this->services[$name];
    }
}
