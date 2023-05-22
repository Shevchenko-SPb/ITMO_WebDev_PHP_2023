<?php
session_start();
include "./template/counter.php";
include "./template/index.html";


$size = "large";
$var_array = [
    "title" => "Загрузка документа",
    "content" => "список загрузки",
    "footer" => "@2023",
];

extract($var_array);

$fullpath = "./template/upload.html";
if (file_exists($fullpath)) {
    ob_start();
    include $fullpath;
    #$page = !$output?ob_get_clean():true;
    $page = ob_get_clean();
} else {
    throw new Exception("File does't exist!", 1);
}
echo $page;