<?php
require_once __DIR__ . "/../../core/session.php";
require_once __DIR__ . "/../../core/config.php";
require_once __DIR__ . "/../models/UserModel.php";

class LoginController
{
    public function actionIndex()
    {
        $v = new ToDoView();

        $result = $v->render('login.html', array());
        echo $result;
    }
    public function actionIndexCheck()
    {
        $login = $_POST['login'];
        $pass = $_POST["password"];

        $sessionInstance = SessionUser::instance();
        $sessionInstance->set("is_auth", false);
        $sessionInstance->set("is_auth_admin", false);
        var_dump($sessionInstance->get("is_auth"));

        $user = new UserModel($login, UserModel::hashPassword($pass));

        $result = $user->checkLogin();



        if($result){
            $sessionInstance->set("is_auth", true);
            $sessionInstance->set('id', $result["id"]);
            $sessionInstance->set('name', $result["name"]);
            $sessionInstance->set('surname', $result["surname"]);
            $sessionInstance->set('href_avatar', $result["href_avatar"]);
        } else {
            $sessionInstance->set("is_auth", false);
            $sessionInstance->set("is_auth_admin", false);
        }
        header('location: ./todo');
    }
}