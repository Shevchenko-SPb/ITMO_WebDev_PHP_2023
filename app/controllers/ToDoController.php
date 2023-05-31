<?php 

class ToDoController 
{
   public function actionIndex()
   {
      // var_dump("action/inde1221x");
      // var_dump($action);
      // echo "ToDoController";
      $v = new ToDoView();
      // var_dump($v);
      
      $result = $v->render('index.html', array());
      var_dump($result);
      
   }

}

