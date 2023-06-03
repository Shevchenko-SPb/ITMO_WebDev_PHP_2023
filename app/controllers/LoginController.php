<?php
class LoginController
{
    public function actionIndex()
    {
        $v = new ToDoView();

        $result = $v->render('login.html', array());
        echo $result;
    }

}