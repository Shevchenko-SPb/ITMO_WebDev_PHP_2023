<?php

return array(
    'about' => 'about/index',
    'todo' => 'ToDo/index',
    'page/([-_a-z0-9]+)' => 'page/show/$1',
    'users/([-_a-z0-9]+)' => 'users/show/$1',
);