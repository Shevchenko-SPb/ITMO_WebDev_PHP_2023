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
    ?>
</div>
</body>
</html>


