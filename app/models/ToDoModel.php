<?php

require_once (__DIR__ . "/../../core/db_mysql.php");


class ToDoModel
{
    const SQL_COUNT_USER_TASK = "SELECT ut.id_users, COUNT(ut.id_users)
                                 FROM user_task ut
                                WHERE ut.id_users  = %d
                             GROUP BY ut.id_users";
    
    const SQL_GET_LIST_TASKS = "SELECT tk.id_status, tg.name tag, tk.title, tk.dt_end
                                  FROM task tk, user_task ut, status st, tag tg
                                 WHERE st.id=tk.id_status 
                                   AND tg.id=tk.id_tag 
                                   AND ut.id_tasks = tk.id 
                                   AND ut.id_users = %d";                         
    public function countUserTask()
    {
        $db = DB::getDb();
        //var_dump($db);
        // $db = new PDO('mysql:host=localhost;dbname=todo', 'todo', '123');
        // $id_user = $_SESSION["id_user"];
        $id_user = 1;
        $sql = sprintf(self::SQL_COUNT_USER_TASK, $id_user);
        //var_dump($sql);
        $stmt = $db->query($sql);

        while ($row = $stmt->fetch())
        {
            echo '<pre>';
            print_r($row);
        }
        return array (
            'count' => 2
        );
    }
    public function getUserTasks()
    {
        $db = DB::getDb();
        //var_dump($db);
        $id_user = 1;
        $sql = sprintf(self::SQL_GET_LIST_TASKS, $id_user);
        //var_dump($sql);
        $stmt = $db->query($sql);
        $tasks = [];
        while ($row = $stmt->fetch())
        {
            $tasks[] = $row;
        }
        return $tasks;
    }
}