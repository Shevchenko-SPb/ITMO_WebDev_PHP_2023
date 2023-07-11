<?php

require_once (__DIR__ . "/../../core/db_mysql.php");


class ToDoModel
{
    const SQL_COUNT_USER_TASK = "SELECT ut.id_users, COUNT(ut.id_users)
                                 FROM user_task ut
                                WHERE ut.id_users  = %d
                             GROUP BY ut.id_users";
    

    const SQL_GET_LIST_TASKS = "SELECT tk.id, tk.id_status, tg.name tag, tk.title, tk.dt_end, tk.body

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

    const SQL_INSERT_TASK = "INSERT INTO todo.task
                                (id_status, id_tag, title, body, dt_end, is_archive)
                                 VALUES(%d, %d, '%s','%s', '%s', NULL );";

    const SQL_CREATE_USER_TASK = "INSERT INTO todo.user_task
                                  (id_users, id_tasks, id_user_owner)   
                                  VALUES(%d, %d, %d);";

    const SQL_DELETE_USER_TASK = "DELETE FROM todo.task
                                 WHERE id = %d;";




    public function countUserTask()
    {
        $db = DB::getDb();
        // $db = new PDO('mysql:host=localhost;dbname=todo', 'todo', '123');
        // $id_user = $_SESSION["id_user"];
        $id_user = 1;
        $sql = sprintf(self::SQL_COUNT_USER_TASK, $id_user);
        $stmt = $db->query($sql);

        while ($row = $stmt->fetch())
        {
//            echo '<pre>';
//            print_r($row);
        }
        return array (
            'count' => 2
        );
    }
    public function getUserTasks()
    {
        $db = DB::getDb();
        $id_user = 1;
        $sql = sprintf(self::SQL_GET_LIST_TASKS, $id_user);
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
        $db = DB::getDb();
        $id_user = 1;
        $sql = sprintf(self::SQL_GET_TASK_BY_ID, $id_task, $id_user);
        $stmt = $db->query($sql);
        $tasks = [];
        while ($row = $stmt->fetch())
        {
            $tasks[] = $row;
        }
        return $tasks;
    }

    // ToDo: дописать insert задачи, подключить класс Publisher.
    public function createTask ($title, $body)
    {
        $db = DB::getDb();
        $sql = sprintf(self::SQL_INSERT_TASK, 1, 2, $title, $body, '2023-10-10');


        $db->query($sql);
        $id_task = $db->lastInsertId();
        $id_user = 1;
        $id_user_owner = 2;
        $sql = sprintf(self::SQL_CREATE_USER_TASK, $id_user, $id_task, $id_user_owner);
        $db->query($sql);
        return array('id_task'=>$id_task, 'id_user'=>$id_user);
    }

    public function deleteTask ($taskId)
    {
        $db = DB::getDb();
        $sql = sprintf(self::SQL_DELETE_USER_TASK, $taskId);
        $db->query($sql);
    }
}
//$sql1 = "INSERT INTO status
//                (name)
//                VALUES('dff');";
//
////        $sql2 = "SELECT LAST_INSERT_ID();";
//
//$db = DB::getDb();
//
////        $id_user = Session::instance() -> get("id_user");
////var_dump($db);
////        $sql = sprintf(self::SQL_GET_LIST_TASKS, $id_user);
////var_dump($sql);
//$db->query(self::SQL_CREATE_TASK);
//var_dump($db->lastInsertId());