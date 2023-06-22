<?php
session_start();

echo 'Добро пожаловать на страницу 2<br />';

echo $_SESSION['id_user']; // green