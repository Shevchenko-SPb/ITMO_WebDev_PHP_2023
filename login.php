<?php
session_start();


require_once "./etc/config.php";
require_once "./core/db_mysql.php";


require_once "./core/db_mysql.php";



$user_login = $_POST["login"];
$user_password = $_POST["password"];


$_SESSION["is_auth"] = false;
$_SESSION["is_auth_admin"] = false;



if (isset($_POST['Login'])) {
    // var_dump('stage 2');
    loginUser();
}
else if (isset($_POST['Registration'])) {
    header("Location: ./registration");
}
function loginUser()
{

    $login = $_POST['login'];
    $pass = $_POST["password"];
    $pass = sha1($pass . $salt);
    // var_dump($pass );
    $db = DB::getDB();
    $sql = "SELECT id, login, pass, name, surname, href_avatar 
              FROM `user`  
             WHERE is_block = 0
               AND login LIKE '%s'
               AND pass LIKE '%s'";
    $sql = sprintf($sql, $login, $pass);
    // var_dump($sql);
    $stmt = $db->query($sql);
    $result = $stmt->fetch(1);


    if($result){
        $_SESSION["is_auth"] = true;
        $_SESSION["id_user"] = $result["id"];
        $_SESSION["name"] = $result["name"];
        $_SESSION["surname"] = $result["surname"];
        $_SESSION["href_avatar"] = $result["href_avatar"];
        $_SESSION["is_auth"] = true;
    } else {
        $_SESSION["is_auth"] = false;
    }
    header('location: ./todo');
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

