<?php
class ToDoController 
{
   public function actionIndex()
   {   if (!$_SESSION["is_auth"] !== null && $_SESSION["is_auth"] == false) {
       header('Location: ./login');
   }
       $count = new ToDoModel();
       $resultCount = $count->countUserTask();
       #todo: Дописать вывод профиля
       $name = $_SESSION["name"];
       $surname = $_SESSION["surname"];
       $href_avatar = $_SESSION["href_avatar"];
       $v = new ToDoView();
       $result = $v->render('index.html', array_merge(array(
           "name" => $name,
           "surname" => $surname,
           "href_avatar" => $href_avatar), $resultCount));
       echo $result;
   }
   public function actionGetList()
   {
      $model = new ToDoModel();
      $result = $model -> getUserTasks();
      $tasks = array('result' => $result);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($tasks);
   }
   public function actionGetTaskById ($id_task)
   {
       $model = new ToDoModel();
       $result = $model -> getTaskById($id_task);
       $tasks = array('result' => $result);
       header('Content-Type: application/json; charset=utf-8');
       echo json_encode($tasks);
   }

   public function actionCreateTask ()
   {
       $model = new ToDoModel();
       $result = $model -> createTask();
       PublishController::publicTaskInRedis($result);
   }

   public function actionLogout ()
   {
       session_destroy();
       header('Location: ./login');
   }

   public function actionSse()
   {
       SubscribeController::subscribeForCreateTask();
   }
}


