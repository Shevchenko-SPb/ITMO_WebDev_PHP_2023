<?php
require_once __DIR__ . "/../models/UserModel.php";
class RegistrationController
{
    public function actionIndex()
    {
        $v = new ToDoView();

        $result = $v->render('registration.html', array());
        echo $result;
    }
    public function actionCreateUser()
    {
        var_dump('register:', $_POST);
        $name = $_POST['name'];
        $surname = $_POST["surname"];
        $login = $_POST["login"];
        $password = $_POST["password"];

         $user = new UserModel($login, UserModel::hashPassword($password));
         $user->create($name, $surname, $login, $password);
//        $result = $user->checkLogin();

        //доделать проверку на уникальность логина
        //чтобы подставлялся хэш
    }

}
