<?php

namespace WebApp\Models;

/**
 * Class LoginForm
 * @package WebApp\Models
 */
class LoginForm
{
    public string $username;
    public string $password;
    public string $errorMessage;

    /**
     * @return bool
     */
    public function validate(): bool
    {
        return true;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function load(array $params): bool
    {
        $username = $params['username'];
        $password = $params['password'];
        if (isset($username) && isset($password)) {
            $this->username = $username;
            $this->password = $password;
            return true;
        }

        return false;
    }

    /**
     * @return false
     */
    public function signIn(): bool
    {
        $user = User::findOrCreate(['username' => $this->username]);
        if (empty($user->id)) {
            $user->setPassword($this->password);
            if ($user->save()) {
                // session start
            }

            $this->errorMessage = 'Failed to login: saving failed' . password_verify($this->password, $user->hashPassword('qwerty'));
            return false;
        } elseif ($user->validatePassword($this->password)) {
            // session start
        } else {
            $this->errorMessage = 'Failed to login: wrong password';
            return false;
        }

        return true;
    }

    /**
     * @return array
     */
    public function getViewAttributes(): array
    {
        return [
            'username' => $this->username,
            'errorMessage' => $this->errorMessage
        ];
    }

    /**
     * @return string[]
     */
    public static function attributeLabels(): array
    {
        return [
            'username' => 'Username',
            'password' => 'Password',
        ];
    }

}