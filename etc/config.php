<?php
session_regenerate_id();

$userSessionId = session_id();
$userSession = str_replace(
    " ",
    "",
    $userSessionId . $_SERVER["REMOTE_ADDR"] . $_SERVER["HTTP_USER_AGENT"]
);
$Token = str_replace(";", ",", $userSession);
$file_User_DATA = "user_DATA.csv";
$passwordBase = file($file_User_DATA);
$salt = "-45dfeHK/";