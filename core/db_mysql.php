<?php
class DB {
    static function getDb() {
        try {
            $db = new PDO('mysql:host=localhost;dbname=todo', 'todo', '123');
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage();
            die();
        }
        return $db;
    }

}
