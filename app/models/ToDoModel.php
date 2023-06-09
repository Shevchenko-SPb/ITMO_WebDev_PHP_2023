<?php

require_once (__DIR__. "/../../core/db_mysql.php");
class ToDoModel {

    public function countUserTasks () {
        $stmt = $db->query("SELECT * FROM tag");
        while ($row = $stmt->fetch())
        {
            echo '<pre>';
            print_r($row);
        }
        return array(
            'count' => 2
        );
    }
}