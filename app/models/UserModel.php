<?php
require_once __DIR__ . "/../../core/db_mysql.php";

class UserModel {
    public function __construct($login, $pass, $name = null, $surname = null, $href_avatar = null, $id = null)
    {
        $this->login = $login;
        $this->pass = $pass;
        $this->name = $name;
        $this->surname = $surname;
        $this->href_avatar = $href_avatar;
        $this->id = $id;
    }

    const SQL_SELECT_USER_BY_LOGIN = "SELECT id, login, pass, name, surname, href_avatar 
              FROM `user`  
             WHERE is_block = 0
               AND login LIKE '%s'
               AND pass LIKE '%s'";



    public function checkLogin ()
    {

        $db = DB::getDB();
        $sql = sprintf(self::SQL_SELECT_USER_BY_LOGIN, $this->login, $this->pass);
        $stmt = $db->query($sql);
        $result = $stmt->fetch(1);
        return $result;
    }
    static function hashPassword ($pass)
    {
        $salt = Config::instance()->get('salt');
        return sha1($pass . $salt);
    }

    const SQL_INSERT_USER = "INSERT INTO todo.`user`
(login, pass, dt_create, is_block, name, surname, href_avatar)
                             VALUES('%s', '%s', now(), 0, '%s', '%s', null)";

    public function create($name, $surname, $login, $password){
        $db = DB::getDB();
        $sql = sprintf(self::SQL_INSERT_USER, $this->login,  $this->pass,  $name,  $surname);
        $stmt = $db->query($sql);
        //добавить пользователя

    }

}
