<?php 



class ToDoController 
{
   public function actionIndex()
   {
      $count = new ToDoModel();
      $resultCount = $count->countUserTask();
      #todo: Дописать вывод профиля
      $name = $_SESSION["name"];
      $surname = $_SESSION["surname"];
      $href_avatar = $_SESSION["href_avatar"];
      $v = new ToDoView();
      // var_dump(array_merge(array("name" => 1234), $resultCount));
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
     /* $task1 = array(
         'id'=>'task_1686232804504', 
         'title'=> 'Что то там', 
         'date'=> '1686232804503', 
         'tag'=> 'Web'
      );*/
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
   }
}


