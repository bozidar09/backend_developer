<?php

namespace Core;

class Session
{
    public static function get(string $key): array|string
    {
        if (isset($_SESSION['_flash'][$key])){
            $flash = $_SESSION['_flash'][$key];
            static::unflash($key);
            return $flash;
        }
        return $_SESSION[$key] ?? [];
    }

    public static function has(string $key): bool
    {
        return (bool)static::get($key);  // može i sa array_key_exists()
    }

    public static function put(string $key, array|string $value): void
    {
        $_SESSION[$key] = $value;
    }

    public static function flash(string $key, array|string $value): void
    {
        $_SESSION['_flash'][$key] = $value;
    }

    public static function unflash(string $key = null): void
    {
        if ($key) {
            unset($_SESSION['_flash'][$key]);
        } else {
            unset($_SESSION['_flash']);
        }
    }

    public static function clear(): void
    {
        $_SESSION = [];
    }

    public static function destroy(): void
    {
        static::clear();
        session_destroy();

        $params = session_get_cookie_params();
        setcookie('PHPSESSID', '', time() - 3600, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
}