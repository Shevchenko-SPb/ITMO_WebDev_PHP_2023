<?php
$count = 0;
if (isset($_COOKIE["count"])) {
    $count = $_COOKIE["count"] + 1;
}
setcookie("count", $count, time() + 3600);
echo "Вы посетили страницу: $count раз.";
