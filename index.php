<?php

try {
    $db = new PDO('mysql:host=localhost;dbname=todo', 'root', '');
  } catch (PDOException $e) {
    print "Error!: " . $e->getMessage();
    die();
  };

class TodoModel{
  const SQL_SELECT_TASK_BY_ID = "SELECT tsk.id id_task, tsk.title, t.id id_tag, 
  t.name tag_name, s.id id_status, s.name st_name, ut.id_users id_user, u.name u_name 
                                   FROM task tsk , tag t, status s, user_task ut, `user` u
                                  WHERE tsk.id_status = s.id 
                                    AND tsk.id_tag  = t.id 
                                    AND ut.id_tasks = tsk.id 
                                    AND ut.id_users = u.id ";
  public function getTasks()
  {
      global $db;
      $stmt = $db->query(self::SQL_SELECT_TASK_BY_ID);
      $tasksAr = array();
      while ($row = $stmt->fetch())
      {
        $tasksAr[] = array(
          'id_task' => $row['id_task'],
          'title' => $row['title'],
          'id_tag' => $row['id_tag'],
          'tag_name' => $row['tag_name'],
          'id_status' => $row['id_status'],
          'st_name' => $row['st_name'],
          'u_name' => $row['u_name'],
        );
      }
      return $tasksAr;
  }
}
$obj = new TodoModel();
$tasksAr = $obj->getTasks();
?>
<ul>
  <?php foreach ($tasksAr as $task) { ?>
    <table border = "1">
        <tr><span><td align = "right">ID задачи: </td><td><?=$task['id_task']?></td></span></tr>
        <tr><span><td align = "right">Название задачи: </td><td><?=$task['title']?></td></span></tr>
        <tr><span><td align = "right">ID тега: </td><td><?=$task['id_tag']?></td></span></tr>
        <tr><span><td align = "right">Tag задачи: </td><td><?=$task['tag_name']?></td></span></tr>
        <tr><span><td align = "right">ID статуса: </td><td><?=$task['id_status']?></td></span></tr>
        <tr><span><td align = "right">Статус задачи: </td><td><?=$task['st_name']?></td></span></tr>
        <tr><span><td align = "right">Юзверь: </td><td><?=$task['u_name']?></td></span></tr>
        <tr><td colspan="2" align = "center"><button>Сменить статус</button></td></tr>
  </table>
  <?php } ?>
</ul>






//try {
//    $db = new PDO('mysql:host=localhost;dbname=todo', 'root', '');
//} catch (PDOException $e) {
//    print "Error!: " . $e->getMessage();
//    die();
//}
//
//$stmt = $db->query("SELECT * FROM tag");
//while ($row = $stmt->fetch())
//{
//    echo '<pre>';
//    print_r($row);
//}

//
//session_start();
//
//
//define('ROOT', dirname(__FILE__));
//require_once('./core/autoloader.php');
//class Router {
//
//    // Хранит конфигурацию маршрутов.
//    private $routes;
//
//    function __construct($routesPath){
//        // Получаем конфигурацию из файла.
//        $this->routes = include($routesPath);
//    }
//
//    // Метод получает URI. Несколько вариантов представлены для надёжности.
//    function getURI(){
//        if(!empty($_SERVER['REQUEST_URI'])) {
//            return trim($_SERVER['REQUEST_URI'], '/');
//        }
//
//        if(!empty($_SERVER['PATH_INFO'])) {
//            return trim($_SERVER['PATH_INFO'], '/');
//        }
//
//        if(!empty($_SERVER['QUERY_STRING'])) {
//            return trim($_SERVER['QUERY_STRING'], '/');
//        }
//    }
//
//    function run(){
//        // Получаем URI.
//        $uri = $this->getURI();
//        if (!$uri) {
//            $uri = "login";
//        }
//        // Пытаемся применить к нему правила из конфигуации.
//        foreach($this->routes as $pattern => $route){
//            // Если правило совпало.
//            if(preg_match("~$pattern~", $uri)){
//                // Получаем внутренний путь из внешнего согласно правилу.
//                $internalRoute = preg_replace("~$pattern~", $route, $uri);
//                // Разбиваем внутренний путь на сегменты.
//                $segments = explode('/', $internalRoute);
//                // Первый сегмент — контроллер.
//                $controller = ucfirst(array_shift($segments)).'Controller';
//                // Второй — действие.
//                $action = 'action'.ucfirst(array_shift($segments));
//                // Остальные сегменты — параметры.
//                $parameters = $segments;
//
//                $controllerFile = ROOT.'/app/controllers/'.$controller.'.php';
//                if(file_exists($controllerFile)){
//
//                    include($controllerFile);
//                }
//                // var_dump($controllerFile);
//                $obj = new $controller();
//                $obj->$action();
//                // var_dump($obj);
//                // var_dump($action);
////                call_user_func_array(array($controller, $action), $params);
//            }
//        }
//        // Ничего не применилось. 404.
////        header("HTTP/1.0 404 Not Found");
//        return;
//    }
//}
//$routes = ROOT.'/routes.php';
//$router = new Router($routes);
//$router->run();
//
//
//
//















//$count = 0;
//if (isset($_COOKIE["count"])) {
//    $count = $_COOKIE["count"] + 1;
//}
//setcookie("count", $count, time() + 3600);
//include "./template/index.html";
//echo "Вы посетили страницу: $count раз.";
//$size = "large";
//$var_array = [
//    "title" => "Загрузка документа",
//    "content" => "список загрузки",
//    "footer" => "@2023",
//];
//
//extract($var_array);
//
//$fullpath = "./template/upload.html";
//if (file_exists($fullpath)) {
//    ob_start();
//    include $fullpath;
//    #$page = !$output?ob_get_clean():true;
//    $page = ob_get_clean();
//} else {
//    throw new Exception("File does't exist!", 1);
//}
//echo $page;
