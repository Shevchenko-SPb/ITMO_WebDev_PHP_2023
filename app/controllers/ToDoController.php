<?php 

class ToDoController 
{
   public function actionIndex()
   {
      $v = new ToDoView();
      $result = $v->render('index.html', array());
      echo $result;
   }

}

