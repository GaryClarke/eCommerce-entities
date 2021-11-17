<?php

namespace App\Session;

class Session implements SessionInterface
{
    private bool $isStarted = false;

    public function isStarted(): bool
    {
        $this->isStarted = session_status() === PHP_SESSION_ACTIVE;

        return $this->isStarted;
    }

    public function start(): bool
    {
        if ($this->isStarted) {
            return true;
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            $this->isStarted = true;

            return true;
        }

        session_start();
        $this->isStarted = true;

        return true;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $_SESSION);
    }

    public function get(string $key, $default = null): mixed
    {
        if ($this->has($key)) {
            return $_SESSION[$key];
        }

        return $default;
    }

    public function set(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function clear(): void
    {
        $_SESSION = [];
    }

    public function remove(string $key): void
    {
        if ($this->has($key)) {
            unset($_SESSION[$key]);
        }
    }
}







