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

        // Проверка на уникальность логина
        $user = new UserModel($login, UserModel::hashPassword($password));
        if ($user->checkLogin()) {
            echo "Логин уже занят";
            return;
        }

        // Хэширование пароля
        $hashedPassword = UserModel::hashPassword($password);
//        var_dump();

        // Создание нового пользователя
        $user = new UserModel($login, $hashedPassword);
        $user->create($name, $surname, $login, $hashedPassword);

        echo "Пользователь успешно создан";
    }
}

