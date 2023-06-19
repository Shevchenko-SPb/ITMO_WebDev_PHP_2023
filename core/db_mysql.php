<?php

require 'config.php';
$obj  = Config::instance();
define('HOST', $obj->get('host'));
define('PORT', $obj->get('port'));
define('DB', $obj->get('db'));
define('USER', $obj->get('user'));
define('PASS', $obj->get('pass'));

class DB {
  static function getDb() {
      try {
        $db = new PDO('mysql:host='.HOST.':'.PORT.';dbname='.DB, USER, PASS);
      } catch (PDOException $e) {
        print "Error!: " . $e->getMessage();
        die();
      }
      return $db;
    }
    
}

