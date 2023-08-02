<?php

session_start();


define('ROOT', dirname(__FILE__));
require_once('./vendor/autoload.php');
class Router {

    // Хранит конфигурацию маршрутов.
    private $routes;

    function __construct($routesPath){
        // Получаем конфигурацию из файла.
        $this->routes = include($routesPath);
    }

    // Метод получает URI. Несколько вариантов представлены для надёжности.
    function getURI(){
        if(!empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }

        if(!empty($_SERVER['PATH_INFO'])) {
            return trim($_SERVER['PATH_INFO'], '/');
        }

        if(!empty($_SERVER['QUERY_STRING'])) {
            return trim($_SERVER['QUERY_STRING'], '/');
        }
    }

    function run(){
        // Получаем URI.
        $uri = $this->getURI();
        if (!$uri) {
            $uri = "login";
        }
        // Пытаемся применить к нему правила из конфигуации.
        foreach($this->routes as $pattern => $route){

            // Если правило совпало.
            if(preg_match("~$pattern~", $uri)){
                // Получаем внутренний путь из внешнего согласно правилу.
                $internalRoute = preg_replace("~$pattern~", $route, $uri);
                // Разбиваем внутренний путь на сегменты.
                $segments = explode('/', $internalRoute);
                // Первый сегмент — контроллер.
                $controller = ucfirst(array_shift($segments)).'Controller';
                // Второй — действие.

                $action = 'action'.ucfirst(array_shift($segments));
//                var_dump($action);
                // Остальные сегменты — параметры.
                $parameters = [];
                if ($segments) {

                    $segments = str_replace('?', '', $segments[0]);

                    parse_str($segments, $parameters);

                    var_dump($parameters);
                }




                $controllerFile = ROOT.'/app/controllers/'.$controller.'.php';
                if(file_exists($controllerFile)){

                    include($controllerFile);
                }
                $obj = new $controller();

//                var_dump($parameters);
                $obj->$action(...$parameters);

//                call_user_func_array(array($controller, $action), $params);
            }
        }
        // Ничего не применилось. 404.
//        header("HTTP/1.0 404 Not Found");
        return;
    }
}
$routes = ROOT.'/routes.php';
$router = new Router($routes);
$router->run();

















