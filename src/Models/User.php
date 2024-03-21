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
        return password_verify($password, $this->password_hash);
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

    /**
     * @inheritDoc
     */
    public static function getTableName(): string
    {
        return 'user';
    }

    /**
     * @param $attributes
     * @return User|null
     */
    public static function findOne($attributes): ?ActiveRecord
    {
        return parent::findOne($attributes);
    }

    /**
     * @param array $attributes
     * @return User
     */
    public static function findOrCreate(array $attributes): ActiveRecord
    {
        return parent::findOrCreate($attributes);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}