<?php 


//var_dump($_SESSION['id_user']);
// $_SESSION['id_user'] = 100;
// exit(0);

require ('./core/helper.php');
define('CONFIG', "./config.yaml");

abstract class Registry
{
    abstract protected function get($key);
    abstract protected function set($key, $val);
    
}

class Config extends Registry
{
    private static $instance;
    private $config = [];
    private function  __construct() {
        $parser = CParamHandler::getInstance(CONFIG);
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



class Session extends Registry
{
    private static $instance = null;
    private function  __construct() {
        session_start([
            'cookie_lifetime' => 86400,
        ]);
       
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
        var_dump($_SESSION[$key]);
    }
}







//var_dump($_SESSION);
// $obj = new Registry();
$obj  = Session::instance()->get('id_user');
//var_dump($obj->set('db', 'todo')); 
//var_dump($obj->get('db')); 
 
 var_dump($obj);
 //$obj->set('id_user', 100);


