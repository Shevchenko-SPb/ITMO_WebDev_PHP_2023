<?php

return array(
    'about' => 'about/index',
    'todo' => 'ToDo/index',
    'login' => 'Login/index',
    'loginCheck' => 'Login/check',
    'registration' => 'Registration/index',
    'page/([-_a-z0-9]+)' => 'page/show/$1',
    'users/([-_a-z0-9]+)' => 'users/show/$1',
//    'tasks' => 'ToDo/getList',
    'tasks' => 'ToDo/getTaskByIdDashboard/$1',
    'gettask' => 'ToDo/getTaskById',
    'createnewtask' => 'ToDo/createTask',
    'deleteusertask' => 'ToDo/deleteTask',
    'updatenewtask' => 'ToDo/updateTask',
    'createnewdashboard' => 'ToDo/createDashboard',
    'deleteuserdashboard' => 'ToDo/deleteDashboard',
    'getListdashboards' => 'ToDo/getListDashboards',
    'sse' => 'ToDo/sse',
    'logout' => 'ToDo/logout',
    'reguser' => 'Registration/CreateUser'
);