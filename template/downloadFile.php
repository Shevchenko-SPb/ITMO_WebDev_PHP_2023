<?php

$dir = "./../uploads/";

foreach (scandir($dir) as $value) {
    $fileUrl = $dir . $value;
}

echo "hello";