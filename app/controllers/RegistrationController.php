<?php
class RegistrationController
{
    public function actionIndex()
    {
        $v = new ToDoView();

        $result = $v->render('registration.html', array());
        echo $result;
    }

}
