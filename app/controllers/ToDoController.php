<?php 

class ToDoController 
{
   public function actionIndex()
   {
       $count new ToDoModel();
       $resultCount = $count->countUserTask();
      $v = new ToDoView();
      $result = $v->render('index.php', array());
      echo $result;
   }

}

