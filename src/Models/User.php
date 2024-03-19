<?php

namespace WebApp\Models;

/**
 * Class User
 * @package WebApp\Models
 */
class User extends ActiveRecord
{
    public int $id;
    public string $username;
    public string $password_hash;
    public int $counter;

    /**
     * @param $password
     * @return bool
     */
    public function validatePassword($password): bool
    {
        return password_verify($this->password_hash, $this->hashPassword($password));
    }

    /**
     * @param $password
     * @return string
     */
    public function hashPassword($password): string
    {
        $options = [
            'memory_cost' => 1 << 14, // 16 MiB
            'time_cost'   => 4,       // 4 passes
            'threads'     => 2,       // 2 threads
        ];
        return password_hash($password, PASSWORD_ARGON2I, $options);
    }

    /**
     * @param $password
     * @return User
     */
    public function setPassword($password): User
    {
        $this->password_hash = $this->hashPassword($password);
        return $this;
    }
}