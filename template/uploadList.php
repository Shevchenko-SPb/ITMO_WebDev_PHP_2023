<?php
$dir = "/uploads/";
var_dump($dir);
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while ( ($file = readdir($dh)) !== false) {
            echo "файл: $file, тип: " . filetype($dir . $file) . "\n";
        }
        closedir($dh);
    }
}
