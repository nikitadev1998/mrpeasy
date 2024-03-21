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
        // TODO: validation
        // enable 'show password' function to end user
        // add additional rules to make password stronger
        // implement verifyPassword attribute
        // length validation of the values
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
            if ($id = $user->save()) {
                $_SESSION['username'] = $user->username;
                $_SESSION['counter'] = $user->counter ?? 0;
                return true;
            }

            $this->errorMessage = 'Failed to login: saving failed' . password_verify($this->password, $user->hashPassword('qwerty'));
            return false;
        } elseif ($user->validatePassword($this->password)) {
            // session start
            if (!isset($_SESSION['username'])) {
                $_SESSION['username'] = $user->username;
                $_SESSION['counter'] = $user->counter;
            }
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
            'errorMessage' => $this->errorMessage,
            'password' => $this->password
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