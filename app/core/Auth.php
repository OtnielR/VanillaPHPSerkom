<?php

require_once(__DIR__ . "/database.php");
require_once(__DIR__ . "/config.php");

class Auth
{
    public static function init(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public static function login(array $user): void
    {
        self::init();

        session_regenerate_id(true);

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_username"] = $user["username"];
        $_SESSION["user_email"] = $user["email"];
        $_SESSION["user_role"] = $user["role"] ?? "user";
        $_SESSION["is_logged_in"] = true;
    }

    public static function check(): bool
    {
        self::init();
        return isset($_SESSION["is_logged_in"]) && $_SESSION["is_logged_in"] === true;
    }

    public static function user(): array|null
    {
        self::init();

        if (self::check()) {
            return [
                "id" => $_SESSION["user_id"],
                "username" => $_SESSION["user_username"],
                "email" => $_SESSION["user_email"],
                "role" => $_SESSION["user_role"]
            ];
        }

        return null;
    }


    public static function requireAuth(): void
    {
        if (!self::check()) {
            header("Location: " . __BASEURL__ . "/view/login.php");
            exit;
        }
    }

    public static function requireGuest(): void
    {
        if (self::check()) {
            header("Location: " . __BASEURL__ . "/index.php");
            exit;
        }
    }

    public static function logout()
    {
        self::init();
        $_SESSION = [];

        session_destroy();
    }
}
