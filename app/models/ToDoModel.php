<?php

require_once (__DIR__ . "/../../core/db_mysql.php");


class ToDoModel
{
    const SQL_COUNT_USER_TASK = "SELECT ut.id_users, COUNT(ut.id_users)
                                 FROM user_task ut
                                WHERE ut.id_users  = %d
                             GROUP BY ut.id_users";

    const SQL_COUNT_PRIORITY_TASK = "SELECT DISTINCT p.id priority, ttk.count priority
                                         FROM priority p LEFT JOIN (
                                       SELECT DISTINCT tk.id_priority, count(tk.id_priority) as count
                                         FROM priority p, task tk, user_task ut
                                        WHERE p.id=tk.id_priority AND tk.id=ut.id_tasks AND ut.id_users=%d
                                     GROUP BY p.id) ttk
                                     ON p.id=ttk.id_priority GROUP BY p.id;";

    const SQL_GET_LIST_TASKS = "SELECT tk.id, tk.id_status, tg.name tag, tk.title, tk.dt_end, tk.body, tk.id_priority priority

                                  FROM task tk, user_task ut, status st, tag tg
                                 WHERE st.id=tk.id_status 
                                   AND tg.id=tk.id_tag 
                                   AND ut.id_tasks = tk.id
                                   AND ut.id_users = %d ORDER BY tk.id_priority DESC";

    const SQL_GET_TASK_BY_ID = "SELECT tk.id_status, tg.name tag, tk.title, tk.dt_end
                                  FROM task tk, user_task ut, status st, tag tg
                                 WHERE st.id=tk.id_status 
                                   AND tg.id=tk.id_tag 
                                   AND ut.id_tasks = tk.id 
                                   AND tk.id = %d
                                   AND ut.id_users = %d";

    const SQL_INSERT_TASK = "INSERT INTO todo.task
                                (id_status, id_tag, title, dt_end, is_archive, body, id_priority)
                                 VALUES(%d, %d, '%s','%s', NULL, '%s', %d);";

    const SQL_UPDATE_TASK = "UPDATE todo.task
                             SET id_status = %d, id_tag = %d, title = '%s', dt_end = '%s', is_archive = NULL, body = '%s', id_priority = %d
                             WHERE id = %d;";

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
        $id_user = $_SESSION["id"];
        $sql = sprintf(self::SQL_COUNT_USER_TASK, $id_user);
        $stmt = $db->query($sql);
        $row = $stmt->fetch();

        return array (
            'count' => $row['COUNT(ut.id_users)']
        );
    }

    public function countPriorityTask()
    {
        $db = DB::getDb();
        $id_user = $_SESSION["id"];
        $sql = sprintf(self::SQL_COUNT_PRIORITY_TASK, $id_user);
        $stmt = $db->query($sql);
        $priority_tasks = [];
        while ($row = $stmt->fetch())
        {
            $priority_tasks[] = $row;
        }
        return $priority_tasks;
    }

    public function getUserTasks()
    {
        $db = DB::getDb();
        $id_user = $_SESSION["id"];
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
    public function createTask ($_title, $_body, $_date, $_tag, $_priority)
    {
        $db = DB::getDb();
        $sql = sprintf(self::SQL_INSERT_TASK, 1, $_tag, $_title, $_date, $_body, $_priority);


        $db->query($sql);
        $id_task = $db->lastInsertId();
        $id_user = $_SESSION["id"];
        $id_user_owner = 2;
        $sql = sprintf(self::SQL_CREATE_USER_TASK, $id_user, $id_task, $id_user_owner);
        $db->query($sql);
        return array('id_task'=>$id_task, 'id_user'=>$id_user);
    }
    public function updateTask ($_title, $_body, $_id, $_date, $_tag, $_priority, $_status)
    {
        $db = DB::getDb();
        $sql = sprintf(self::SQL_UPDATE_TASK, $_status, $_tag, $_title, $_date, $_body, $_priority, $_id);
        $db->query($sql);
    }

    public function deleteTask ($task_Id)
    {
        $db = DB::getDb();
        $sql = sprintf(self::SQL_DELETE_USER_TASK, $task_Id);
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