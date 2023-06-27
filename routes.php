<?php

return array(
    'about' => 'about/index',
    'todo' => 'ToDo/index',
    'login' => 'Login/index',
    'registration' => 'Registration/index',
    'page/([-_a-z0-9]+)' => 'page/show/$1',
    'users/([-_a-z0-9]+)' => 'users/show/$1',
    'tasks' => 'ToDo/getList',
    'gettask' => 'ToDo/getTaskById',
    'sse' => 'Subscribe/index',
    'createtask' => 'ToDo/createTask'
);