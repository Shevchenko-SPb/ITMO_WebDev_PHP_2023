<?php 
require_once(__DIR__.'/../../core/view.php');
class ToDoView extends View
{
   public function __construct()
   {
      var_dump('ToDo __constructor');
      $this->title;
   }
}

