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

    const SQL_GET_TASK_BY_ID = "SELECT tk.id_status, tg.name tag, tk.title, tk.dt_end
                                  FROM task tk, user_task ut, status st, tag tg
                                 WHERE st.id=tk.id_status 
                                   AND tg.id=tk.id_tag 
                                   AND ut.id_tasks = tk.id 
                                   AND tk.id = %d
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

    public function getTaskById ($id_task)
    {
        $id_task = array_shift($id_task);
        var_dump($id_task);
        $db = DB::getDb();
        $id_user = 1;
        $sql = sprintf(self::SQL_GET_TASK_BY_ID, $id_task, $id_user);
        var_dump($sql);
        $stmt = $db->query($sql);
        $tasks = [];
        while ($row = $stmt->fetch())
        {
            $tasks[] = $row;
        }
        return $tasks;
    }
    const SQL_CREATE_TASK = "INSERT INTO todo.task
                                (id_status, id_tag, title, dt_end, is_archive)
                                 VALUES(%d, %d, %s, %s, %d);";
    // ToDo: дописать insert задачи, подключить класс Publisher.
    public function createTask ()
    {   $sql1 = "INSERT INTO status 
                (name)
                VALUES('dff');";

//        $sql2 = "SELECT LAST_INSERT_ID();";

        $db = DB::getDb();

//        $id_user = Session::instance() -> get("id_user");
        //var_dump($db);
//        $sql = sprintf(self::SQL_GET_LIST_TASKS, $id_user);
        //var_dump($sql);
        $stmt = $db->query($sql1);
        var_dump($db->lastInsertId());
    }
}