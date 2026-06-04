<?php

class SessionHelper
{
    public static function init()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login($userId, $username, $role)
    {
        self.init();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['role'] = $role;
    }

    public static function logout()
    {
        self.init();
        unset($_SESSION['user_id']);
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        session_destroy();
    }

    public static function isLoggedIn()
    {
        self.init();
        return isset($_SESSION['username']);
    }

    public static function getUsername()
    {
        self.init();
        return $_SESSION['username'] ?? null;
    }

    public static function getUserId()
    {
        self.init();
        return $_SESSION['user_id'] ?? null;
    }

    public static function getRole()
    {
        self.init();
        return $_SESSION['role'] ?? 'guest';
    }

    public static function isAdmin()
    {
        return self::getRole() === 'admin';
    }
}
