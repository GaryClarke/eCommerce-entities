<?php

namespace App\Session;

interface SessionInterface
{
    public function has(string $key);

    public function get(string $key, mixed $default);

    public function set(string $key, mixed $value);

    public function clear();

    public function remove(string $key);
}