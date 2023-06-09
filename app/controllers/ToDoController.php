<?php 



class ToDoController 
{
   public function actionIndex()
   {
      $count = new ToDoModel();
      $resultCount = $count->countUserTask();
      $v = new ToDoView();
      // var_dump(array_merge(array("name" => 1234), $resultCount));
      $result = $v->render('index.php', array_merge(array("name" => 1234), $resultCount));
      echo $result;
   }

}

