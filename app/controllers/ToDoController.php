<?php
class ToDoController 
{
   public function actionIndex()
   {   if (!$_SESSION["is_auth"] !== null && $_SESSION["is_auth"] == false) {
       header('Location: ./login');
   }
       $count = new ToDoModel();
//       $resultCount = $count->countUserTask();
       $resultPriority = $count->countPriorityTask();
       for ($i = 0; $i < 4; $i++) {
           $resultCountPriority[]=$resultPriority[$i][1]==NULL ? 0 : $resultPriority[$i][1];
       };
       #todo: Дописать вывод профиля
       $name = $_SESSION["name"];
       $idUser = $_SESSION["id"];
       $surname = $_SESSION["surname"];
       $href_avatar = $_SESSION["href_avatar"];
       $v = new ToDoView();
       $result = $v->render('index.html', array_merge(array(
           "name" => $name,
           "surname" => $surname,
           "priority" => $resultCountPriority,
           "href_avatar" => $href_avatar)));
       echo $result;
   }
   public function actionGetList()
   {
      $model = new ToDoModel();
      $result = $model -> getUserTasks();
      $tasks = array('result' => $result);
      header('Content-Type: application/json; charset=utf-8');
      echo json_encode($tasks);
   }
   public function actionGetTaskById ($id_task)
   {
       $model = new ToDoModel();
       $result = $model -> getTaskById($id_task);
       $tasks = array('result' => $result);
       header('Content-Type: application/json; charset=utf-8');
       echo json_encode($tasks);
   }
    public function actionGetTaskByIdDashboard ($id_dashboard)
    {
        $model = new ToDoModel();
        $id_dashboard = 'orfbO1690541873948';
        $result = $model -> getTaskByIdDashboard($id_dashboard);
        $tasks = array('result' => $result);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($tasks);
    }

    public function actionGetListDashboards()
    {
        $model = new ToDoModel();
        $result = $model -> getUserDashboards();
        $dashboards = array('result' => $result);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($dashboards);
    }
   public function actionCreateDashboard ()
   {
       $dashboardVOdata = json_decode(file_get_contents('php://input'),true);
       $_id = $dashboardVOdata[0];
       $_idUserOwner = $_SESSION["id"];
       $_dashboardName = $dashboardVOdata[1];
       $_idCol1 = $dashboardVOdata[2]; $_nameCol1 = $dashboardVOdata[3];
       $_idCol2 = $dashboardVOdata[4]; $_nameCol2 = $dashboardVOdata[5];
       $_idCol3 = $dashboardVOdata[6]; $_nameCol3 = $dashboardVOdata[7];
       $_idCol4 = $dashboardVOdata[8]; $_nameCol4 = $dashboardVOdata[9];
       $_idCol5 = $dashboardVOdata[10]; $_nameCol5 = $dashboardVOdata[11];
       $_idCol6 = $dashboardVOdata[12]; $_nameCol6 = $dashboardVOdata[13];
       $_idCol7 = $dashboardVOdata[14]; $_nameCol7 = $dashboardVOdata[15];
       $_idCol8 = $dashboardVOdata[16]; $_nameCol8 = $dashboardVOdata[17];
       $_idCol9 = $dashboardVOdata[18]; $_nameCol9 = $dashboardVOdata[19];
       $_idCol10 = $dashboardVOdata[20]; $_nameCol10 = $dashboardVOdata[21];

       $model = new ToDoModel();
       $result = $model -> createDashboard($_id, $_idUserOwner, $_dashboardName, $_idCol1, $_nameCol1,
                 $_idCol2, $_nameCol2, $_idCol3, $_nameCol3, $_idCol4, $_nameCol4, $_idCol5, $_nameCol5,
                 $_idCol6, $_nameCol6, $_idCol7, $_nameCol7, $_idCol8, $_nameCol8, $_idCol9, $_nameCol9, $_idCol10, $_nameCol10);
   }
   public function actionDeleteDashboard () {
       $dashboardData = json_decode(file_get_contents('php://input'),true);
       $_dashboardId = $dashboardData[0];
       $model = new ToDoModel();
       $model -> deleteDashboard($_dashboardId);
   }

   public function actionCreateTask ()
   {
       $taskVOdata = json_decode(file_get_contents('php://input'),true);
       $_title = $taskVOdata[0];
       $_body = $taskVOdata [1];
       $_date = $taskVOdata [2];
       $_tag = $taskVOdata [3];
       $_priority = $taskVOdata [4];
       $_status = $taskVOdata [5];
       $_dashboard = $taskVOdata [6];
       $model = new ToDoModel();
       $result = $model -> createTask($_title, $_body, $_date, $_tag, $_priority, $_status, $_dashboard);
       PublishController::publicTaskInRedis($result);
   }
   public function actionUpdateTask ()
   {
       $taskVOdata = json_decode(file_get_contents('php://input'),true);
       $_title = $taskVOdata[0];
       $_body = $taskVOdata [1];
       $_id = $taskVOdata [2];
       $_date = $taskVOdata [3];
       $_tag = $taskVOdata [4];
       $_priority = $taskVOdata [5];
       $_status = $taskVOdata [6];
       $_dashboard = $taskVOdata [7];

       $model = new ToDoModel();
       $model -> updateTask($_title, $_body, $_id, $_date, $_tag, $_priority, $_status, $_dashboard);
   }

   public function actionDeleteTask ()
   {
       $_taskId = json_decode(file_get_contents('php://input'),true);
       $model = new ToDoModel();
       $model -> deleteTask($_taskId);

   }

   public function actionLogout ()
   {
       session_destroy();
       header('Location: ./login');
   }

   public function actionSse()
   {
       SubscribeController::subscribeForCreateTask();
   }
}


