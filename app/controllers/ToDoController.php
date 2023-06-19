<?php 



class ToDoController 
{
   public function actionIndex()
   {
      $count = new ToDoModel();
      $resultCount = $count->countUserTask();
      #todo: Дописать вывод профиля
      $name = $_SESSION['name'];
      $name = $_SESSION['avatar'];
      $name = $_SESSION['href'];
      $v = new ToDoView();
      // var_dump(array_merge(array("name" => 1234), $resultCount));
      $result = $v->render('index.php', array_merge(array("name" => 1234), $resultCount));
      echo $result;
   }

}


