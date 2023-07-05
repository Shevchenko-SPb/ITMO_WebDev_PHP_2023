<?php
require_once ('registry.php');
class SessionUser extends Registry
{
    private static $instance = null;
    private function  __construct() {
        session_start();
        var_dump("construct session user");
    }


    static function instance()
    {
        if (! isset(self::$instance) ) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function get($key)
    {
        if (isset($_SESSION[$key])) {
            return $_SESSION[$key];
        }
        return null;
    }
    public function set($key, $value): void
    {
        $_SESSION[$key] = $value;
    }
}