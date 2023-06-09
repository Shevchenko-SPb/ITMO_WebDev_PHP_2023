<?php
session_start();

require_once "./etc/config.php";

$user_login = $_POST["login"];
$user_password = $_POST["password"];

$_SESSION["is_auth"] = false;
$_SESSION["is_auth_admin"] = false;

if (isset($_POST['Login'])) {
    loginUser();
}
else if (isset($_POST['Registration'])) {
    header("Location: ./registration");
}
function loginUser()
{
    global $passwordBase,
        $user_password,
        $user_login,
        $Token,
        $salt,
        $file_User_DATA;
    foreach ($passwordBase as &$value) {
        $passwords = explode(";", $value);
        if (
            $passwords[1] == $user_login &&
            $passwords[2] == sha1($user_password . $salt)
        ) {
            if ($user_login == "admin") {
                $passwords[3] = "$Token\r\n";
                $_SESSION["is_auth_admin"] = true;
                $value = implode(";", $passwords);
                file_put_contents($file_User_DATA, $passwordBase);
                header("Location: ./todo");
                break;
            } else {
                $_SESSION["is_auth"] = true;
                $passwords[3] = "$Token\r\n";
                $_SESSION["is_auth"] = true;
                $value = implode(";", $passwords);
                file_put_contents($file_User_DATA, $passwordBase);
                header("Location: ./todo");
                break;
            }
        } else {
            $_SESSION["is_auth"] = false;
            $_SESSION["is_auth_admin"] = false;
        }
    }echo "Неправильный логин или пароль";
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
        header("Location: ./user.php");
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
