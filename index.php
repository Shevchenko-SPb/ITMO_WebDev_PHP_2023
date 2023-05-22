<?php
session_start();
$count = 0;
if (isset($_COOKIE['count'])) {
    $count = ($_COOKIE['count']) + 1;
}
setcookie('count', $count, time() + 3600);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
</head>
<body>
<form action='login.php' method='POST'>
    <input name='login'>
    <input name='password'>
    <input type="submit" name="Login" value="Login" />
    <input type="submit" name="Registration" value="Registration" />
</form>
<div>
    <?php
    echo "Вы посетили страницу: $count раз.";
    $size = "large";
    $var_array = array("title" => "Загрузка документа",
        "content"  => "список загрузки",
        "footer" => "@2023");

    extract($var_array);

    $fullpath = "./template/upload.html";
    if (file_exists($fullpath) ) {
        ob_start();
        include $fullpath;
        #$page = !$output?ob_get_clean():true;
        $page = ob_get_clean();
    } else {
        throw new Exception("File does't exist!", 1);
    }
    echo $page;
    ?>
</div>
</body>
</html>


