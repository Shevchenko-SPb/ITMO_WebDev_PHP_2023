<?php
session_start();
require_once "./etc/config.php";

$user_login = $_POST["login"];
$user_password = $_POST["password"];

$_SESSION["is_auth"] = false;
$_SESSION["is_auth_admin"] = false;

if (isset($_POST['Registration'])) {
    registrationUser();
}

function registrationUser()
{
    global $passwordBase, $user_login, $user_password;
    foreach ($passwordBase as $value) {
        $passwords = explode(";", $value);
        if ($passwords[1] == $user_login) {
            exit("Логин уже занят");
        }
    }
    if ($user_login == $user_password) {
        exit("Логин и пароль не должны совпадать!");
    } else {
        createUser();
        $_SESSION["is_auth"] = true;
        header("Location: ./app/templates/index.html");
    }
}

function createUser()
{
    global $file_User_DATA,
           $user_password,
           $user_login,
           $Token,
           $salt,
           $passwordBase;
    if (count($passwordBase) == null) {
        $uniqId = 1;
    } else {
        $uniqId = count($passwordBase) + 1;
    }
    $user_passwordMD5 = sha1($user_password . $salt);
    $data1 = "$uniqId;";
    $data2 = "$user_login;";
    $data3 = "$user_passwordMD5;";
    $data4 = "$Token\r\n";

    file_put_contents(
        $file_User_DATA,
        $data1 . $data2 . $data3 . $data4,
        FILE_APPEND
    );
}
