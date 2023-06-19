<?php
require ('helper.php');
define('DEV_CONFIG', __DIR__."/../dev_config.yaml");
define('PROD_CONFIG', __DIR__."/../prod_config.yaml");
define('DEV', 1);
define('PROD', 2);
define('TEST', 3);

abstract class Registry
{
    abstract protected function get($key);
    abstract protected function set($key, $val);
    
}

class Config extends Registry
{
    private static $instance;
    public static $type_cnf;
    private static $conf = array(DEV => DEV_CONFIG, PROD => PROD_CONFIG);
    private $config = [];
    private function  __construct() {
        //var_dump(self::$conf);
        $parser = CParamHandler::getInstance(self::$conf[self::$type_cnf]);
        $data = $parser->read();
        $this -> config = $data;
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
        if (isset($this->config[$key])) {
            return $this->config[$key];
        }
        return null;
    }
    public function set($key, $value) 
    {
        $this->config[$key] = $value;
    }
}
//Change status for config 
Config::$type_cnf = DEV;



class Session extends Registry
{
    private static $instance = null;
    private function  __construct() {
        session_start();
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
    public function set($key, $value) 
    {
        $_SESSION[$key] = $value;
    }
}


   