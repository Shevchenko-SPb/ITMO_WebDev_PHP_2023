<?php
// echo 'upload.php';
// var_dump($_FILES["name"]);
// print($_FILES['userfile']['name']);
var_dump($_FILES);


$uploads_dir = 'C:\Users\Shevchenko\PhpstormProjects\ITMO_WebDev_PHP_2023\uploads';
$error = $_FILES["userfile"]["error"];
// foreach ($_FILES["userfile"]["error"] as $key => $error) {
// var_dump(UPLOAD_ERR_OK);
if ($error == 0) {
    $tmp_name = $_FILES["userfile"]["tmp_name"];
    // basename() может предотвратить атаку на файловую систему;
    // может быть целесообразным дополнительно проверить имя файла
    $name = basename($_FILES["userfile"]["name"]);
    $newName = $uploads_dir."/".$name;

    if (file_exists($uploads_dir."/".$name)) {
        $newName = renameUploadFile($newName);
    }
    move_uploaded_file($tmp_name, $newName);
    // }
}

function renameUploadFile($name) {
    $counter = 1;
    while (file_exists($name."_".$counter)) {
        $counter++;
    }
    return $name . "_" . $counter;
}
