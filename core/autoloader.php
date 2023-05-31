<?php 
// namespace core\code\autoloader;
define ("CTRL" , __DIR__.'/../app/controllers/');
define ("MDL" , __DIR__.'/../app/models/');
define ("VW" , __DIR__.'/../app/view/');


class Autoloader 
{
    public static function register()
    {
        spl_autoload_register(function ($class_name) {
            // var_dump($class_name);
            foreach ( array(CTRL, MDL, VW) as $value ) {
                // $file = $value . strtolower($class_name) . '.php';
                $file = $value . $class_name . '.php';
                // var_dump($file);
                if (file_exists($file)){
                    
                    require $file;
                    // return true; 
                    
                }
     
            }
        
        });
    }
}
Autoloader::register();


// var_dump(__NAMESPACE__);
// $obj =  core\code\autoloader\Autoloader();